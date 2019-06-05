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
 * File: helpers.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

/**
 * @param $url
 * @param $varname
 * @return string
 */
function removeqsvar($url, $varname)
{
    list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
    parse_str($qspart, $qsvars);
    unset($qsvars[$varname]);
    $newqs = http_build_query($qsvars);
    return $urlpart . '?' . $newqs;
}

function dd(array $array)
{
    echo '<pre>';
    var_dump($array);
    echo '</pre>';
    die();
}

/**
 * @return string
 */
function url()
{
    $base_url = rtrim(config('base_url'), '/');
    return sprintf(
        "%s://%s",
        ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http',
        $_SERVER['SERVER_NAME'] . $base_url
    );
}

/**
 * Redirect user back to previous page
 */
function back()
{
	if(isset($_SESSION['previous_url']) && $_SESSION['previous_url'] != $_SERVER['REQUEST_URI'] && !headers_sent())
	{
        header('Location: ' . $_SESSION['previous_url'] . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
		exit;
	}
	else {
		echo '<html><head><title>Redirect</title><script type="text/javascript">history.go(-1);</script></head><body>U wordt doorgestuurd...Of klik <a href="javascript:history.go(-1)">hier</a>.</body></html>';
		exit;
	}
}

/**
 * Returns the localization file for the current default locale, or the translation from array_key
 * @return string | array
 */
function lang($key = null)
{
    $lang = include __BASEDIR__ . '/public/lang/'.locale_get_default().'/'.locale_get_default().'.php';
    if ($key) {
        $keys = explode('.', $key);
        foreach ($keys as $key) {
            $lang = $lang[$key];
        }
        return $lang;
    } else {
        return $lang;
    }
}

/**
 * Returns the localized URLs for the current default locale, or the translation from array_key
 * @return string | array
 */
function urls(string $base_url): array
{
    $base_url = rtrim($base_url, '/');
    $lang = include __BASEDIR__ . '/public/lang/'.locale_get_default().'/'.locale_get_default().'.php';
    $urls = [];

    foreach ($lang['url'] as $key => $default_url) {
        $urls[$key] = $base_url . $default_url;
    }

    foreach ($lang['url_custom'] as $key => $custom_url) {
        $urls[$key] = $base_url . $custom_url;
    }

    return $urls;
}

/**
 * @param string $url
 * @return string
 */
function base64_encode_image(string $url) {
    $type = pathinfo($url, PATHINFO_EXTENSION);
    $data = file_get_contents($url);

    if (!$data) {
        $data = file_get_contents(__BASEDIR__ . '/public/images/no_image.png');
    }

    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

if (!function_exists('get_locale')) {
    function get_locale()
    {
        return locale_get_default();
    }
}

if (!function_exists('get_locale_id')) {
    function get_locale_id()
    {
        global $locale_id;
        return $locale_id;
    }
}

if (!function_exists('object_to_array')) {
    /**
     * Recursively casts an object to array.
     *
     * @param object|array $object
     * @return array
     */
    function object_to_array($object): array
    {
        return json_decode(json_encode($object), true);
    }
}

if (!function_exists('request_uri')) {
    function request_uri(string $base_uri): string
    {
        $base_url = rtrim(config('base_url'), '/');
        return str_replace($base_url, '', $_SERVER['REQUEST_URI']);
    }
}