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
 * File: transaction.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

require '../exceptions/InputException.php';

class transaction {

    /**
     * @var array $transaction
     */
    private $transaction = [];

    /**
     * @var array $config
     */
    private $config;

    public function __construct($config)
    {
        $this->config = $config;

        if (!isset($_SESSION['transaction']) && !empty($_SESSION['shopping_cart']) && !empty($_SESSION['customer'])) {

            $_SESSION['transaction'] = [
                'order_id' => null,
                'status' => null,
                'payment_method' => null,
                'payment_attributes' => [],
            ];

            $this->transaction = $_SESSION['transaction'];
        } elseif (isset($_SESSION['transaction'])) {
            $this->transaction = $_SESSION['transaction'];
        }
    }

    /**
     * After order insertion is completed, we set the transaction status to CONFIRMED and save the order ID to the transaction in the session.
     *
     * @param $order_id
     * @return null|$this
     */
    public function confirm($order_id)
    {
        if (isset($_SESSION['transaction'])) {
            $_SESSION['transaction']['order_id'] = $order_id;
            $_SESSION['transaction']['status'] = 'CONFIRMED';

            $this->transaction = $_SESSION['transaction'];

            return $this;
        } else {
            return null;
        }
    }

    /**
    /**
     * Sets the preferred payment method and its attributes to the transaction in the session.
     *
     * @param $post_data
     * @return $this
     * @throws InputException
     */
    public function setPaymentMethod($post_data)
    {
        if (isset($post_data['paymentMethod']) && isset($post_data['paymentMethodAttributes'])) {

            $_SESSION['transaction']['payment_method'] = $post_data['paymentMethod'];
            $_SESSION['transaction']['payment_attributes'] = $post_data['paymentMethodAttributes'];

        } else {
            throw new InputException ('', 0, null, [
                'Geen betaalmethode geselecteerd. Selecteer een betaalmethode om uw bestelling af te ronden.'
            ]);
        }

        $this->transaction = $_SESSION['transaction'];

        return $this;
    }

    /**
     * Returns the transaction from the session.
     *
     * @return array|null
     */
    public function get()
    {
        if (isset($_SESSION['transaction'])) {
            return $this->transaction;
        } else {
            return null;
        }
    }

}