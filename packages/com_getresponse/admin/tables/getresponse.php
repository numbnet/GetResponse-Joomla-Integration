<?php
/**
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;

jimport('joomla.database.table');

/**
 *  GetResponse
 */
class GetResponseTableGetResponse extends JTable
{
	/**
	 * @param   JDatabase  &$db
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__getresponse', 'id', $db);
	}
}
