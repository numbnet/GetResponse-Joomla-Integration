<?php
defined('_JEXEC') or die;
?>

<div id="edit-right" class="form-item form-type-item">

	<fieldset class="form-wrapper" id="edit-rss">
		<legend><span class="fieldset-legend"><?php echo JText::_('COM_GETRESPONSE_RSS');?></span></legend>

		<div class="fieldset-wrapper"><div id="edit-content" class="form-item form-type-item">
				<ul class="GR_rss_ul">
					<?php if ($this->feeds) { foreach ($this->feeds as $feed): ?>
						<li class="GR_rss_li">
							<a href="<?php echo $feed['url']; ?>" target="_blank"><?php echo $feed['title']; ?></a>
						</li>
					<?php endforeach;
					} else {
						echo JText::_('COM_GETRESPONSE_NO_RSS');
					}?>
				</ul>
			</div>
	</fieldset>

	<fieldset class="form-wrapper" id="edit-social">
		<legend><span class="fieldset-legend"><?php echo JText::_('COM_GETRESPONSE_SOCIAL');?></span></legend>

		<div class="social-padding"><div id="edit-facebook" class="form-item form-type-item">
				<a href="http://www.facebook.com/getresponse" class="GR_ico sprite facebook-ico">Facebook</a>
			</div>
			<div id="edit-twitter" class="form-item form-type-item">
				<a href="http://twitter.com/getresponse" class="GR_ico sprite twitter-ico">Twitter</a>
			</div>
			<div id="edit-linkedin" class="form-item form-type-item">
				<a href="http://www.linkedin.com/company/getresponse" class="GR_ico sprite linkedin-ico">LinkedIn</a>
			</div>
			<div id="edit-blog" class="form-item form-type-item">
				<a href="http://blog.getresponse.com" class="GR_ico sprite blog-ico">Blog</a>
			</div>
		</div>

	</fieldset>

</div>