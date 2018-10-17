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

    'site_header' => [
        'search_in_products' => 'Zoek binnen assortiment',
        'search' => 'Zoeken',
    ],

    'site_footer' => [
        'bottom_bar_text' => 'Alle prijzen zijn inclusief BTW - Merknamen zijn alleen gebruikt om de toepasbaarheid van producten aan te geven en dienen verder niet te worden geassocieerd met',
        'column_text' => '',
        'column_street' => '',
        'column_address' => '',
        'column_phone' => '',
        'column_email' => '',
    ],

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
        'terms_and_conditions' => 'Algemene voorwaarden',
        'disclaimer_and_privacy' => 'Disclaimer & Privacy',
    ],

    // CHANGES AT OWN RISK!
    'url' => [
        // Default pages
        'contact'				    => '/contact',
        'about_us'				    => '/over-ons',
        'terms_and_conditions'	    => '/algemene-voorwaarden',
        'disclaimer_and_privacy'    => '/disclaimer-en-privacy',
        'support'				    => '/support',
        'account'				    => '/mijn-account',
        // Products
        'products'	                => '/producten',
        'category_products'	        => '/producten/categorie/',
        // Product overview
        'product'				    => '/product/',
        // Shopping cart
        'shopping_cart'			    => '/winkelmandje',
        // Shopping cart add / remove
        'shopping_cart_add'		    => '/winkelmandje/toevoegen/',
        'shopping_cart_remove'	    => '/winkelmandje/verwijderen/',
        // Order routes
        'customer_details'		    => '/klantgegevens',
        'checkout'				    => '/bestellen/afrekenen',
        'confirmation'			    => '/bestellen/bevestiging'
    ],

    'page_home' => 	[
        'lead_title'            => 'Uw titel hier',
        'lead_text'             => 'ondertitel',
    ],

    'page_contact' => 	[
        'title' => 'Onze contactgegevens',
        'content' => '@Default::dynamic.page-contact',
        'emailaddress_desc' => 'E-mailadres',
        'emailaddress' => '',
        'phone_desc' => 'Telefoonnummer',
        'phone' => '',
        'address_desc' => 'Adres',
        'address' => '',
        'vat_desc' => 'BTW-nummer',
        'vat' => '',
        'coc_desc' => 'KvK-nummer',
        'coc' => '',
    ],

    'page_support' => [
        'content'               => 'Hieronder vindt u de meest gestelde vragen. Staat uw vraag of gewenste antwoord er niet tussen? <a href="contact">Neem dan contact met ons op</a>',

        'faq' => 		[
            '0' => 			[
                'q' => 'Q',
                'a' => 'A',
            ],
        ],
    ],

    /**
     * Make sure to assign the right data to the variables below.
     * These are required in the Terms and conditions, Privacy policy and Disclaimer and will set these pages up for you.
     */
    'page_disclaimer_and_privacy' => [
        /** Product range description used in the Terms and Conditions. We used an example below. */
        'product_range_description' => 'onder andere maar niet uitsluitend printerbenodigdheden en kantoorartikelen',
        'store_name' => config('site_name'),
        'store_location' => 'Alkmaar',
        'store_address' => '',
        'store_postal_code' => '',
        'store_chamber_of_commerce_number' => '',
        'store_vat_number' => '',
        'store_email' => '',
        'store_phone_number' => '',
        'store_url' => '',
        'court_province' => '',
        'court_location' => '',
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