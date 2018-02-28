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
 * File: shopping_cart_update.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

// Explode request URI
$uri = trim( $_SERVER['REQUEST_URI'], "/" );
$uri = explode('/', $uri);

// Skip adding / removing product if transaction status == confirmed
if (isset($_SESSION['transaction']) && $_SESSION['transaction']['status'] == "CONFIRMED") {
    back();
}

if ('/'.$uri[0].'/'.$uri[1].'/' == lang('url.shopping_cart_add')) {
	shopping_cart()->addProduct($uri[2], $uri[3]);
}
elseif ('/'.$uri[0].'/'.$uri[1].'/'== lang('url.shopping_cart_remove'))  {
    $quantity = (isset($uri[3]) ? $uri[3] : null);
    shopping_cart()->removeProduct($uri[2], $quantity);
}

back();