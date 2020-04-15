<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$blockPosition = $displayData['params']->get('info_block_position', 0);

?>
<ul class="list-inline">
	<?php if ($displayData['params']->get('show_author') && !empty($displayData['item']->author )) : ?>
		<li><?php echo $this->sublayout('author', $displayData); ?></li>
	<?php endif; ?>
    <?php if ($displayData['params']->get('show_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
		<li><?php echo $this->sublayout('parent_category', $displayData); ?></li>
	<?php endif; ?>

	<?php if ($displayData['params']->get('show_category')) : ?>
		<li><?php echo $this->sublayout('category', $displayData); ?></li>
	<?php endif; ?>

	<?php if ($displayData['params']->get('show_associations')) : ?>
		<li><?php echo $this->sublayout('associations', $displayData); ?></li>
	<?php endif; ?>

	<?php if ($displayData['params']->get('show_publish_date')) : ?>
		<li><?php echo $this->sublayout('publish_date', $displayData); ?></li>
	<?php endif; ?>
	
</ul>