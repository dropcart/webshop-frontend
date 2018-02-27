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
 * File: index.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

require_once __DIR__ . '/../includes/bootstrap.php';

function route($route, $file) {

    $route = str_replace('/', '\/', $route);

    // Split get / post variables
    $_SERVER['REQUEST_URI'] = strtok($_SERVER['REQUEST_URI'], '?');

    $is_match =(bool) preg_match('/^' . ($route) . '$/',
	                    $_SERVER['REQUEST_URI'],
	                $matches, PREG_OFFSET_CAPTURE);


    if ($is_match && file_exists(__DIR__ . '/../controllers/' . $file . '.php')) {
    	twig()->default['page_title'] = ucwords(str_replace(['-', '_', '  '], ' ', $file));

    	header ('HTTP/1.0 200 Found');
        include_once __DIR__ . '/../controllers/' . $file . '.php';
	    flash_messages()->reset();
	    $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
        exit;
    }
}

// Home
route('/', 'home');

// Default pages
route('/contact', 'contact');
route('/about-us', 'about_us');
route('/terms-and-conditions', 'about_us');
route('/support', 'support');
route('/account', 'account');

// Products
route('/products', 'products');
route('/products/category/(.*)', 'products');

// Product overview
route('/product/(.*)/(.*)', 'product');

// Shopping bag
route('/shopping-cart', 'shopping_cart');
// Shopping bag add / remove
route('/shopping-cart/add/(.*)/(.*)', 'shopping_cart_update');
route('/shopping-cart/remove/(.*)/(.*)', 'shopping_cart_update');

// Order routes
route('/customer-details', 'customer_details');
route('/order/checkout', 'checkout');
route('/order/confirmation', 'order_confirmation');

// Image routes
route('/assets/images/(.*)', 'images');

// Catch a 404
header ('HTTP/1.0 404 Not Found');
include_once __DIR__ . '/../controllers/404.php';
flash_messages()->reset();
exit;