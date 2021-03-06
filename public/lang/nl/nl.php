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
        'top_bar_column_1' => '',
        'top_bar_column_2' => '',
        'top_bar_column_3' => '',
        'top_bar_glyphicon_1' => '',
        'top_bar_glyphicon_2' => '',
        'top_bar_glyphicon_3' => '',
    ],

    'site_footer' => [
        'bottom_bar_text' => 'Alle prijzen zijn inclusief BTW - Merknamen zijn alleen gebruikt om de toepasbaarheid van producten aan te geven en dienen verder niet te worden geassocieerd met',
        'column_text' => 'Optioneel tekstvak boven adresgegevens',
        'column_street' => 'Uw straat',
        'column_address' => 'POSTCODE Plaats, Land',
        'column_phone' => '(+31) (0) 12-345678',
        'column_email' => 'uw@emailadres.nl',
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

    'url' => [
        // CHANGES AT OWN RISK!
        'base'                      => config('base_url'),
        'home'				        => '/',
        'contact'				    => '/contact',
        'about_us'				    => '/over-ons',
        'terms_and_conditions'	    => '/algemene-voorwaarden',
        'disclaimer_and_privacy'    => '/disclaimer-en-privacy',
        'support'				    => '/support',
        'account'				    => '/mijn-account',
        'products'	                => '/producten',
        'category_products'	        => '/producten/categorie/',
        'product'				    => '/product/',
        'shopping_cart'             => '/winkelmandje',
        'shopping_cart_add'		    => '/winkelmandje/toevoegen/',
        'shopping_cart_update'		=> '/winkelmandje/update/',
        'shopping_cart_remove'	    => '/winkelmandje/verwijderen/',
        'customer_details'		    => '/klantgegevens',
        'checkout'				    => '/bestellen/afrekenen',
        'confirmation'			    => '/bestellen/bevestiging'
    ],

    'url_custom' => [
        // Add custom URLs here
    ],

    'page_home' => 	[
        'lead_title'            => 'Uw titel hier',
        'lead_text'             => 'ondertitel',
        'left_block'            => '',
        'right_block'           => '',
        'carousel' =>   [
            '0' =>          [
                'url' => '',
                'header' => '',
                'desc' => '',
            ],
            '1' =>          [
                'url' => '',
                'header' => '',
                'desc' => '',
            ],
            '2' =>          [
                'url' => '',
                'header' => '',
                'desc' => '',
            ],
        ],
    ],

    'page_contact' => 	[
        'title' => 'Onze contactgegevens',
        'content' => '@Default::dynamic.page-contact',
        'emailaddress_desc' => 'E-mailadres',
        'emailaddress' => 'uw@emailadres.nl',
        'phone_desc' => 'Telefoonnummer',
        'phone' => '(+31) (0) 12-345678',
        'address_desc' => 'Adres',
        'address' => 'Uw straat 2, POSTCODE Plaats, Land',
        'vat_desc' => 'BTW-nummer',
        'vat' => 'Uw BTW-nummer',
        'coc_desc' => 'KvK-nummer',
        'coc' => 'Uw KvK-nummer',
    ],

    'page_support' => [
        'content'               => 'Hieronder vindt u de meest gestelde vragen. Staat uw vraag of gewenste antwoord er niet tussen? <a href="'.config('base_url').'/contact">Neem dan contact met ons op</a>',

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
        'store_location' => '',
        'store_address' => '',
        'store_postal_code' => '',
        'store_chamber_of_commerce_number' => '',
        'store_vat_number' => '',
        'store_email' => '',
        'store_phone_number' => '',
        'store_url' => 'https://',
        'court_province' => '',
        'court_location' => '',
    ],

    'cookie_consent_bar' => [
        'header' => config('site_name').' gebruikt cookies!',
        'message' => config('site_name').' gebruikt cookies om het bezoek en winkelen bij '.config('site_name').' voor jou nog makkelijker en persoonlijker te maken.',
        'dismiss' => 'Ik snap het!',
        'allow' => 'Cookies toestaan',
        'deny' => 'Afwijzen',
        'link' => 'Lees meer',
        'href' => '/disclaimer-en-privacy',
    ],

    'http_errors' => [
        '404' => [
            'page_title' => 'Hier gaat iets helemaal 404-fout',
            'content' => '<p><img src="/images/404_image.gif" style="width: 50%;"></p><p>De opgevraagde pagina bestaat niet.</p><p>Wellicht was u op zoek naar <a href="'.config('base_url').'/">de homepagina</a> of <a href="'.config('base_url').'/support">de support-pagina</a>?',
            'footer' => '<p>Technisch contact: <a href="mailto:info@example.com">info@example.com</a></p>',
        ],
        '500' => [
            'page_title' => 'Interne server fout',
            'content' => '<p>Er is een onverwachte fout opgetreden!<br />Wij doen er alles aan de desbetreffende pagina zo snel mogelijk weer online te krijgen.</p>',
            'footer' => '<p>Technisch contact: <a href="mailto:info@example.com">info@example.com</a></p>',
        ]
    ]
];