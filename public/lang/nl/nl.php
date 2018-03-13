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
 * File: nl.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

return [

    'page_titles' => [
        '404' => 'Hier gaat iets helemaal 404-fout',
        'about_us' => 'Over ons',
        'account' => 'Uw account',
        'checkout' => 'Afrekenen',
        'contact' => 'Contact',
        'customer_details' => 'Klantgegevens',
        'home' => 'Home',
        'order_confirmation' => 'Orderbevestiging',
        'product' => 'Product',
        'products' => 'Producten',
        'shopping_cart' => 'Winkelwagen',
        'support' => 'Ondersteuning',
    ],

    // CHANGES AT OWN RISK!
    'url' => [
        // Default pages
        'contact'				=> '/contact',
        'about_us'				=> '/over-ons',
        'terms_and_conditions'	=> '/onze-voorwaarden',
        'support'				=> '/support',
        'account'				=> '/mijn-account',
        // Products
        'products'	            => '/producten',
        'category_products'	    => '/producten/categorie/',
        // Product overview
        'product'				=> '/product/',
        // Shopping cart
        'shopping_cart'			=> '/winkelmandje',
        // Shopping cart add / remove
        'shopping_cart_add'		=> '/winkelmandje/toevoegen/',
        'shopping_cart_remove'	=> '/winkelmandje/verwijderen/',
        // Order routes
        'customer_details'		=> '/kantgegevens',
        'checkout'				=> '/bestellen/afrekenen',
        'confirmation'			=> '/bestellen/bevestiging'
    ],

    'http_errors' => [
        '404' => [
            'page_title' => 'Hier gaat iets helemaal 404-fout',
            'content' => '<p><img src="/images/404_image.gif" style="width: 50%;"></p><p>De opgevraagde pagina bestaat niet.</p><p>Wellicht was u op zoek naar <a href="/">de homepagina</a> of <a href="/support">de support-pagina</a>?',
            'footer' => '<p>Technisch contact: <a href="mailto:info@example.com">info@example.com</a></p>',
        ],
        '500' => [
            'page_title' => 'Interne server fout',
            'content' => '<p>Er is een onverwachte fout opgetreden!<br />Wij doen er alles aan de desbetreffende pagina zo snel mogelijk weer online te krijgen.</p>',
            'footer' => '<p>Technisch contact: <a href="mailto:info@example.com">info@example.com</a></p>',
        ]
    ]
];