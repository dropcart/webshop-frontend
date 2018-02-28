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
 * File: order_confirmation.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

// Initialize payment_status
$payment_status = '';

$twig_variables = [];

// Get order payment status
if (!isset($_GET['status'])) {
    // Redirect back to order checkout page with error message.
    // Payment is either cancelled or expired. A new payment_url should be generated.
    flash_messages()->setErrorMessages('De betaling is afgebroken of verlopen.<br>Indien u de bestelling toch door wilt voeren kunt u opnieuw uw betaalmethode selecteren en verder gaan naar de betaalpagina om uw bestelling af te ronden.');
    header("Location: " . lang('url.checkout'));
    exit();
} else {
    // Switch the order payment status and pass it on to the template.
    switch ($_GET['status']) {
        case 'paid':
            session_unset();
            // Set the shopping_cart_overview to null
            $twig_variables['shopping_cart_overview'] = null;
            $payment_status = 'paid';
            break;
        case 'open':
            $payment_status = 'open';
            break;
        case 'pending':
            session_unset();
            // Set the shopping_cart_overview to null
            $twig_variables['shopping_cart_overview'] = null;
            $payment_status = 'pending';
            break;
    }
}

$twig_variables['payment_status'] = $payment_status;

echo view('order_confirmation.html.twig', array_merge($twig_variables, [
    'payment_status' => $payment_status,
    'page_title' => lang('page_titles.order_confirmation'),
]));