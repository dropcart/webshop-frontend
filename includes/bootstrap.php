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
 * File: bootstrap.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

session_start();

define('__BASEDIR__', rtrim(realpath(__DIR__ . '/..'), '/'));
require_once __BASEDIR__ . '/Classes/Config.php';
require_once __BASEDIR__ . '/includes/twig.php';
require_once __BASEDIR__ . '/vendor/DropcartPhpClient/vendor/autoload.php';
require_once __BASEDIR__ . '/includes/dropcart_client_helper.php';
require_once __BASEDIR__ . '/Classes/ShoppingCart.php';
require_once __BASEDIR__ . '/Classes/Customer.php';
require_once __BASEDIR__ . '/Classes/FlashMessages.php';

// Includes
include __BASEDIR__ . '/includes/helpers.php';

// Load the config repository
$Config = new Config(__BASEDIR__ . '/config/config.php');
if(! function_exists('config') )
{
	function config($name = null, $default = null)
    {
        global $Config;

        if (is_null($name)) {
            return $Config;
        }

		return $Config->get($name, $default);
	}
}

if(config('app_debug', false)) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}

// Set locale and default language ID
Locale::setDefault(strtolower(config('APP_LOCALE', 'NL')));
global $locale_id; // @todo
$locale_id = 1;
// Set default shipping country. This value might change once a customer fills in details or through switchbox (not implemented yet)
global $shipping_country_id; // @todo
$shipping_country_id = config('default_shipping_country');

// Configure the Dropcart Client
\Dropcart\PhpClient\DropcartClient::options()
										->setBaseUri(config('dropcart_endpoint'))
										->setPublicKey(config('dropcart_key'))
										->setPrivateKey(config('dropcart_secret'))
										->setTimeout(config('timeout'));

$ShoppingCart   = new ShoppingCart([]);
if(!function_exists('shopping_cart')) { function shopping_cart() { global $ShoppingCart; return $ShoppingCart; } }
$Customer       = new Customer([]);
if(!function_exists('customer')) { function customer() { global $Customer; return $Customer; } }
$Messages       = new FlashMessages([]);
if(!function_exists('flash_messages')) { function flash_messages() { global $Messages; return $Messages; } }

$twig_environment =  new \Twig\Environment(new \Twig\Loader\FilesystemLoader(config('template_path')), array(
    'cache' => config('cache_path'),
    'auto_reload' => config('auto_reload'),
    'debug' => config('app_debug'),
));

if (config('app_debug') === true) {
    $twig_environment->addExtension(new \Twig\Extension\DebugExtension());
}

$Twig = (object) [
	'environment' => $twig_environment,
	'default' => [
		'site_name'                 => config('site_name'),
		'site_slug'                 => config('site_slug'),
        'product_overview'          => config('product_overview'),
        'payment_provider'          => config('payment_provider'),
        'container'                 => config('full_width'),
        'base_url'                  => config('base_url'),
        'locale_id'                 => $locale_id,
        'shipping_country_id'       => $shipping_country_id,
		//'page_title'                => '',
		'categories'                => request([], 'catalog', 'categories'),
		'customer_details'          => customer()->get(),
		'shopping_cart_overview'    => shopping_cart()->overview(),
        // Translations and translated URLS
        'lang'                      => lang(),
        'urls'                      => urls(config('base_url')),
	]
];

if (isset($_SESSION['transaction'])) {
    $Twig->default['transaction'] = $_SESSION['transaction'];
}

if(! function_exists('twig') )
{
	function twig()
	{
		global $Twig;
		return $Twig;
	}
}

if(! function_exists('view') )
{
	function view ($view, $variables = [])
	{
		global $Twig;

		$template   = $Twig->environment->load($view);
		$vars       = array_merge($Twig->default, $variables);

		return $template->render($vars);
	}
}
