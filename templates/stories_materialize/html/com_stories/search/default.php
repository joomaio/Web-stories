<?php defined('_JEXEC') or die('Restricted access'); ?>

<div class="search-form mb-5">
<form action="<?php echo JRoute::_('index.php?option=com_stories&view=search'); ?>" method="post" id="adminForm" name="adminForm">	
	<h2 class="d-inline-block"><?php echo JText::_('COM_STORIES_SEARCH'); ?></h2>
	<div class="row"> 
		<?php foreach ($this->form as $key => $value) : ?>
			<div class="col s3">
				<?php echo $value->renderField(); ?>
			</div>
		<?php endforeach; ?>
		<div class="col s3"> 
			<label for="inputZip1"><?php echo JText::_("COM_STORIES_FIELD_FROM"); ?></label>
			<input type="date" class="input-group-field" id="inputZip1" name="jform[form]">
		</div>
		<div class="col s3">
			<label for="inputZip2"><?php echo JText::_("COM_STORIES_FIELD_TO"); ?></label>
			<input type="date" class="input-group-field" id="inputZip2" name="jform[to]">
		</div>
		<button type="submit" class="waves-effect waves-light btn-large btn"><?php echo JText::_('COM_STORIES_SEARCH'); ?></button>
	</div>
	<?php if ( $this->keyword ): ?><h1><?php echo JText::_('COM_STORIES_RESULT')." ".$this->keyword; ?></h1> <?php endif; ?>
		<div class="row">
				<h3><?php echo $this->category; ?></h3>
		</div>
<?php 
	foreach ($this->items as $key => $story ): 
		if ( $key % 3 == 0 ) echo "<div class='row' >";
?>
			<div class="cards-container col s4">
				<div class="card">
				<div class="card-image">
					<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&id='.$story->id.'&catid='.$story->catid); ?>">
						<?php if ( $story->img ) { ?>
							<img src="<?php echo $story->img; ?>" style="height:225px;width=100%;" class="thumbnail">
						<?php } else{ ?>
							<svg class="thumnail" height="225px" width="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
								<rect  height="100%" fill="#55595c"></rect>
								<text x="50%" y="50%" fill="#eceeef" dy=".3em"><?php echo Jtext::_("TEMPLATE_STORIES_THUMBNAIL"); ?></text>
							</svg>
						<?php } ?>
						</div>
						<div class="card-action">                              
							<h5 class="mb-0"><?php echo $story->name; ?></h5>
							<small class="text-muted"><?php echo $story->created_time; ?></small>
							<p><?php echo JText::_('COM_STORIES_READMORE'); ?></p>
						</div>
					</a>	
				</div>
			</div>
<?php
		if ( $key % 3 == 2 ) echo "</div>";
		endforeach; 
		echo "</div>";
?>
	<div class="row"><?php echo $this->pagination->getListFooter(); ?></div>
	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="option" value="com_stories" />
	<?php echo JHtml::_('form.token'); ?>

</form>
</div>
