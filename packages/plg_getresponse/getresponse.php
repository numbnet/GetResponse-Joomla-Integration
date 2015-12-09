<?php

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
class plgContentGetresponse extends JPlugin {

	public $apikey;

	/**
	 * loading language file
	 *
	 * @param $subject
	 * @param $config
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
		$this->apikey = $this->getApiKey();
	}

	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}

		$name = $form->getName();
		$campaignId = $this->getCampaignId();

		//checking right web form
		if ($name != 'com_users.registration' || !$this->isActive() || empty($campaignId))
		{
			return true;
		}

		// Add the extra fields to the form.
		JForm::addFormPath(dirname(__FILE__) . '/registration');
		$form->loadFile('registration', false);
		return true;
	}


	public function onUserAfterSave($user, $isnew, $success, $msg)
	{
		if (!$isnew && $this->isActive() && $this->getCampaignId()) {
			return true;
		}

		require_once(JPATH_ADMINISTRATOR.'/components/com_getresponse/assets/lib/getresponse-api.class.php');

		$api = new GetResponse($this->apikey);
		$api->addContact(array(
			'name' => $user['name'],
			'email' => $user['email'],
			'dayOfCycle' => 0,
			'campaign' => array('campaignId' => $this->getCampaignId())
		));

		return true;
	}


	/**
	 * get api key
	 *
	 * @return  string
	 */
	protected function getApiKey()
	{
		$db = JFactory::getDBO();

		$query = 'SELECT apikey FROM #__getresponse ORDER BY id DESC';
		$db->setQuery( $query );
		$apikey = $db->loadResult();

		return $apikey;
	}

	/**
	 * get active status
	* this mean that for plugin this will be registration
	 *
	 * @return  string
	 */
	protected function isActive()
	{
		$db = JFactory::getDBO();

		$query = 'SELECT active_on_registration FROM #__getresponse WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$active_on_registration = $db->loadResult();

		return $active_on_registration;
	}

	/**
	 * get webform url
	 *
	 * @return  string
	 */
	protected function getCampaignId()
	{
		$db = JFactory::getDBO();

		$query = 'SELECT campaign_id FROM #__getresponse WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$webform_url = $db->loadResult();

		return $webform_url;
	}

}
?>