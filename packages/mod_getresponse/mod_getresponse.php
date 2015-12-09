<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

if (file_exists(JPATH_ADMINISTRATOR . '/components/com_getresponse/getresponse.php') && JComponentHelper::isEnabled('com_getresponse', true))
{
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);

	$query->select($db->quoteName(array('webform_url', 'active', 'css_style')));
	$query->from($db->quoteName('#__getresponse'));
	$query->order('id DESC');

	$db->setQuery($query);

	$results = $db->loadObject();

	if (isset($results->webform_url) && $results->active == 1)
	{
		$css = $results->css_style == '0' ? '' : '&css=1';
		echo '<script type="text/javascript" src="'.$results->webform_url.$css.'"></script>';
		require JModuleHelper::getLayoutPath('mod_getresponse', $params->get('layout', 'default'));
	}
}

?>
