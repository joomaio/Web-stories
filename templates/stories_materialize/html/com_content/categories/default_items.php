<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

$class = ' class="first"';

if ($this->maxLevelcat != 0 && count($this->items[$this->parent->id]) > 0) :
?>
	<?php foreach ($this->items[$this->parent->id] as $id => $item) : ?>
		<?php
		if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) :
		if (!isset($this->items[$this->parent->id][$id + 1]))
		{
			$class = ' class="last"';
		}
		?>
		<div <?php echo $class; ?> >
		<?php $class = ''; ?>
			<ul class="collapsible">
				<h2 class="page-header item-title">
					<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id, $item->language)); ?>">
						<?php echo $this->escape($item->title); ?>
					</a>
				</h2>
				<?php if ($this->params->get('show_subcat_desc_cat') == 1) : ?>
					<?php if ($item->description) : ?>
						<div class="category-desc">
							<?php echo JHtml::_('content.prepare', $item->description, '', 'com_content.categories'); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) : ?>
					<li>
					<div class="collapsible-header">
						<i class="material-icons iconremove">do_not_disturb_on</i>
						<i class="material-icons iconadd">add_circle</i>
						
						<p><?php echo JText::_("TPL_COM_CONTENT_SUBCATEGORY"); ?></p>
					</div>
					<div class="collapsible-body"  id="category-<?php echo $item->id; ?>">
						<?php
							$this->items[$item->id] = $item->getChildren();
							$this->parent = $item;
							$this->maxLevelcat--;
							echo $this->loadTemplate('items');
							$this->parent = $item->getParent();
							$this->maxLevelcat++;
						?>
					</div>
				</li>
				<?php endif; ?>

			</ul>
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
