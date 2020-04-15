<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

?>
<section class="section-padding login-form">
<div class="login-wrapper login<?php echo $this->pageclass_sfx; ?>">
    <div class="card-wrapper">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1 class="title">
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>     
        <form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
            <div class="input-container">
            	<input type="text" id="username" name="username" autocomplete="off" size="25" required="" aria-required="true" placeholder="<?php echo JText::_('TPL_STORIES_USER') ?>" >
            </div>
            <div class="input-container">
                <input type="password" id="password" name="password" autocomplete="off" size="25" maxlength="99" required="" aria-required="true" placeholder="<?php echo JText::_('TPL_STORIES_PASS') ?>">
			</div>
			<div class="button-container">
				<button type="submit" class="btn btn-lg btn-block waves-effect waves-light"><?php echo JText::_('JLOGIN'); ?></button>
			</div>
			<?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
			<input type="hidden" name="return" value="<?php echo base64_encode($return); ?>" />
			<?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
</div>
	</section>
