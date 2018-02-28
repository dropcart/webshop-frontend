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
 * File: products.php
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

// Set the current page variable
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
};

// Explode request URI
$uri = trim( $_SERVER['REQUEST_URI'], "/" );
$uri = explode('/', $uri);

// Set get variable(s)
// $uri[2] will always be the category ID
if (isset($uri[2])) {
    $category_id = $uri[2];
    // Collect the current Category
    $category = request([], 'catalog', 'categories', $category_id);
} else {
    $category_id = null;
}

// Collect all filter options from the get variables (search query, brand, show products not in stock)
$filters = [
    'page'                      => (isset($_GET['page']) ? $_GET['page'] : null),
    'query'                     => (isset($_GET['query']) ? $_GET['query'] : null),
    'category_ids'              => [$category_id],
    'brand_ids'                 => (isset($_GET['brands']) ? $_GET['brands'] : null),
    'show_unavailable_items'    => (isset($_GET['show_unavailable_items']) && $_GET['show_unavailable_items'] == true ? true : false),
];

// Collect the products
$products = request([], 'catalog', 'products', $filters);

// Collect all Brands for the Store (for filtering purpose)
$brands = request([], 'catalog', 'brands');

// Add additional Twig variables here
$extra_twig_variables = [
	'products' => $products->products,
	'brands' => $brands,
	'total' => $products->total,
	'per_page' => $products->per_page,
	'current_page' => $current_page,
	'total_pages' => ceil($products->total / $products->per_page),

	// Query / filter input
	'selected_brands' => (isset($_GET['brands']) ? $_GET['brands'] : []),
	'search_query' => (isset($_GET['query']) ? $_GET['query'] : null),
	'show_unavailable' => (isset($_GET['show_unavailable_items']) && $_GET['show_unavailable_items'] == true ? true : false),

    'page_title' => lang('page_titles.products'),
];

// Form the page_title variable
if (isset($category))
    $extra_twig_variables['page_title'] = 'Producten in '.$category->name;

echo view('products.html.twig', $extra_twig_variables);
