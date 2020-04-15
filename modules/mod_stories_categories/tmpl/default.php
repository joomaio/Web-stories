<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>

<div class="categories<?php echo $moduleclass_sfx; ?> widget">
		<h4><?php if ( $module->showtitle ) echo $module->title; ?></h4>
	<ul class="nav flex-column">
		<?php foreach ($categories as $category) : ?>
			<li class="nav item">
				<a href="<?php echo JRoute::_('index.php?option=com_stories&view=category&id='.$category['id']); ?>" class="nav-link"><?php echo $category['name']; ?> </a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
