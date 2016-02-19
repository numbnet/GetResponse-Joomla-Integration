<?php
/**
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
?>

<?php
	if (!empty($this->flash)) {
?>
	<div class="alert <?php if(isset($this->flash['type']) && $this->flash['type'] == 'error') { echo "alert-error"; } else { echo "alert-success";}?>">
		<a class="close" data-dismiss="alert">×</a> <?php if(isset($this->flash['message'])) { echo $this->flash['message']; }?>
	</div>
<?php
}
?>

<form action="<?php echo JRoute::_('index.php?option=com_getresponse'); ?>" method="post" name="adminForm" id="adminForm">

	<div class="form-horizontal">
		<div class="row-fluid">
			<div class="span6">
				<?php echo $this->loadTemplate('left');?>
			</div>
			<div class="span4">
				<?php echo $this->loadTemplate('right');?>
			</div>
		</div>
	</div>

	<div>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
