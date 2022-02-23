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
 * File: Customer.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

class Customer
{
    /**
     * @var array $customer
     */
    private $customer;

    /**
     * @var array $config
     */
    private $config;

    public function __construct($config)
    {
        global $shipping_country_id;
        $this->config = $config;

        if (!isset($_SESSION['customer'])) {
            $_SESSION['customer'] = [
                // Set to global (default) shipping country ID
                'shipping_country_id' => $shipping_country_id,
                'billing_address' => [
                    'country_id' => $shipping_country_id,
                ],
            ];
        }

        $this->customer = $_SESSION['customer'];
    }

    /**
     * Returns the customer from the session.
     *
     * @return array
     */
    public function get()
    {
        return $this->customer;
    }

    /**
     * @param array $customer
     */
    public function setToSession(array $customer): void
    {
        $_SESSION['customer'] = $customer;
    }

    /**
     * Adds the customer details provided in the POST data to the session.
     *
     * @param array $post_data
     * @throws \Exception
     */
    public function fill(array $post_data): void
    {
        $this->customer = [
            'customer_id' => (isset($post_data['customer_id']) ? $post_data['customer_id'] : null),
            'first_name' => (isset($post_data['billing_first_name']) ? $post_data['billing_first_name'] : null),
            'last_name' => (isset($post_data['billing_last_name']) ? $post_data['billing_last_name'] : null),
            'email' => (isset($post_data['email']) ? $post_data['email'] : null),
            'telephone' => (isset($post_data['telephone']) && $post_data['telephone'] !== '' ? $post_data['telephone'] : '06'),

            // Billing address
            'billing_address' => [
                'company' => (isset($post_data['billing_company']) ? $post_data['billing_company'] : null),
                'first_name' => (isset($post_data['billing_first_name']) ? $post_data['billing_first_name'] : null),
                'last_name' => (isset($post_data['billing_last_name']) ? $post_data['billing_last_name'] : null),
                'address_1' => (isset($post_data['billing_address_1']) ? $post_data['billing_address_1'] : null),
                'address_2' => (isset($post_data['billing_address_2']) ? $post_data['billing_address_2'] : null),
                'address_house_nr' => (isset($post_data['billing_house_nr']) ? $post_data['billing_house_nr'] : null),
                'city' => (isset($post_data['billing_city']) ? $post_data['billing_city'] : null),
                'postcode' => (isset($post_data['billing_postcode']) ? $post_data['billing_postcode'] : null),
                'country_id' => (isset($post_data['billing_country_id']) ? $post_data['billing_country_id'] : null),
                'country_name' => (isset($post_data['billing_country']) ? $post_data['billing_country'] : null),
            ],

            'shipping_is_billing' => ($post_data['has_delivery']) ? false : true,
        ];

        // Set shipping address if necessary
        if ($this->customer['shipping_is_billing'] === false) {
            // Shipping address
            $this->customer['shipping_address'] = [
                'company' => (isset($post_data['shipping_company']) ? $post_data['shipping_company'] : null),
                'first_name' => (isset($post_data['shipping_first_name']) ? $post_data['shipping_first_name'] : null),
                'last_name' => (isset($post_data['shipping_last_name']) ? $post_data['shipping_last_name'] : null),
                'address_1' => (isset($post_data['shipping_address_1']) ? $post_data['shipping_address_1'] : null),
                'address_2' => (isset($post_data['shipping_address_2']) ? $post_data['shipping_address_2'] : null),
                'address_house_nr' => (isset($post_data['shipping_house_nr']) ? $post_data['shipping_house_nr'] : null),
                'city' => (isset($post_data['shipping_city']) ? $post_data['shipping_city'] : null),
                'postcode' => (isset($post_data['shipping_postcode']) ? $post_data['shipping_postcode'] : null),
                'country_id' => (isset($post_data['shipping_country_id']) ? $post_data['shipping_country_id'] : null),
                'country_name' => (isset($post_data['shipping_country']) ? $post_data['shipping_country'] : null),
            ];

            $this->customer['shipping_country_id'] = $this->customer['shipping_address']['country_id'];
        } else {
            $this->customer['shipping_country_id'] = $this->customer['billing_address']['country_id'];
        }

        $this->setToSession($this->customer);
    }
}