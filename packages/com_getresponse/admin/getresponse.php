<?php
/**
 * @license    Licensed under the GPL v2
 */
defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_getresponse'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 401);
}

jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('GetResponse');

$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('display'));

$controller->redirect();
