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
 * File: ShoppingCart.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

class ShoppingCart
{
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
     * Returns the shopping_cart.
     *
     * @return array
     */
    public function get(): array
    {
        return $this->shopping_cart;
    }

    /**
     * Returns the shopping_cart as order products for the order insert request.
     *
     * @return array
     */
    public function getOrderProducts(): array
    {
        $order_products = [];

        foreach ($this->shopping_cart as $order_product) {
            $order_products[] = [
                "product_id" => $order_product['store_product']->product->id,
                "supplier_id" => $order_product['supplier_id'],
                "quantity" => $order_product['quantity'],
            ];
        }

        return $order_products;
    }

    /**
     * Sets the shopping_cart.
     *
     * @return void
     */
    public function setToSession(): void
    {
        $_SESSION['shopping_cart'] = $this->shopping_cart;
    }

    /**
     * Adds a product and the desired quantity to the shopping_cart in the session.
     *
     * @param int $store_product_id
     * @param int $quantity
     * @param int $supplier_id
     * @param object $store_product
     * @throws \Exception
     */
    public function addProduct(int $store_product_id, int $quantity, int $supplier_id, object $store_product)
    {
        if (!array_key_exists($store_product_id, $this->shopping_cart)) {
            $this->shopping_cart[$store_product_id] = [
                'store_product'     => $store_product,
                'quantity'          => $quantity,
                'supplier_id'       => $supplier_id,
            ];
        } else {
            $this->shopping_cart[$store_product_id]['store_product'] = $store_product;
            $this->shopping_cart[$store_product_id]['quantity'] += $quantity;
            $this->shopping_cart[$store_product_id]['supplier_id'] = $supplier_id;
        }

        $this->setToSession();
    }

    /**
     * Removes a product from the shopping_cart with the provided quantity.
     * If no quantity is provided the product will be completely removed from the shopping_cart.
     *
     * @param int $store_product_id
     * @param int|null $quantity
     */
    public function removeProduct(int $store_product_id, int $quantity = null): void
    {
        if ($quantity !== null) {
            $this->shopping_cart[$store_product_id]['quantity'] -= $quantity;

            if ($this->shopping_cart[$store_product_id]['quantity'] < 1) {
                unset($this->shopping_cart[$store_product_id]);
            }
        } else {
            unset($this->shopping_cart[$store_product_id]);
        }

        $this->setToSession();
    }

    /**
     * Updates the quantity of an order product in the shopping_cart in the session.
     *
     * @param int $product_id
     * @param int $quantity
     * @throws \Exception
     */
    public function updateProductQuantity(int $store_product_id, int $quantity): void
    {
        if (array_key_exists($store_product_id, $this->shopping_cart)) {
            $this->shopping_cart[$store_product_id]['quantity'] += $quantity;
        }

        $this->setToSession();
    }

    /**
     * Updates a product in the shopping_cart in the session.
     *
     * @param int $product_id
     * @param object $product
     * @throws \Exception
     */
    public function updateProduct(int $store_product_id, object $store_product = null): void
    {
        if (array_key_exists($store_product_id, $this->shopping_cart)) {
            if ($store_product !== null) {
                $this->shopping_cart[$store_product_id]['store_product'] = $store_product;
            } else {
                $this->shopping_cart[$store_product_id]['store_product'] = request($this->config, 'catalog', 'products', $store_product_id);
            }
        }

        $this->setToSession();
    }

    /**
     * Validates the product prices and checks if there's any changes.
     * If old and new prices do not match, return true. Default, return false.
     *
     * @todo
     *
     * @return bool
     * @throws \Exception
     */
    public function productPricesChanged(): bool
    {
        $price_changed = false;
        foreach ($this->shopping_cart as $order_product) {
            $store_product = $order_product['store_product'];
            $updated_store_product = request([], 'catalog', 'products', $store_product->id);

            // Get required variables
            $supplier_id = $order_product['supplier_id'];
            $shipping_country_id = customer()->get()['shipping_country_id'];

            if (
                $store_product->price_details->{$supplier_id}->total_price_ex !== $updated_store_product->price_details->{$supplier_id}->total_price_ex
                ||
                $store_product->price_details->{$supplier_id}->total_price_in !== $updated_store_product->price_details->{$supplier_id}->total_price_in
                ||
                $store_product->price_details->{$supplier_id}->shipping_costs->{$shipping_country_id}->total_price_ex !== $updated_store_product->price_details->{$supplier_id}->shipping_costs->{$shipping_country_id}->total_price_ex
                ||
                $store_product->price_details->{$supplier_id}->shipping_costs->{$shipping_country_id}->total_price_in !== $updated_store_product->price_details->{$supplier_id}->shipping_costs->{$shipping_country_id}->total_price_in
            ) {
                $this->updateProduct($store_product->id, $updated_store_product);
                $price_changed = true;
            }
        }

        return $price_changed;
    }

    /**
     * Returns the ShoppingCart overview with a sum of the total quantities and prices.
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
            $overview['subtotal_price']  += ($order_product['store_product']->price_details->{$order_product['supplier_id']}->total_price_in * $order_product['quantity']);
        }

        // Add shipping costs to the subtotal to calculate the total price
        $overview['total_price'] = $overview['subtotal_price'] + $overview['shipping_costs'];

        return $overview;
    }

    /**
     * @return float
     */
    private function calculateShippingCosts(): float
    {
        /** @var array $supplier_shipping_costs */
        $supplier_shipping_costs = [];
        $shipping_costs = 0;

        foreach ($this->shopping_cart as $order_product) {
            // Get required variables
            $supplier_id = $order_product['supplier_id'];
            $shipping_country_id = customer()->get()['shipping_country_id'];
            $price_details = $order_product['store_product']->price_details->{$supplier_id};
            $shipping_details = $price_details->shipping_costs->{$shipping_country_id};

            // See if highest tax rate has to be re-set
            if ($price_details->tax_rule->rate < 1.0) {
                $price_details->tax_rule->rate ++;
            }

            // Set shipping costs (ex. VAT)
            if (array_key_exists($price_details->supplier_id, $supplier_shipping_costs)) {
                // Not the first product of the supplier in the order. Check if the shipping_costs are higher than the ones we already noted.
                if ($supplier_shipping_costs[$price_details->supplier_id]['total_price_ex'] < $shipping_details->total_price_ex) {
                    $supplier_shipping_costs[$price_details->supplier_id]['total_price_ex'] = $shipping_details->total_price_ex;
                }

                if ($supplier_shipping_costs[$price_details->supplier_id]['tax_rate'] < $price_details->tax_rule->rate) {
                    $supplier_shipping_costs[$price_details->supplier_id]['tax_rate'] = $price_details->tax_rule->rate;
                }
            } else {
                // First product of the supplier. Add the shipping costs to the array
                $supplier_shipping_costs[$price_details->supplier_id]['total_price_ex'] = $shipping_details->total_price_ex;
                $supplier_shipping_costs[$price_details->supplier_id]['tax_rate'] = $price_details->tax_rule->rate;
            }
        }

        if (count($supplier_shipping_costs) > 0) {
            foreach ($supplier_shipping_costs as $supplier_id => $supplier_shipping_cost) {
                $shipping_costs += round($supplier_shipping_cost['total_price_ex'] * $supplier_shipping_cost['tax_rate'], 2);
            }
        }

        return $shipping_costs;
    }
}