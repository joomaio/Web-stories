<?php

defined('_JEXEC') or die('Restricted access');

?>

<?php foreach ($this->categories as $index => $category): ?>
<div class="grid-x cell-6">
	<div class="cell"> 
	<a class="float-right" href="<?php  echo JRoute::_('index.php?option=com_stories&view=category&id='.$category['id']); ?>"><h5><?php echo JText::_('COM_STORIES_READMORE'); ?></h5></a>
		<h3><?php echo $category['title']; ?></h3>
	</div>
	<div class="grid-x grid-margin-x">
	<?php foreach ($this->items[$index] as $key => $story ): ?>
    	<div class="card cell small-4">
			<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&id='.$story->id.'&catid='.$category['id']); ?>">
				<?php if ( $story->img ) { ?>
					<img src="<?php echo $story->img; ?>" style="height:225px;width=100%;" class="thumbnail">
				<?php } else{ ?>
					<svg class="thumnail" height="225px" width="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
						<rect  height="100%" fill="#55595c"></rect>
						<text x="50%" y="50%" fill="#eceeef" dy=".3em"><?php echo Jtext::_("TEMPLATE_STORIES_THUMBNAIL"); ?></text>
					</svg>
				<?php } ?>
					<div class="card-section">                              
						<h5 class="mb-0"><?php echo $story->name; ?></h5>
						<small class="text-muted"><?php echo $story->created_time; ?></small>
						<p><?php echo JText::_('COM_STORIES_READMORE'); ?></p>
					</div>
					
				</a>	
				
            </div>
	<?php endforeach; ?>
</div>
<?php endforeach; ?>
