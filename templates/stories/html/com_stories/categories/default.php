<?php

defined('_JEXEC') or die('Restricted access');

?>

<?php foreach ($this->categories as $index => $category): ?>
<div class="container-fluid">
<?php if ( $this->items ): ?>
	<h2 class="d-inline-block"><?php echo $category['name']; ?></h2>
	<a href="<?php echo JRoute::_('index.php?option=com_stories&view=category&id='.$category['id']); ?>" class="btn btn-primary float-right"><?php echo JText::_('COM_STORIES_READMORE'); ?></a>
<?php foreach ($this->items[$index] as $key => $story ): 
		if ( $key % 3 == 0 ) echo "<div class='row' >";
?>
		<div class="col-lg-4">
    		<div class="card mb-4 shadow-sm">
				<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&id='.$story->id.'&catid='.$category['id']); ?>">
					<?php if ( $story->feature_img ) { ?>
						<img src="<?php echo $story->feature_img; ?>" width="100%" height="225">
					<?php } else{ ?>
						<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
							<rect width="100%" height="100%" fill="#55595c"></rect>
							<text x="50%" y="50%" fill="#eceeef" dy=".3em"><?php echo Jtext::_("TEMPLATE_STORIES_THUMBNAIL"); ?></text>
						</svg>
					<?php } ?>
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-center">                                       
								<h5 class="mb-0"><?php echo $story->name; ?></h5>
								<small class="text-muted"><?php echo $story->created_time; ?></small>
							</div>
							<p><?php echo JText::_('COM_STORIES_READMORE'); ?></p>
						</div>
				</a>	
            </div>
        </div>
<?php
		if ( $key % 3 == 2 ) echo "</div>";
		$dem=$key;
		endforeach; 
		if ( $dem % 3 != 2 ) echo "</div>";
	endif;
?>
</div>
    <?php endforeach; ?>
