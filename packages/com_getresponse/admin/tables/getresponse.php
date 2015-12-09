<?php
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
