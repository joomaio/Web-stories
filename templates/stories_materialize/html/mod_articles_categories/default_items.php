<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_categories
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$input  = JFactory::getApplication()->input;
$option = $input->getCmd('option');
$view   = $input->getCmd('view');
$id     = $input->getInt('id');
?>
<div class="tt-sidebar-wrapper" role="complementary">
    <div class="widget widget_categories">
		<h3 class="widget-title"><?php if ( $module->showtitle ) echo $module->title; ?></h3>
		<ul class="categories-module<?php echo $moduleclass_sfx; ?> mod-list">
			<?php foreach ($list as $item) : ?>
				<li <?php if ($id == $item->id && in_array($view, array('category', 'categories')) && $option == 'com_content') echo ' class="active"'; ?>> 
					<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
						<?php echo $item->title; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
