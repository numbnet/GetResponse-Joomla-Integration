<?php
/**
 * @license    Licensed under the GPL v2
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * GetResponseController
 */
class GetResponseController extends JControllerLegacy
{
	/**
	 * dispaly
	 */
	public function display($cachable = false, $urlparams = array())
	{
		// set default view if view is not set
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'GetResponse'));

		parent::display($cachable);
	}
}
