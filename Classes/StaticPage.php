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

class StaticPage {

    /** @var   */
    private $view;
    /** @var   */
    private $view_vars;

    public function __construct(string $view, array $view_vars)
    {
        $this->view = $view;
        $this->view_vars = $view_vars;
    }

    public function render()
    {
        return view($this->view, $this->view_vars);
    }
}