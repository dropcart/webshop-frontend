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
require_once __BASEDIR__ . '/classes/Config.php';
require_once __BASEDIR__ . '/includes/twig.php';
require_once __BASEDIR__ . '/vendor/DropcartPhpClient/vendor/autoload.php';
require_once __BASEDIR__ . '/includes/dropcart_client_helper.php';
require_once __BASEDIR__ . '/classes/shopping_cart.php';
require_once __BASEDIR__ . '/classes/customer.php';
require_once __BASEDIR__ . '/classes/flash_messages.php';

// Includes
include __BASEDIR__ . '/includes/helpers.php';

// Load the config repository
$Config = new Config(__BASEDIR__ . '/config/config.php');
if(! function_exists('config') )
{
	function config($name = null, $default = null)
	{
		global $Config;

		if(is_null($name))
			return $Config;

		return $Config->get($name, $default);
	}
}

if(config('app_debug', false))
	ini_set('display_errors', 1);
else
	ini_set('display_errors', 0);

// Configure the Dropcart Client
\Dropcart\PhpClient\DropcartClient::options()
										->setBaseUri(config('dropcart_endpoint'))
										->setPublicKey(config('dropcart_key'))
										->setPrivateKey(config('dropcart_secret'))
										->setTimeout(config('timeout'));

$ShoppingCart   = new shopping_cart([]);
if(!function_exists('shopping_cart')) { function shopping_cart() { global $ShoppingCart; return $ShoppingCart; } }
$Customer       = new customer([]);
if(!function_exists('customer')) { function customer() { global $Customer; return $Customer; } }
$Messages       = new flash_messages([]);
if(!function_exists('flash_messages')) { function flash_messages() { global $Messages; return $Messages; } }

// Set locale
Locale::setDefault(strtolower(config('APP_LOCALE', 'NL')));

$Twig = (object) [
	'environment' => new Twig_Environment(new Twig_Loader_Filesystem(config('template_path')), array(
		'cache' => config('cache_path'),
		'auto_reload' => config('auto_reload'),
		'debug' => config('config.APP_DEBUG'),
	)),
	'default' => [
		'site_name'                 => config('site_name'),
		'site_slug'                 => config('site_slug'),
		//'page_title'                => '',
		'categories'                => request([], 'catalog', 'categories'),
		'customer_details'          => customer()->get(),
		'shopping_cart_overview'    => shopping_cart()->overview(),
        // Translations
        'lang'                      => lang(),
	]
];

if (isset($_SESSION['transaction']))
	$Twig->default['transaction'] = $_SESSION['transaction'];

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