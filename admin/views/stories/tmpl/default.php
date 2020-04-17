<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php?option=com_stories&view=stories" method="post" id="adminForm" name="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo JHtmlSidebar::render(); ?>
	</div>
	<div id="j-main-container" class="span10">
	 <?php echo $this->message; ?>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"><?php echo JText::_('COM_STORIES_NUM'); ?></th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="55%">
				<?php echo JText::_('COM_STORIES_STORY_NAME') ;?>
			</th>
			<!-- <th width="15%">
				<?php echo JText::_('COM_STORIES_ADMINISTRATION_CATEGORIES') ;?>
			</th> -->
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
			<!-- <th width="5%">
				<?php echo JText::_('COM_STORIES_STORY_PUBLISHED'); ?>
			</th> -->
			<th width="2%">
				<?php echo JText::_('COM_STORIES_STORY_ID'); ?>
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
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
                        <a href="<?php echo JRoute::_('index.php?option=com_stories&task=story.edit&id=' . $row->id); ?>"> <?php echo $row->name; ?> </a>
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
						<!-- <td align="center">
							<?php echo JHtml::_('jgrid.published', 1, $i, 'stories.', true, 'cb'); ?>
						</td> -->
						<td align="center">
							<?php echo $row->id; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>