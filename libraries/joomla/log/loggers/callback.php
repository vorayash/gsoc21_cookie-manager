<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Log
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.log.logger');

/**
 * Joomla! Callback Log class
 *
 * This class allows logging to be handled by a callback function.
 * This allows unprecedented flexibility in the way logging can be handled. 
 *
 * @package     Joomla.Platform
 * @subpackage  Log
 * @since       12.1
 */
class JLoggerCallback extends JLogger
{
	/**
	 * @var    callback  The function to call when an entry is added - should return True on success
	 * @since  12.1
	 */
	protected $callback;

	/**
	 * Constructor.
	 *
	 * @param   array  &$options  Log object options.
	 *
	 * @since   12.1
	 */
	public function __construct(array &$options)
	{
		// Call the parent constructor.
		parent::__construct($options);

		// The name of the text file defaults to 'error.php' if not explicitly given.
		if (isset($this->options['callback']) && is_callable($this->options['callback']))
		{
			$this->callback = $this->options['callback'];
		}
	}

	/**
	 * Method to add an entry to the log.
	 *
	 * @param   JLogEntry  $entry  The log entry object to add to the log.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   12.1
	 * @throws  LogException
	 */
	public function addEntry(JLogEntry $entry)
	{
		// Pass the log entry to the callback function
		call_user_func($this->callback, $entry);
	}
}
