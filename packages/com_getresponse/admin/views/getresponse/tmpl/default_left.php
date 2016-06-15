<?php
/**
 * @license    Licensed under the GPL v2
 */
defined('_JEXEC') or die;

?>

<div id="edit-left" class="form-item form-type-item">
	<fieldset class="form-wrapper" id="edit-settings">
		<legend><span class="fieldset-legend"><?php echo JText::_('COM_GETRESPONSE_PLUGIN_SETTINGS');?></span></legend>
		<p>
		<?php if (!empty($this->accountInfo)) { ?>
			<?php echo $this->accountInfo->firstName; ?> <?php echo $this->accountInfo->lastName; ?>, <?php echo $this->accountInfo->email; ?><br/>
			<?php echo $this->accountInfo->street; ?>, <?php echo $this->accountInfo->zipCode; ?> <?php echo $this->accountInfo->city; ?>, <?php echo $this->accountInfo->countryCode->countryCode; ?><br/>
		<?php } else {
			echo JText::_('COM_GETRESPONSE_APIKEY_HINT');
		} ?>
		</p>

		<br/>

		<p>
			<label class="GR_label" for="api_key"><?php echo JText::_('COM_GETRESPONSE_APIKEY');?></label>
			<input class="GR_api" type="text" name="api_key" value="<?php echo $this->apikey;?>" />
			<?php if (empty($this->apikey)) { ?>
				<input type="submit" id="edit-submit" name="op" value="<?php echo JText::_('COM_GETRESPONSE_CONNECT');?>" class="form-submit">
			<?php } else { ?>
				<button id="gr_disconnect"><?php echo JText::_('COM_GETRESPONSE_DISCONNECT');?></button>
				<div id="gr-disconnect-overlay" class="gr-hidden"><div id="gr-disconnect-modal" class="">
				<h2 class="gr-modal-title"><?php echo JText::_('COM_GETRESPONSE_MOD_TITLE');?></h2>
				<p><?php echo JText::_('COM_GETRESPONSE_MOD_DESC');?></p>
				<div class="gr-modal-buttons">
				<a id="gr-stay-connected" class="button gr-std-btn" href="#"><?php echo JText::_('COM_GETRESPONSE_MOD_NO');?></a>
				<a class="button gr-red-btn" id="gr-disconnect-confirm" href="<?php
					$url = JUri::getInstance();
					$url->setVar('disconnect', 1);
					echo $url->toString();
				?>"><?php echo JText::_('COM_GETRESPONSE_MOD_YES');?></a></div></div></div>
			<?php } ?>
		</p>
		<br/>
		<p>
			<?php echo JText::_('COM_GETRESPONSE_APIKEY_INFO');?>
		</p>
		<br>
	</fieldset>

		<?php if (!empty($this->apikey)) { ?>
		<fieldset>
			<legend><span class="fieldset-legend"><?php echo JText::_('COM_GETRESPONSE_HOW_TO_GET_SUBSCRIBERS');?></span></legend>
			<h3 class="GR_title"><?php echo JText::_('COM_GETRESPONSE_WEBFORM_SETTINGS');?></h3>

			<p>
				<label class="GR_label GR_label_full" for="is_active">
					<span><?php echo JText::_('COM_GETRESPONSE_WEBFORM_ACTIVE');?></span>
					<input  name="is_active" id="is_active" type="checkbox" value="1"<?php if ($this->is_active == 1){ echo ' checked="checked"';}?>>
				</label>
			</p>

			<p>
				<label class="GR_label" for="webform_id"><?php echo JText::_('COM_GETRESPONSE_WEBFORM');?></label>
				<?php
				if (!empty($this->old_webforms) || !empty($this->new_webforms)) {
					?>
					<select name="webform_id" id="webform_id" class="GR_select">
						<?php if (empty($this->old_webforms) && !empty($this->new_webforms) || !empty($this->old_webforms) || empty($this->new_webforms)) {
							foreach (array_merge($this->old_webforms, $this->new_webforms) as $id => $webform) {
								echo '<option value="' . $id . '"', $this->webform_id == $id ? ' selected="selected"' : '', '>', $webform, '</option>';
							}
						} else {
							echo '<optgroup label="' . JText::_('COM_GETRESPONSE_WEBFORM_OLD') . '">';
							foreach ($this->old_webforms as $id => $webform) {
								echo '<option value="' . $id . '"', $this->webform_id == $id ? ' selected="selected"' : '', '>', $webform, '</option>';
							}
							echo '</optgroup>';
							echo '<optgroup label="' . JText::_('COM_GETRESPONSE_WEBFORM_NEW') . '">';
							foreach ($this->new_webforms as $id => $webform) {
								echo '<option value="' . $id . '"', $this->webform_id == $id ? ' selected="selected"' : '', '>', $webform, '</option>';
							}
							echo '</optgroup>';
						} ?>
					</select>
					<span class="GR_hint"><?php echo JText::_('COM_GETRESPONSE_GRABBED');?></span>
				<?php }
				else {
					?><?php echo JText::_('COM_GETRESPONSE_NO_WEBFORMS');?><?php
				}
				?>
			</p>

			<p>
				<label class="GR_label" for="css_style"><?php echo JText::_('COM_GETRESPONSE_WEBFORM_CSS');?></label>
				<select name="css_style" id="css_style" class="GR_select">
					<option value="0" <?php if ($this->css_style == 0){ echo 'selected="selected"';}?>><?php echo JText::_('COM_GETRESPONSE_WEBFORM_GR');?></option>
					<option value="1" <?php if ($this->css_style == 1){ echo 'selected="selected"';}?>><?php echo JText::_('COM_GETRESPONSE_JOOMLA');?></option>
				</select>
				<span class="GR_hint"><?php echo JText::_('COM_GETRESPONSE_WEBFORM_HINT');?></span>
			</p>

			<p>
				<strong><a class="GR_click_hint" href="#gr-webform-help"><?php echo JText::_('COM_GETRESPONSE_WEBFORM_HELP');?></a></strong>
				<br/>
				<br/>
				<span id="gr-webform-help" class="gr-hidden"><?php echo JText::_('COM_GETRESPONSE_WEBFORM_HELP_INFO');?></span>
			</p>

			<br/>

			<h3 class="GR_title"><?php echo JText::_('COM_GETRESPONSE_REGISTRATION_SETTINGS');?></h3>

			<p>
				<label class="GR_label GR_label_full" for="active_on_registration">
					<span><?php echo JText::_('COM_GETRESPONSE_ENABLED_ON_REGISTRATION');?></span>
					<input  name="active_on_registration" id="active_on_registration" type="checkbox" value="1"<?php if ($this->active_on_registration == 1){ echo ' checked="checked"';}?>>				</label>
			</p>
			<p>
				<label class="GR_label" for="is_active"><?php echo JText::_('COM_GETRESPONSE_CAMPAIGN');?></label>
				<?php
				if ( !empty($this->campaigns)) {
					?>
					<select name="campaign_id" id="campaign_id" class="GR_select">
						<?php
							foreach ($this->campaigns as $id => $campaign) {
								echo '<option value="' . $campaign->campaignId . '"', $campaign->campaignId == $this->campaign_id ? ' selected="selected"' : '', '>', $campaign->name, '</option>';
							}
						?>
					</select>
					<span class="GR_hint"><?php echo JText::_('COM_GETRESPONSE_GRABBED');?></span>
				<?php }
				else {
					?><?php echo JText::_('COM_GETRESPONSE_NO_CAMPAIGNS');?><?php
				}
				?>
			</p>
			<p>
				<strong><a class="GR_click_hint" href="#gr-registration-help"><?php echo JText::_('COM_GETRESPONSE_CAMPAIGN_HELP');?></a></strong>
				<br/>
				<br/>
				<span id="gr-registration-help" class="gr-hidden"><?php echo JText::_('COM_GETRESPONSE_CAMPAIGN_HELP_INFO');?></span>
			</p>
		</fieldset>
		<p>
			<br/><input type="submit" id="edit-submit" name="op" value="<?php echo JText::_('COM_GETRESPONSE_SAVE_CONFIGURATION');?>" class="form-submit">
		</p>
		<?php }?>



</div>
