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
require_once __DIR__ . '/../classes/static_page.php';

function route($route, $file, $static_page = false, $view = null, $view_vars = []) {

    $route = str_replace('/', '\/', $route);

    // Split get / post variables
    $_SERVER['REQUEST_URI'] = strtok($_SERVER['REQUEST_URI'], '?');

    $is_match =(bool) preg_match('/^' . ($route) . '$/',
	                    $_SERVER['REQUEST_URI'],
	                $matches, PREG_OFFSET_CAPTURE);


    if ($is_match && $static_page) {
        header ('HTTP/1.0 200 Found');
        $page = new static_page($view, $view_vars);
        echo $page->render();
        flash_messages()->reset();
        $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
        exit;
    } elseif ($is_match && $file && file_exists(__DIR__ . '/../controllers/' . $file . '.php')) {
    	twig()->default['page_title'] = ucwords(str_replace(['-', '_', '  '], ' ', $file));

    	header ('HTTP/1.0 200 Found');
        include_once __DIR__ . '/../controllers/' . $file . '.php';
	    flash_messages()->reset();
	    $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
        exit;
    }
}

// Home
route('/',null, true, 'home.html.twig', [
    'page_title' => lang('page_titles.home'),
    'base_uri' => url()
]);

// Default pages
route(lang('url.contact'), null, true, 'contact.html.twig', [
    'page_title' => lang('page_titles.contact'),
]);
route(lang('url.about_us'), null, true, 'about_us.html.twig', [
    'page_title' => lang('page_titles.about_us'),
]);
route(lang('url.terms_and_conditions'),null,true,'terms_and_conditions.html.twig', [
    'page_title' => lang('page_titles.terms_and_conditions'),
]);
route(lang('url.disclaimer_and_privacy'),null,true,'disclaimer_and_privacy.html.twig', [
    'page_title' => lang('page_titles.disclaimer_and_privacy'),
]);
route(lang('url.support'),null,true,'support.html.twig', [
    'page_title' => lang('page_titles.support'),
]);

// @todo
route(lang('url.account'), null, null, null, []);

// Products
route(lang('url.products'), 'products');
route(lang('url.category_products') . '(.*)', 'products');

// Product overview
route(lang('url.product') . '(.*)/(.*)', 'product');

// Shopping cart
route(lang('url.shopping_cart'), 'shopping_cart');
// Shopping cart add / remove
route(lang('url.shopping_cart_add') . '(.*)/(.*)', 'shopping_cart_update');
route(lang('url.shopping_cart_remove') . '(.*)/?(.*)?', 'shopping_cart_update');

// Order routes
route(lang('url.customer_details'), 'customer_details');
route(lang('url.checkout'), 'checkout');
route(lang('url.confirmation'), 'order_confirmation');

// Image routes
route('/assets/images/(.*)', 'images');

// Include package routes
include_once __DIR__ . '/../packages/index.php';

// Catch a 404
header ('HTTP/1.0 404 Not Found');
include_once __DIR__ . '/../errors/404.php';
flash_messages()->reset();
exit;