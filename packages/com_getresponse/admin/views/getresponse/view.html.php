<?php
/**
 * @license    Licensed under the GPL v2
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML
 */
class getresponseViewGetResponse extends JViewLegacy
{
	public $apikey, $webforms, $webform_id, $success, $css_style, $is_active, $feeds;
	public $flash = '';
	public $rss_url = 'http://blog.getresponse.com/feed';

	private $web_form_generation_first = 1;
	private $web_form_generation_second = 2;

	/**
	 * Display
	 *
	 * @param   string  $tpl
	 *
	 * @return  void
	 *
	 * @throws  Exception
	 */
	public function display($tpl = null)
	{
		try
		{
			require_once(JPATH_ADMINISTRATOR.'/components/com_getresponse/assets/lib/getresponse-api.class.php');

			JToolBarHelper::title(JText::_('COM_GETRESPONSE_PLUGIN_NAME'), 'getresponse');

			$this->apikey = $this->getApiKey();

			$this->parsePost();

			$this->setSettings();

			$this->renderRss();

			parent::display($tpl);

			$this->setDocument();
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	private function parsePost()
	{
		$input = new JInput;
		$apikey_param = $input->get('api_key', '', 'post');

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			if (!$apikey_param)
			{
				$this->flash = array('type' => 'error', 'message' => JText::_('COM_GETRESPONSE_EMPTY_APIKEY'));
			}
			else
			{
				$api = new GetResponse($apikey_param);
				$ping = $api->accounts();

				if (!empty($ping) && !isset($ping->accountId))
				{
					$this->flash = array('type' => 'error', 'message' => JText::_('COM_GETRESPONSE_INVALID_APIKEY'));
				}
			}

			if ($this->flash == '')
			{
				if ($this->apikey != $apikey_param)
				{
					$this->apikey = $apikey_param;
					$this->setApiKey($apikey_param);
				}

				$is_active = $input->get('is_active', '', 'post');
				$this->setActiveStatus($is_active);

				$css_style = $input->get('css_style', '', 'post');
				$this->setCssStyle($css_style);

				$campaign_id = $input->get('campaign_id', '', 'post');
				if (!empty($campaign_id)) {
					$this->setCampaignId($campaign_id);
				}

				$active_on_registration = $input->get('active_on_registration', '', 'post');
				if (empty($active_on_registration)) {
					$active_on_registration = 0;
				}
				$this->setActiveOnRegistration($active_on_registration);

				$webform_id = $input->get('webform_id', '', 'post');
				if ($webform_id)
				{
					$webform = $api->getWebform($webform_id);
					$generation = $this->web_form_generation_second;

					if ( !empty($webform->webformId)) {
						$generation = $this->web_form_generation_first;
					}

					$this->setWebformId($webform_id);
					$this->setWebformGeneration($generation);
				}
				$this->flash = array('type' => 'success', 'message' => JText::_('COM_GETRESPONSE_SUCCESS'));
			}
		}
	}

	private function setSettings()
	{
		if ($this->apikey)
		{
			$c = array();
			$api = new GetResponse($this->apikey);
			$this->campaigns = $api->getCampaigns();

			$this->active_on_registration = $this->getActiveOnRegistration();

			$this->webforms_groups = array();

			if ( !empty($this->campaigns))
			{
				$this->campaign_id = $this->getCampaignId();

				foreach ($this->campaigns as $v) {
					$c[$v->campaignId] = $v->name;
				}

				$this->webforms_groups[0]['optgroup'] = 'Old webforms';
				$webforms = $api->getWebforms();


				foreach ($webforms as $id => $webform)
				{
					if ('enabled' == $webform->status) {
						$this->webforms_groups[0]['webforms'][$webform->webformId] = $webform->name . ' (' . $c[$webform->campaign->campaignId] . ')';
					}
				}

				$this->webforms_groups[1]['optgroup'] = 'New webforms';
				$webforms = $api->getForms();

				foreach ($webforms as $id => $webform)
				{
					if ('deleted' != $webform->status) {
						$this->webforms_groups[1]['webforms'][$webform->formId] = $webform->name . ' (' . $c[$webform->campaign->campaignId] . ')';
					}
				}
			}

			$this->is_active = $this->isActive();

			$this->css_style = $this->getCssStyle();

			$this->webform = $this->getWebform($this->apikey);
			$this->webform_id = $this->webform->webform_id;

			if ($this->webform)
			{
				//for old webforms
				if ($this->web_form_generation_first == $this->webform->webform_generation) {
					$webform = $api->getWebform($this->webform->webform_id);
				}
				else{
					$webform = $api->getForm($this->webform->webform_id);
				}

				if (!empty($webform->scriptUrl)) {
					$this->setWebformUrl($webform->scriptUrl);
				}
			}
		}
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
	 * set api key
	 *
	 */
	protected function setApiKey()
	{
		$db = JFactory::getDBO();

		$query = 'INSERT INTO #__getresponse (apikey) VALUES ("'. $this->apikey .'")';
		$db->setQuery( $query );
		$db->execute();
	}

	/**
	 * get webform id
	 *
	 * @return  string
	 */
	protected function getWebform()
	{
		$db = JFactory::getDBO();

		$query = 'SELECT webform_id, webform_generation FROM #__getresponse WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$webform = $db->loadObject();

		return $webform;
	}

	/**
	 * get webform url
	 *
	 * @return  string
	 */
	protected function getWebformUrl()
	{
		$db = JFactory::getDBO();

		$query = 'SELECT webform_url FROM #__getresponse WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$webform_url = $db->loadResult();

		return $webform_url;
	}

	/**
	 * get active status
	 *
	 * @return  string
	 */
	protected function isActive()
	{
		$db = JFactory::getDBO();

		$query = 'SELECT active FROM #__getresponse WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$active = $db->loadResult();

		return $active;
	}

	/**
	 * get active status
	 *
	 * @return  string
	 */
	protected function getCssStyle()
	{
		$db = JFactory::getDBO();

		$query = 'SELECT css_style FROM #__getresponse WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$style = $db->loadResult();

		return $style;
	}

	/**
	 * set webform id
	 *
	 * @param $webform_id
	 * @return bool
	 */
	protected function setWebformId($webform_id)
	{
		$db = JFactory::getDBO();

		$query = 'UPDATE #__getresponse SET webform_id = "'. $webform_id .'" WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$db->execute();
	}

	/**
	 * set webform generation
	 *
	 * @param $generation
	 * @return bool
	 */
	protected function setWebformGeneration($generation)
	{
		$db = JFactory::getDBO();

		$query = 'UPDATE #__getresponse SET webform_generation = "'. (int)$generation .'" WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$db->execute();
	}

	/**
	 * set webform url
	 *
	 * @param $webform_url
	 * @return bool
	 */
	protected function setWebformUrl($webform_url)
	{
		$db = JFactory::getDBO();

		$query = 'UPDATE  #__getresponse SET webform_url = "'. $webform_url .'" WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$db->execute();
	}

	/**
	 * set status
	 *
	 * @param $status
	 * @return bool
	 */
	protected function setActiveStatus($status)
	{
		$db = JFactory::getDBO();

		$query = 'UPDATE #__getresponse SET active = "'. $status .'" WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$db->execute();
	}

	/**
	 * set css style
	 *
	 * @param $style
	 * @return bool
	 */
	protected function setCssStyle($style)
	{
		$db = JFactory::getDBO();

		$query = 'UPDATE #__getresponse SET css_style = "'. $style .'" WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$db->execute();
	}

	/**
	 * Add css styles
	 *
	 * @return  void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document -> addStyleSheet(JURI::base() . 'components/com_getresponse/assets/css/getresponse.css');
		$document -> addStyleDeclaration('.icon-getresponse ' . '{background-image: url(../media/com_getresponse/images/getresponse-16-16.png);}');
	}

	/**
	 * @param $campaign_id
	 */
	protected function setCampaignId($campaign_id)
	{
		$db = JFactory::getDBO();

		$query = 'UPDATE  #__getresponse SET campaign_id = "'. $campaign_id .'" WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$db->execute();
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

	/**
	 * @return mixed
	 */
	protected function getActiveOnRegistration()
	{
		$db = JFactory::getDBO();

		$query = 'SELECT active_on_registration FROM #__getresponse WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$active = $db->loadResult();

		return $active;
	}

	/**
	 * @param $active_on_registration
	 */
	protected function setActiveOnRegistration($active_on_registration)
	{
		$db = JFactory::getDBO();

		$query = 'UPDATE  #__getresponse SET active_on_registration = "'. $active_on_registration .'" WHERE apikey = "' . $this->apikey . '"';
		$db->setQuery( $query );
		$db->execute();
	}

	/**
	 * Function return RSS data as html string.
	 */
	public function renderRss() {
		$result = @file_get_contents($this->rss_url);

		if ($result) {
			$item_array = array();
			$news_items = $this->parseXMLdata('item', $result, FALSE, TRUE);
			if (is_array($news_items)) {
				$count = 0;
				foreach ($news_items as $item) {
					$title = $this->parseXMLdata('title', $item);
					$url = $this->parseXMLdata('link', $item);
					$item_array[] = array(
						'title' => $title,
						'url' => $url,
					);
					if (++$count == 10) {
						break;
					}
				}
				$this->feeds = $item_array;
			}
		}
	}

	/**
	 * Functions parse XML data, return string|FALSE.
	 */
	protected function parseXMLdata($element_name, $xml, $content_only = TRUE, $match_all = FALSE) {
		if ($xml == FALSE) {
			return FALSE;
		}
		if ($match_all) {
			$found = preg_match_all('#<' . preg_quote($element_name) . '(?:\s+[^>]+)?>' . '(.*?)</' . preg_quote($element_name) . '>#s', $xml, $matches, PREG_PATTERN_ORDER);
		}
		else {
			$found = preg_match('#<' . preg_quote($element_name) . '(?:\s+[^>]+)?>(.*?)' . '</' . preg_quote($element_name) . '>#s', $xml, $matches);
		}
		if ($found != FALSE) {
			if ($content_only) {
				return $matches[1];
			}
			else {
				return $matches[0];
			}
		}
		return FALSE;
	}
}