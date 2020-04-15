<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$params = $this->params;
$count = 0;
?>

<?php foreach ($this->items as $key => &$item) : 
	 	if ( $count % 4 == 0 ) echo '<div class="row">'; 
			if ( $count % 2 == 0 ) echo '<div class="col m6">';
		$canEdit = $item->params->get('access-edit');
		$info    = $item->params->get('info_block_position', 0); 
?>
			<article class="post-wrapper list-article card">
				<?php echo JLayoutHelper::render('joomla.content.feature_image', $item); ?>
				<div class="blog-content">
					<header class="entry-header-wrapper sticky">
						<div class="entry-header">
							<?php if ($params->get('show_title')) : ?>
								<h2 class="entry-title">
									<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
										<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)); ?>" itemprop="url">
											<?php echo $this->escape($item->title); ?>
										</a>
									<?php else : ?>
										<?php echo $this->escape($item->title); ?>
									<?php endif; ?>
								</h2>
							<?php endif; ?>
							<div class="entry-meta">
								<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
											|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>
								<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
									<?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block ?>
									<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params, 'position' => '')); ?>
								<?php endif; ?>
							</div>
						</div>
					</header>
					<div class="entry-content">
						<?php echo $item->introtext; ?>
						<?php if ($params->get('show_readmore') && $item->readmore) :
							if ($params->get('access-view')) :
								$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
							else :
								$menu = JFactory::getApplication()->getMenu();
								$active = $menu->getActive();
								$itemId = $active->id;
								$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
								$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)));
							endif; 
							echo JLayoutHelper::render('joomla.content.readmore', array('item' => $item, 'params' => $params, 'link' => $link)); 
						endif; ?>
					</div>
				</div>
			</article>
<?php 
			if ( $count % 2 == 1 ) echo '</div>';
			if ( $count % 4 == 3 ) echo '</div>';
			$count++;
		endforeach; 
		if ( $count % 2 != 0 ) echo '</div>';
		if ( $count % 4 != 0 ) echo '</div>';
?>

<div class="row">
	<div class="center">
		<?php echo $this->pagination->getListFooter(); ?>
	</div>
</div>