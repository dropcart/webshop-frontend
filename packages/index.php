<?php
/**
 * =========================================================
 *                        DROPCART
 *                      ------------
 * This file is part of the source code of Dropcart and is
 * subject to the terms and conditions defined in the license
 * file include in this package.
 *
 * CONFIDENTIAL:
 * All information contained herein is, and remains the property
 * of Dropcart and its suppliers, if any.  The intellectual and
 * technical concepts contained herein are proprietary to Dropcart
 * and its suppliers and may be covered by Dutch and Foreign Patents,
 * patents in process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from Dropcart.
 *
 * =========================================================
 */

function package_route($route, $file_path) {

    $route = str_replace('/', '\/', $route);

    // Split get / post variables
    $_SERVER['REQUEST_URI'] = strtok($_SERVER['REQUEST_URI'], '?');

    $is_match =(bool) preg_match('/^' . ($route) . '$/',
        $_SERVER['REQUEST_URI'],
        $matches, PREG_OFFSET_CAPTURE);


    if ($is_match && file_exists(__DIR__ . $file_path . '.php')) {
        twig()->default['page_title'] = ucwords(str_replace(['-', '_', '  '], ' ', $file_path));

        header ('HTTP/1.0 200 Found');
        include_once __DIR__ . $file_path . '.php';
        flash_messages()->reset();
        $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
        exit;
    }
}

// Include package routes from all directories
$packages = array_diff(scandir(__BASEDIR__ . '/packages/'), ['..', '.']);
foreach ($packages as $folder){
    if (is_dir(__BASEDIR__ . '/packages/' . $folder) && file_exists(__BASEDIR__ . '/packages/' . $folder . '/index.php')){
        include_once __BASEDIR__ . '/packages/' . $folder . '/index.php';
    }
}