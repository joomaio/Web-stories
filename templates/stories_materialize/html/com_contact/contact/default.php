<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>

<div class="text-center mb-80">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<h2 class="section-title text-uppercase">
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h2>
	<?php endif; ?>
</div>
<div class="row">
    <div class="col s8">
		<?php echo $this->loadTemplate('form'); ?>
    </div>
    <div class="col s4 contact-info">
		<?php echo $this->loadTemplate('address'); ?>
	</div>
</div>