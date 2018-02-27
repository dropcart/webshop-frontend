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
 * File: Config.php
 * Date: 27-02-18 12:00
 *
 * @author Dropcart <info@dropcart.nl>
 * @copyright © [2016 - 2018] Dropcart - All rights reserved.
 * @license MIT (https://opensource.org/licenses/MIT)
 * @version 3.0.0
 *
 * =========================================================
 */


class Config {

	private $original = [];
	private $config = [];
	private $is_dirty = false;

	/**
	 * Config constructor.
	 *
	 * @param string|array|object|null $config
	 * @throws \Exception
	 */
	public function __construct($config = null) {
		if(!is_null($config))
			$this->loadConfig($config);
	}

	/**
	 * Load a config KV file, array or object.
	 * @param array|object|string $config
	 *
	 * @throws Exception
	 * @return $this
	 */
	public function loadConfig($config)
	{
		if(is_object($config))
			$this->original = (array) $config;
		else if (is_string($config) && file_exists($config))
			$this->original = include($config);
		else if(is_array($config))
			$this->original = $config;
		else
			throw new \Exception("Config can't be read.");

		$this->reset();

		return $this;
	}

	/**
	 * Reload the original config
	 *
	 * @return $this
	 */
	public function reset()
	{
		$this->config = array_change_key_case($this->original, CASE_LOWER);
		$this->is_dirty = false;
		return $this;
	}

	/**
	 * Does key exist?
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	public function has($name)
	{
		return (array_key_exists(strtolower($name), $this->config));
	}

	/**
	 * Get an item from the config file
	 *
	 * @param string $name
	 * @param mixed|null $default
	 *
	 * @return mixed|null
	 */
	public function get($name, $default = null)
	{
		if(!$this->has($name))
			return $default;

		return $this->config[strtolower($name)];
	}

	/**
	 * Set a config variable.
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return $this
	 */
	public function set($name, $value)
	{
		if($this->get($name, time()) !== $value )
			$this->is_dirty = true;

		$this->config[strtolower($name)] = $value;

		return $this;
	}

	/**
	 * Check if the config differs from the original
	 *
	 * @return bool
	 */
	public function is_dirty()
	{
		return $this->is_dirty;
	}

}