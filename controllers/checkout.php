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

include __DIR__ . '/../Classes/Transaction.php';

// Initialize new Transaction
$transaction = new Transaction([]);
$payment_provider = config('payment_provider');

$additional_twig_variables = [];

// Check / validate prices and notify user if they have changed
$price_changed = shopping_cart()->productPricesChanged();
if ($price_changed === true) {
    flash_messages()->setWarningMessages('De prijs is voor één of meerdere producten veranderd.');
}

// POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$price_changed) {
    // Check if the order is confirmed
    if (isset($_POST['conditions']) && $_POST['conditions']) {
        try {
            // Insert and confirm
            $order_id = request([], 'order', 'orders', [
                'order_products' => shopping_cart()->getOrderProducts(),
                'customer_details' => customer()->get(),
                'payment_return_url' => url() . lang('url.confirmation'),
            ], 'post');

            $transaction = $transaction->confirm($order_id)->setPaymentMethod($_POST)->get();

            // Generate payment link for the Order
            $payment_url = request([], 'payment', 'orderPayment', $transaction);
            header('Location: ' . $payment_url);
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
            header('Location: ' . $payment_url);
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

$payment_methods = json_decode(request([], 'payment', 'payment'));

echo view('checkout.html.twig', array_merge([
        // Reset shopping cart and overview (in case update occured)
        'shopping_cart' => shopping_cart()->get(),
        'shopping_cart_overview' => shopping_cart()->overview(),
        // Payment methods for the store
        'payment_methods' => $payment_methods,
        // Warnings and errors
        'flash_messages' => flash_messages()->get(),
        'page_title' => lang('page_titles.checkout'),
        'countries' => $countries,
    ], $additional_twig_variables)
);