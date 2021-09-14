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
 * File: product.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

// Set up query string to share in the template
if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) {
    $query_string = removeqsvar('?'.$_SERVER['QUERY_STRING'], 'page');
	twig()->environment->addGlobal("query_string", $query_string);
}

// Explode request URI
$uri = trim( request_uri(config('base_url')), "/" );
$uri = explode('/', $uri);

// Set product ID
$product_id = $uri[1];

// Collect the products
$store_product = request([], 'catalog', 'products', $product_id);
$attributes = (array) $store_product->product->attributes[0]->attributes;

echo view('product.html.twig', [
	// Overwrite default page title
	'page_title' => $store_product->product->translations->{get_locale_id()}->name,
	'store_product' => object_to_array($store_product),
    'attributes' => $attributes,
]);
