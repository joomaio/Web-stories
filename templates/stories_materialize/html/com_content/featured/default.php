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

JHtml::_('behavior.caption');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space

?>


<main class="container blog-featured<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<?php foreach ($this->lead_items as &$item) : ?>
			<?php if ( $leadingcount % 2 == 0 ) echo '<div class="row">'; ?>
			<div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> col m6 ">
				<article class="post-wrapper feature-article card">
					<?php 
							$this->item = &$item;
							echo $this->loadTemplate('item'); 
					?>
				</article>
			</div>
			<?php
				if ( $leadingcount % 2 == 1 ) echo '</div>';
				$leadingcount++;
			?>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php
		$introcount = ( $leadingcount % 2 ) * 2;
	?>
	<?php if (!empty($this->intro_items)) : ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
			<?php if ( $introcount % 4 == 0 ) echo '<div class="row">'; ?>
				<?php if ( $introcount % 2 == 0 ) echo '<div class="col m6">'; ?>
						<article class="post-wrapper list-article card">
							<?php
									$this->item = &$item;
									echo $this->loadTemplate('item');
							?>
						</article>
				<?php 
					if ( $introcount % 2 == 1 ) echo '</div>';
					if ( $introcount % 4 == 3 ) echo '</div>';
					$introcount++;
				?>
		<?php endforeach; ?>
		<?php if ( $introcount % 2 != 0 ) echo '</div>'; ?>
		<?php if ( $introcount % 4 != 0 ) echo "</div>"; ?>
	<?php endif; ?>

<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>
	<div class="row">
		<div class="center">
			<?php echo $this->pagination->getListFooter(); ?>
		</div>
	</div>
<?php endif; ?>
</main>
