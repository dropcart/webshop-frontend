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
 * File: customer_details.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */

class flash_messages {

    /**
     * @var array $flash_messages
     */
    private $flash_messages;

    /**
     * @var array $config
     */
    private $config;

    public function __construct($config)
    {
        $this->config = $config;

        if (!isset($_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'] = [
                'success_messages' => [],
                'warning_messages' => [],
                'error_messages' => [],
            ];
        }

        $this->flash_messages = $_SESSION['flash_messages'];
    }

    /**
     * Add a success flash message or an array of success messages to the session.
     *
     * @param $messages int|array
     */
    function setSuccessMessages($messages)
    {
        if (is_array($messages)) {
            // Array
            $_SESSION['flash_messages']['success_messages'] = array_merge($_SESSION['flash_messages']['success_messages'], $messages);
        } else {
            // String
            $_SESSION['flash_messages']['success_messages'][] = $messages;
        }

        $this->flash_messages = $_SESSION['flash_messages'];
    }

    /**
     * Add a warning flash message or an array of warning messages to the session.
     *
     * @param $messages int|array
     */
    function setWarningMessages($messages)
    {
        if (is_array($messages)) {
            // Array
            $_SESSION['flash_messages']['warning_messages'] = array_merge($_SESSION['flash_messages']['warning_messages'], $messages);
        } else {
            // String
            $_SESSION['flash_messages']['warning_messages'][] = $messages;
        }

        $this->flash_messages = $_SESSION['flash_messages'];
    }

    /**
     * Add a error flash message or an array of error messages to the session.
     *
     * @param $messages int|array
     */
    function setErrorMessages($messages)
    {
        if (is_array($messages)) {
            // Array
            $_SESSION['flash_messages']['error_messages'] = array_merge($_SESSION['flash_messages']['error_messages'], $messages);
        } else {
            // String
            $_SESSION['flash_messages']['error_messages'][] = $messages;
        }

        $this->flash_messages = $_SESSION['flash_messages'];
    }

    /**
     * @return array
     */
    function get()
    {
        return $this->flash_messages;
    }

    /**
     * Resets the session flash_messages
     */
    function reset()
    {
        $_SESSION['flash_messages'] = [
            'success_messages' => [],
            'warning_messages' => [],
            'error_messages' => [],
        ];
    }
}