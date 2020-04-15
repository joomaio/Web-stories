<?php defined('_JEXEC') or die('Restricted access'); 

?>

<form action="<?php echo JRoute::_('index.php?option=com_stories&view=category'); ?>" method="post" id="adminForm" name="adminForm">
	<div class="grid-x">
		<div class="cell"> 
			<h3><?php echo $this->category; ?></h3>
		</div>
		<div class="grid-x grid-margin-x">
		<?php foreach ($this->items as $key => $story ): ?>
			<div class="card cell small-4">
				<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&id='.$story->id.'&catid='.$this->catid); ?>">
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
		<div class="cell"><?php echo $this->pagination->getListFooter(); ?></div>
	
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
</form>