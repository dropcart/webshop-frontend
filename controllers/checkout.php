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

include __DIR__ . '/../classes/transaction.php';
// Initialize new transaction
$transaction = new transaction([]);
$payment_provider = config('payment_provider');

// Check / validate prices and notify user if they have changed
$price_changed = shopping_cart()->productPricesChanged();
if ($price_changed) {
    flash_messages()->setWarningMessages('De prijs is voor één of meerdere producten veranderd.');
}
//this is stripe code
//return from ideal authorization
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['source'])) {
    sendPayment($transaction->get()['order_id'], $_GET['source']);
}
//end stripe code
// POST actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$price_changed) {
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
            //if stripe is the sender and the redirect is given, redirect to authenticate the source
            if (isset($_POST['redirect']) && $payment_provider === 'stripe') {
                //save source to db?
                header('location: ' . $_POST['redirect']);
                exit();
            }
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
        //if stripe is the sender and the redirect is given, redirect to authenticate the source

        if (isset($_POST['redirect']) && $payment_provider === 'stripe') {
            //save source to db?
            header('location: ' . $_POST['redirect']);
            exit();
        }
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
$psp_public_key = request([], 'payment', 'key')->id;
$payment_methods = request([], 'payment', 'payment');
//$payment_methods = json_decode('[
//                                    {"id":1,"name":"iDEAL","active":1,"type":"ideal","psp":"stripe","mandate":0,"redirect":1,"cost":29,"variable_cost":0,"logo":"/images/payment/ideal.svg","extra":null},
//                                    {"id":2,"name":"Bancontact","active":1,"type":"bancontact","psp":"stripe","mandate":0,"redirect":1,"cost":25,"variable_cost":1.4,"logo":"/images/payment/bancontact.svg","extra":[{"id":1,"type":"selectable","paymentMethodsId":2,"fieldId":"name","fieldName":"name","pspVarName":"owner[name]"}]},
//                                    {"id":3,"name":"Giropay","active":1,"type":"giropay","psp":"stripe","mandate":0,"redirect":1,"cost":25,"variable_cost":1.4,"logo":"/images/payment/giropay.svg","extra":[{"id":2,"type":"selectable","paymentMethodsId":3,"fieldId":"name","fieldName":"name","pspVarName":"owner[name]"}]},
//                                    {"id":4,"name":"Sofort","active":1,"type":"sofort","psp":"stripe","mandate":0,"redirect":1,"cost":25,"variable_cost":1.4,"logo":"/images/payment/sofort.svg","extra":[{"id":3,"type":"selectable","paymentMethodsId":4,"fieldId":"country","fieldName":"country","pspVarName":"sofort[country]"}]},
//                                    {"id":5,"name":"SEPA direct debit","active":1,"type":"sepa_debit","psp":"stripe","mandate":1,"redirect":0,"cost":35,"variable_cost":0,"logo":"/images/payment/sepa.svg","extra":[{"id":4,"type":"selectable","paymentMethodsId":5,"fieldId":"iban","fieldName":"iban","pspVarName":"sepa_debit[iban]"},{"id":5,"type":"selectable","paymentMethodsId":5,"fieldId":"name","fieldName":"name","pspVarName":"owner[name]"}]},
//                                    {"id":6,"name":"MultiBanco","active":1,"type":"multibanco","psp":"stripe","mandate":0,"redirect":1,"cost":25,"variable_cost":2.95,"logo":"/images/payment/multibanco.svg","extra":[{"id":6,"type":"selectable","paymentMethodsId":6,"fieldId":"email","fieldName":"email","pspVarName":"owner[email]"}]},
//                                    {"id":7,"name":"Przelewy24","active":1,"type":"p24","psp":"stripe","mandate":0,"redirect":1,"cost":25,"variable_cost":2.2,"logo":"/images/payment/przelewy24.svg","extra":[{"id":7,"type":"selectable","paymentMethodsId":7,"fieldId":"email","fieldName":"email","pspVarName":"owner[email]"},
//                                    {"id":8,"type":"selectable","paymentMethodsId":7,"fieldId":"name","fieldName":"name","pspVarName":"owner[name]"}]}
//                                    ]');

//set the redirect url for stripe
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $redirect_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
} else {
    $redirect_url="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}
echo view('checkout.html.twig', [
    // Reset shopping cart and overview (in case update occured)
    'shopping_cart' => shopping_cart()->get(),
    'shopping_cart_overview' => shopping_cart()->overview(),
    // Payment methods for the store
    'payment_methods' => $payment_methods,
    // Warnings and errors
    'flash_messages' => flash_messages()->get(),
    'page_title' => lang('page_titles.checkout'),
    'psp_public_key' => $psp_public_key,
    'countries' => $countries,
    'redirect_url' =>$redirect_url
]);

function sendPayment($order_id, $source): void
{
    try {
        $order = request([], 'payment', 'orderPayment', [
            'order_id' => $order_id,
            'payment_method' => 'ideal',
            'payment_attributes' => $source,
        ], 'get');
    } catch (\Exception $e) {
        var_dump($e->getPrevious());
        die();
    }
    header('location: ' . $order);
    exit();
}