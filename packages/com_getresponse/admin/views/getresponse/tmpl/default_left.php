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
			<label class="GR_label" for="api_key"><?php echo JText::_('COM_GETRESPONSE_APIKEY');?></label>
			<input class="GR_api" type="text" name="api_key" value="<?php echo $this->apikey;?>" />

			<a class="gr-tooltip">
				<span class="gr-tip" style="width:170px">
					<span>
						<?php echo JText::_('COM_GETRESPONSE_APIKEY_TOOLTIP');?>
					</span>
				</span>
			</a>
		</p>

		<?php if (!empty($this->apikey)) { ?>
			<br/>
			<legend><span class="fieldset-legend"><?php echo JText::_('COM_GETRESPONSE_WEBFORM_SETTINGS');?></span></legend>

			<p>
				<label class="GR_label" for="is_active"><?php echo JText::_('COM_GETRESPONSE_WEBFORM_ACTIVE');?></label>
				<?php
				//
				?>
				<select name="is_active" id="is_active" class="GR_select">
					<option value="0" <?php if ($this->is_active == 0){ echo 'selected="selected"';}?>><?php echo JText::_('COM_GETRESPONSE_OFF');?></option>
					<option value="1" <?php if ($this->is_active == 1){ echo 'selected="selected"';}?>><?php echo JText::_('COM_GETRESPONSE_ON');?></option>
				</select>
			</p>

			<p>
				<label class="GR_label" for="webform_id"><?php echo JText::_('COM_GETRESPONSE_WEBFORM');?></label>
				<?php
				if ( !empty($this->webforms_groups)) {
					?>
					<select name="webform_id" id="webform_id" class="GR_select">
						<?php
						foreach ($this->webforms_groups as $id => $webform_group) {
							echo '<optgroup label="' . $webform_group['optgroup']. '">';
							foreach ($webform_group['webforms'] as $id => $webform) {
								echo '<option value="' . $id . '"', $this->webform_id == $id ? ' selected="selected"' : '', '>', $webform, '</option>';
							}
							echo '</optgroup>';
						} ?>
					</select>
				<?php }
				else {
					?>No webforms<?php
				}
				?>
			</p>

			<p>
				<label class="GR_label" for="css_style"><?php echo JText::_('COM_GETRESPONSE_WEBFORM_CSS');?></label>
				<select name="css_style" id="css_style" class="GR_select">
					<option value="0" <?php if ($this->css_style == 0){ echo 'selected="selected"';}?>><?php echo JText::_('COM_GETRESPONSE_WEBFORM');?></option>
					<option value="1" <?php if ($this->css_style == 1){ echo 'selected="selected"';}?>><?php echo JText::_('COM_GETRESPONSE_JOOMLA');?></option>
				</select>
			</p>

			<br/>
			<legend><span class="fieldset-legend"><?php echo JText::_('COM_GETRESPONSE_REGISTRATION_SETTINGS');?></span></legend>


			<p>
				<label class="GR_label" for="css_style"><?php echo JText::_('COM_GETRESPONSE_ENABLED_ON_REGISTRATION');?></label>
				<select name="active_on_registration" id="active_on_registration" class="GR_select">
					<option value="0" <?php if ($this->active_on_registration == 0){ echo 'selected="selected"';}?>><?php echo JText::_('COM_GETRESPONSE_OFF');?></option>
					<option value="1" <?php if ($this->active_on_registration == 1){ echo 'selected="selected"';}?>><?php echo JText::_('COM_GETRESPONSE_ON');?></option>
				</select>
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
				<?php }
				else {
					?>No campaigns<?php
				}
				?>
			</p>
		<?php }?>
	</fieldset>

	<p>
		<br/><input type="submit" id="edit-submit" name="op" value="<?php echo JText::_('COM_GETRESPONSE_SAVE_CONFIGURATION');?>" class="form-submit">
	</p>

</div>
