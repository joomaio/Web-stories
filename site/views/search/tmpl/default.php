<?php defined('_JEXEC') or die('Restricted access'); ?>

<div class="search-form mb-5">
<form action="<?php echo JRoute::_('index.php?option=com_stories&view=search'); ?>" method="post" id="adminForm" name="adminForm">	
	<h2 class="d-inline-block"><?php echo JText::_('COM_STORIES_SEARCH'); ?></h2>
	<div class="form-row"> 
		<!-- <?php //foreach ($this->form as $key => $value) : ?>
			<div class="form-group col-md-3">
				<?php //echo $value->renderField(); ?>
			</div>
		<?php //endforeach; ?> -->
		<div class="form-group col-md-3">
            <label for="search"><?php echo JText::_('COM_STORIES_SEARCHWORD'); ?></label>
            <input type="text" class="form-control" id="search" name="jform[searchword]">
		</div><div class="form-group col-md-3">
            <label for="catid"><?php echo JText::_('COM_STORIES_FIELD_CATID'); ?></label>
            <select class="form-control" id="catid" name="jform[catid]">
					<option value="0"><?php echo JText::_("COM_STORIES_ALL"); ?></option>
				<?php foreach( $this->categories as $category ): ?>
					<option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<div class="form-group col-md-3">
            <label for="form"><?php echo JText::_('COM_STORIES_FIELD_FROM'); ?></label>
            <input type="date" class="form-control" id="from" name="jform[from]">
		</div>
		<div class="form-group col-md-3">
            <label for="to"><?php echo JText::_('COM_STORIES_FIELD_TO'); ?></label>
            <input type="date" class="form-control" id="to" name="jform[to]">
		</div>
		<button type="submit" class="btn btn-primary"><?php echo JText::_('COM_STORIES_SEARCH'); ?></button>
	</div>
	<?php if ( $this->keyword ): ?><h1><?php echo JText::_('COM_STORIES_RESULT')." ".$this->keyword; ?></h1> <?php endif; ?>

		<div class="container-fluid">
			<?php 
				if ( $this->message ) echo $this->message;
				if ( $this->items )
					foreach ($this->items as $key => $story ): 
						if ( $key % 3 == 0 ) echo "<div class='row' >";
			?>
				<div class="col-lg-4">
                    <div class="card mb-4 shadow-sm">
						<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&layout=read&id='.$story->id.'&catid='.$story->catid); ?>">
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
				if ( count($this->items) % 3 != 2 ) echo "</div>";
			?>
		</div>
		<?php echo $this->pagination->getListFooter(); ?>
	
	
	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="option" value="com_stories" />
	<?php echo JHtml::_('form.token'); ?>

</form>
</div>
