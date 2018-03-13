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
 * File: checkout.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

include __DIR__.'/../classes/transaction.php';

// Initialize new transaction
$transaction = new transaction([]);

// POST actions
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // Check if the order is confirmed
    if (isset($_POST['conditions']) && $_POST['conditions']) {

        try {
            // Insert and confirm
            $order = request([], 'order', 'orders', [
                'shopping_cart' => shopping_cart()->get(),
                'customer_details' => customer()->get(),
                'payment_return_url' => url() . lang('url.confirmation'),
            ], 'post');

            $transaction = $transaction->confirm($order->id)->setPaymentMethod($_POST)->get();
            // Generate payment link for the Order
            $payment_url = request([], 'payment', 'orderPayment', $transaction);

            header('Location: '.$payment_url);
            exit();
        } catch (InputException $e) {
            flash_messages()->setWarningMessages($e->getErrors());
            back();
        } catch (\Exception $e) {
            die();
        }

    } elseif (isset($transaction->get()['order_id'])) {

        try {
            $transaction = $transaction->setPaymentMethod($_POST)->get();
            // Generate payment link for the Order
            $payment_url = request([], 'payment', 'orderPayment', $transaction);

            header('Location: '.$payment_url);
            exit();
        } catch (InputException $e) {
	        flash_messages()->setWarningMessages($e->getErrors());
            back();
        } catch (\Exception $e) {
            die();
        }

    }

    header('location: ' . lang('url.checkout'));
}

// Collect all countries
$countries = request([], 'management', 'countries');

// Collect the store his payment methods
$payment_methods = json_decode(request([], 'payment', 'payment'));

echo view('checkout.html.twig', [
	// Pass the shopping cart to the template
	'shopping_cart' => shopping_cart()->get(),
	// Payment methods for the store
	'payment_methods' => $payment_methods,
	// Warnings and errors
	'flash_messages' => flash_messages()->get(),
    'page_title' => lang('page_titles.checkout'),
]);