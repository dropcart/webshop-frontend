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
    // Local
    "DROPCART_ENDPOINT" => "http://api.local.dropcart.app/v4/store",
////    "DROPCART_ENDPOINT" => "http://api.local.dropcart.app/v3",
//    // Store
    "DROPCART_KEY" => "11e77847602d32bdc500641e55c14888baa7065bb127a4fa7a1e37c45b53d95c",
    "DROPCART_SECRET" => "19f66e9372ee161e1b3864e1b0d4b28d904287f4c6e1264e73088e41a17dd385",
    // Supplier
//    "DROPCART_KEY" => "eee383bdb07fec4a20b0f1e8db27eb80b0a58c030d2c14aa6ccb50eaf5254bbc",
//    "DROPCART_SECRET" => "247d6b2c3e383dbbbe2660787c176a4af918ba4e7c0cbf6dfd42070191e97cee",

    // GCS
//    "DROPCART_KEY" => "df1f275336755a27c92c39e541f75bb859912387c4c5c28981f5c06619125c31",
//    "DROPCART_SECRET" => "20d023436fb0347426cfc1a242f41541401a16eede9a9fbe4e5963cf43ad5558",
//    "DROPCART_ENDPOINT" => "https://rest-api.staging.clusters.dropcart.nl/v4/store",
    "TIMEOUT" => 15,

    // Site global config
    "SITE_NAME" => "Dropcart.nl",
    "SITE_SLUG" => "",

    /* Base URL:
    Left blank, unless you want to run the site on a sub folder.
    For example:
    If you want to run the site on mywebshop.com/mysite/,  change this value to "/mysite" or "/mysite/" */
    "BASE_URL" => "",

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