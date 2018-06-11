<?php
/**
 * =========================================================
 * DROPCART
 * =========================================================
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * ---------------------------------------------------------
 *
 * File: shopping_cart.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

class shopping_cart {

    /**
     * @var array $shopping_cart
     */
    private $shopping_cart;

    /**
     * @var array $config
     */
    private $config;

    public function __construct($config)
    {
        $this->config = $config;

        if (!isset($_SESSION['shopping_cart'])) {
            $_SESSION['shopping_cart'] = [];
        }

        $this->shopping_cart = $_SESSION['shopping_cart'];
    }

    /**
     * Adds a product and the desired quantity to the shopping_cart in the session.
     *
     * @param $product_id
     * @param $quantity
     */
    public function addProduct($product_id, $quantity)
    {
        if (!key_exists($product_id, $_SESSION['shopping_cart'])) {
            $_SESSION['shopping_cart'][$product_id] = [
                'product'     => request($this->config, 'catalog', 'products', $product_id),
                'quantity'    => $quantity,
            ];
        } else {
            $_SESSION['shopping_cart'][$product_id]['quantity'] += $quantity;
        }

        $this->shopping_cart = $_SESSION['shopping_cart'];
    }

    /**
     * Removes a product from the shopping_cart with the provided quantity.
     * If no quantity is provided the product will be completely removed from the shopping_cart.
     *
     * @param $product_id
     * @param int|null $quantity
     */
    public function removeProduct($product_id, $quantity = null)
    {
        if ($quantity) {
            if ($_SESSION['shopping_cart'][$product_id]['quantity'] <= 1) {
                unset($_SESSION['shopping_cart'][$product_id]);
            } else {
                $_SESSION['shopping_cart'][$product_id]['quantity'] -= 1;
            }
        } else {
            unset($_SESSION['shopping_cart'][$product_id]);
        }

        $this->shopping_cart = $_SESSION['shopping_cart'];
    }

    /**
     * Updates a product in the shopping_cart in the session.
     *
     * @param $product_id
     * @param $product
     */
    public function updateProduct($product_id, $product = null)
    {
        if (key_exists($product_id, $_SESSION['shopping_cart'])) {
            if ($product) {
                $_SESSION['shopping_cart'][$product_id]['product'] = $product;
            } else {
                $_SESSION['shopping_cart'][$product_id]['product'] = request($this->config, 'catalog', 'products', $product_id);
            }
        }

        $this->shopping_cart = $_SESSION['shopping_cart'];
    }

    /**
     * Validates the product prices and checks if there's any changes.
     * If old and new prices do not match, return true. Default, return false.
     *
     * @return bool
     */
    public function productPricesChanged()
    {
        $price_changed = false;
        foreach ($_SESSION['shopping_cart'] as $order_product) {
            $product = $order_product['product'];
            $updated_product = request([], 'catalog', 'products', $product->id);

            if (
                $product->price_details->piece_price->ex != $updated_product->price_details->piece_price->ex ||
                $product->price_details->piece_price->in != $updated_product->price_details->piece_price->in ||
                $product->price_details->shipping_costs_ex != $updated_product->price_details->shipping_costs_ex ||
                $product->price_details->shipping_costs_in != $updated_product->price_details->shipping_costs_in
            ) {
                $this->updateProduct($product->id, $updated_product);
                $price_changed = true;
            }
        }

        return $price_changed;
    }

    /**
     * Returns the shopping_cart.
     *
     * @return array
     */
    public function get()
    {
        return $this->shopping_cart;
    }

    /**
     * Returns the shopping_cart overview with a sum of the total quantities and prices.
     *
     * @return array
     */
    public function overview()
    {
        $overview = [];

        $overview['total_products'] = 0;
        $overview['subtotal_price']    = 0;
        $overview['shipping_costs'] = $this->calculateShippingCosts();
        $overview['total_price']    = 0;

        foreach ($this->shopping_cart as $order_product)
        {
            $overview['total_products'] += $order_product['quantity'];
            $overview['subtotal_price']    += ($order_product['product']->price_details->piece_price->in * $order_product['quantity']);
        }

        // Add shipping costs to the subtotal to calculate the total price
        $overview['total_price'] = $overview['subtotal_price'] + $overview['shipping_costs'];

        return $overview;
    }

    private function calculateShippingCosts()
    {
        /** @var array $supplier_shipping_costs */
        $supplier_shipping_costs = [];
        $shipping_costs = 0;

        foreach ($this->shopping_cart as $order_product) {
            $shipping_details = $order_product['product']->shipping_details;

            if (array_key_exists($shipping_details->supplier_id, $supplier_shipping_costs)) {
                // Not the first product of the supplier in the order. Check if the shipping_costs are higher than the ones we already noted.
                if ($supplier_shipping_costs[$shipping_details->supplier_id] < $shipping_details->shipping_costs_ex) {
                    $supplier_shipping_costs[$shipping_details->supplier_id] = $shipping_details->shipping_costs_in;
                }
            } else {
                // First product of the supplier. Add the shipping costs to the array
                $supplier_shipping_costs[$shipping_details->supplier_id] = $shipping_details->shipping_costs_in;
            }
        }

        if (count($supplier_shipping_costs) > 0) {
            foreach ($supplier_shipping_costs as $supplier_shipping_cost) {
                $shipping_costs += $supplier_shipping_cost;
            }
        }

        return $shipping_costs;
    }
}