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
 * File: config.php.example
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

    // App config
    "APP_ENV" => "live",
    "APP_DEBUG" => true,
    "APP_TIMEZONE" => "CET",
    "APP_LOCALE" => "NL",

    // Dropcart config
    "DROPCART_KEY" => "df1f275336755a27c92c39e541f75bb859912387c4c5c28981f5c06619125c31",
    "DROPCART_SECRET" => "20d023436fb0347426cfc1a242f41541401a16eede9a9fbe4e5963cf43ad5558",
    "DROPCART_ENDPOINT" => "https://rest-api.v3.dropcart.nl/v3",
    "TIMEOUT" => 15,

    // Site global config
    "SITE_NAME" => "Dropcart.nl",
    "SITE_SLUG" => "",
    "BASE_URL" => "dropcart.app/",
    "MULTILINGUAL" => false,
    "COUNTRIES" => "Nederland",
    "PRODUCT_OVERVIEW" => "list",   // OPTIONS: LIST   / BLOCKS
    "PAYMENT_PROVIDER" => "mollie", // OPTIONS: MOLLIE / STRIPE
    // Website layout in full width
    "FULL_WIDTH" => false,

    // Twig config
    // Note: set the path relative from the public folder
    "TEMPLATE_PATH" => __BASEDIR__ . "/templates",
    "CACHE_PATH" => __BASEDIR__ . "/templates/compilation_cache",
    "AUTO_RELOAD" => true,

];