<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="<?php echo JRoute::_('index.php?option=com_stories&view=category'); ?>" method="post" id="adminForm" name="adminForm">
	<h2 class="d-inline-block"><?php if ( $this->category['name'] ) echo JText::_('COM_STORIES_ADMINISTRATION_CATEGORIES').": ". $this->category['name']; ?></h2>
	<p><?php if ( $this->message ) echo $this->message; ?><p>
		<div class="container-fluid">
			<?php 
				foreach ($this->items as $key => $story ): 
					if ( $key % 3 == 0 ) echo "<div class='row' >";
			?>
				<div class="col-lg-4">
                    <div class="card mb-4 shadow-sm">
						<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&id='.$story->id.'&catid='.$this->category['id']); ?>">
							<?php if ( $story->feature_img ) { ?>
								<img src="<?php echo $story->feature_img; ?>" width="100%" height="225">
							<?php } else{ ?>
								<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
									<rect width="100%" height="100%" fill="#55595c"></rect>
									<text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
								</svg>
							<?php } ?>
						
							<div class="card-body">                                    
									<h5 class="mb-0"><?php echo $story->name; ?></h5>
									<small class="text-muted"><?php echo $story->created_time; ?></small>
								<p><?php echo JText::_('COM_STORIES_READMORE') ?></p>
							</div>
						</a>
                    </div>
            	</div>
			<?php
				if ( $key % 3 == 2 ) echo "</div>";
				endforeach; 
				echo "</div>";
			?>
		</div>
		<?php echo $this->pagination->getListFooter(); ?>
	
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>

</form>