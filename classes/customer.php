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
 * File: flash_messages.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

class customer {

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
        $this->config = $config;

        if (!isset($_SESSION['customer'])) {
            $_SESSION['customer'] = [];
        }

        $this->customer = $_SESSION['customer'];
    }

    /**
     * Adds the customer details provided in the POST data to the session.
     *
     * @param $post_data
     */
    public function fill($post_data)
    {
        $_SESSION['customer'] = [
            'customer_id' => (isset($post_data['customer_id']) ? $post_data['customer_id'] : null),
            'first_name' => (isset($post_data['billing_first_name']) ? $post_data['billing_first_name'] : null),
            'last_name' => (isset($post_data['billing_last_name']) ? $post_data['billing_last_name'] : null),
            'email' => (isset($post_data['email']) ? $post_data['email'] : null),
            'telephone' => (isset($post_data['telephone']) ? $post_data['telephone'] : null),

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
                'country_id' => (isset($post_data['billing_country']) ? $post_data['billing_country'] : null),
                'country_name' => (isset($post_data['billing_country']) ? request($this->config, 'management', 'countries', $post_data['billing_country'])->name : null),
            ],

            'shipping_is_billing' => ($post_data['has_delivery']) ? false : true,
        ];

        // Set shipping address if necessary
        if (!$_SESSION['customer']['shipping_is_billing']) {
            // Shipping address
            $_SESSION['customer']['shipping_address'] = [
                'company' => (isset($post_data['shipping_company']) ? $post_data['shipping_company'] : null),
                'first_name' => (isset($post_data['shipping_first_name']) ? $post_data['shipping_first_name'] : null),
                'last_name' => (isset($post_data['shipping_last_name']) ? $post_data['shipping_last_name'] : null),
                'address_1' => (isset($post_data['shipping_address_1']) ? $post_data['shipping_address_1'] : null),
                'address_2' => (isset($post_data['shipping_address_2']) ? $post_data['shipping_address_2'] : null),
                'address_house_nr' => (isset($post_data['shipping_house_nr']) ? $post_data['shipping_house_nr'] : null),
                'city' => (isset($post_data['shipping_city']) ? $post_data['shipping_city'] : null),
                'postcode' => (isset($post_data['shipping_postcode']) ? $post_data['shipping_postcode'] : null),
                'country_id' => (isset($post_data['shipping_country']) ? $post_data['shipping_country'] : null),
                'country_name' => (isset($post_data['shipping_country']) ? request($this->config, 'management', 'countries', $post_data['shipping_country'])->name : null),
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
}