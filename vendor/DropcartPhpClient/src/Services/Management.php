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
 *
 * File: Management.php
 * Date: 16-01-18 10:26
 * Copyright: © [2016 - 2018] Dropcart - All rights reserved.
 * Version: v3.0.0
 *
 * =========================================================
 */


namespace Dropcart\PhpClient\Services;


interface Management {

	/**
	 * @return Rest
	 */
	public function clients() : Rest;

	/**
	 * @return Rest
	 */
	public function countries() : Rest;

	/**
	 * @return Rest
	 */
	public function couriers() : Rest;

	/**
	 * @return Rest
	 */
	public function organisations() : Rest;

	/**
	 * @return Rest
	 */
	public function stores() : Rest;

	/**
	 * @return Rest
	 */
	public function suppliers() : Rest;

}