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
 * File: dropcart_client_helper.php
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
 * @param string $method
 * @param $config
 * @param $service
 * @param $contract
 * @param $params
 * @return bool|mixed|string
 */
function request($config = [], $service, $contract, $params = null, $method = 'get')
{
    try {
        // Create the request
        $request = \Dropcart\PhpClient\DropcartClient::{$service}()->{$contract}();

        if ($params && !is_array($params)) {
            $response = $request->{$method}($params);
        } else {
            // Check if additional query (get) or parameters (post) need to be set
            if ($method == 'get' && $params && is_array($params)) {
                foreach ($params as $name => $value) {
                    if (!$value)
                        continue;

                    if (is_array($value)) {
                        $request->addQuery($name, json_encode($value));
                    } else {
                        $request->addQuery($name, $value);
                    }
                }
            } elseif ($method == 'post' && $params && is_array($params)) {
                foreach ($params as $name => $value) {
                    $request->addParam($name, $value);
                }
            }

            $response = $request->{$method}();
        }
    } catch (\Dropcart\PhpClient\DropcartClientException $e) {
        if (config('app_debug')) {
            die('Client error:' . $e->getMessage());
        } else {
            header ('HTTP/1.0 500 Internal Server Error');
            include_once __DIR__ . '/../errors/500.php';
            exit();
        }
        exit();
    } catch (\Exception $e) {
        if (config('app_debug')) {
            die('Server error:' . $e->getMessage());
        } else {
            header ('HTTP/1.0 500 Internal Server Error');
            include_once __DIR__ . '/../errors/500.php';
            exit();
        }
        exit();
    }

    $content = $response->getBody()->getContents();
    $content = json_decode($content);

    // Input exception
    if (isset($content->errors)) {
        throw new InputException('', 0, null, $content->errors);
    }

    return $content;
}