<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="<?php echo JRoute::_('index.php?option=com_stories&view=manageStories'); ?>" method="post" id="adminForm" name="adminForm" class="form-inline form-row mt-2 mt-md-0">
	<div id="j-main-container" class="span10">
	
	<div class="float-right ml-3">
		<?php echo $this->toolbar; ?>
	</div>
	<div class="d-inline-block float-right">                                  
        <div class="input-group">
            <input type="text" name="searchword" class="form-control" placeholder="<?php echo JText::_('COM_STORIES_SEARCHWORD'); ?>" aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" id="button-addon2"><?php echo JText::_('COM_STORIES_SEARCH'); ?></button>
            </div>
        </div>
	</div>
	<h2><?php echo $this->message; ?></h2>
	<?php if ( $this->items ): ?>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"><?php echo JText::_('COM_STORIES_NUM'); ?></th>
			<th width="10%">
				<?php echo JText::_('COM_STORIES_ADMINISTRATION_CATEGORIES') ;?>
			</th>
			<th width="45%">
				<?php echo JText::_('COM_STORIES_STORY_NAME') ;?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_STORIES_STORY_CREATED_TIME'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_STORIES_STORY_CREATED_USER'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_STORIES_STORY_LAST_MODIFIED_TIME'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_STORIES_STORY_LAST_MODIFIED_USER'); ?>
			</th>
			<th width="4%">
				<?php echo JText::_('COM_STORIES_STORY_ACTION'); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : ?>

					<tr>
						<td>
							<?php echo $this->pagination->getRowOffset($i); ?>
						</td>
						<td><?php 
								if ( $row->category ) echo $row->category;
								else echo JText::_('COM_STORIES_CATEGORIES_NULL');
							?>
						</td>
						<td>
                        <a href="<?php echo JRoute::_('index.php?option=com_stories&task=manageStory.edit&id=' . $row->id); ?>"> <?php echo $row->name; ?> </a>
						</td>
						<td>
							<?php echo $row->created_time; ?>
						</td>
						<td>
							<?php 
								if ( $row->creator ) echo $row->creator; 
								else echo JText::_("COM_STORIES_EMPTY_USER");
							?>
						</td>
						<td>
							<?php echo $row->last_modified_time; ?>
						</td>
						<td>
							<?php 
								if ( $row->modifier ) echo $row->modifier; 
								else echo JText::_("COM_STORIES_EMPTY_USER");
							?>
						</td>
						<td align="center">
							<a href="<?php echo JRoute::_('index.php?option=com_stories&task=manageStory.delete&cid=' . $row->id); ?>" class="badge badge-danger mr-1"><?php echo JText::_("JTOOLBAR_DELETE"); ?></a>
							<a href="<?php echo JRoute::_('index.php?option=com_stories&task=manageStory.edit&id=' . $row->id); ?>" class="badge badge-success"><?php echo JText::_("JTOOLBAR_EDIT"); ?></a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<?php endif; ?>
	
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>