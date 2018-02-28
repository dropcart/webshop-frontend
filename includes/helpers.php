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

/**
 * @return string
 */
function url()
{
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
}

/**
 * Redirect user back to previous page
 */
function back()
{
	if(isset($_SESSION['previous_url']) && $_SESSION['previous_url'] != $_SERVER['REQUEST_URI'] && !headers_sent())
	{
		header('Location: ' . $_SESSION['previous_url']);
		exit;
	}
	else {
		echo '<html><head><title>Redirect</title><script type="text/javascript">history.go(-1);</script></head><body>U wordt doorgestuurd...Of klik <a href="javascript:history.go(-1)">hier</a>.</body></html>';
		exit;
	}
}

/**
 * Returns the localization file for the current default locale, or the translation from array_key
 * @return string
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