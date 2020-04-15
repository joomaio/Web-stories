<?php defined('_JEXEC') or die('Restricted access'); ?>

<div class="row">
    <div class="pull-right">
		<a href="<?php echo JRoute::_("index.php?option=com_stories&task=managestory.edit&id=0"); ?>" class="waves-effect waves-light btn green btn-new">
			<?php echo JText::_("JTOOLBAR_NEW"); ?>
		</a>
    </div>
	<div class="pull-right">
        <div class="widget widget-search">
            <form role="search" method="post" class="search-form" action="<?php echo JRoute::_('index.php?option=com_stories&view=managestories'); ?>" >
                <input type="text" class="form-control" name="searchword" placeholder="<?php echo JText::_('COM_STORIES_SEARCHWORD'); ?>">
                <button type="submit"><i class="material-icons">search</i></button>
            </form>
        </div>
	</div>
</div>
<form action="<?php echo JRoute::_('index.php?option=com_stories&view=managestories'); ?>" method="post">
	<div class="row">
		<div class="col s12">
	<?php if ( $this->items ): ?>
	<table class="centered">
        <thead>
            <tr>
                <th width="1%"><?php echo JText::_('COM_STORIES_NUM'); ?></th>
                <!-- <th width="8%"><?php echo JText::_('COM_STORIES_ADMINISTRATION_CATEGORIES') ;?></th> -->
                <th width="42%"><?php echo JText::_('COM_STORIES_STORY_NAME') ;?></th>
            	<th width="10%"><?php echo JText::_('COM_STORIES_STORY_CREATED_TIME'); ?></th>
                <th width="10%"><?php echo JText::_('COM_STORIES_STORY_CREATED_USER'); ?></th>
                <th width="10%"><?php echo JText::_('COM_STORIES_STORY_LAST_MODIFIED_TIME'); ?></th>
                <th width="14%"><?php echo JText::_('COM_STORIES_STORY_LAST_MODIFIED_USER'); ?></th>
                <th width="9%"><?php echo JText::_('TPL_STORIES_ACTION_EDIT'); ?></th>
				<th width="9%"><?php echo JText::_('TPL_STORIES_ACTION_DELETE'); ?></th>
            </tr>
        </thead>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : ?>

					<tr>
						<td>
							<?php echo $this->pagination->getRowOffset($i); ?>
						</td>
						<!-- <td><?php 
								if ( $row->category ) echo $row->category;
								else echo JText::_('COM_STORIES_CATEGORIES_NULL');
							?>
						</td> -->
						<td>
                        <a href="<?php echo JRoute::_('index.php?option=com_stories&task=managestory.edit&id=' . $row->id); ?>"> <?php echo $row->name; ?> </a>
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
						<td><a href="<?php echo JRoute::_('index.php?option=com_stories&task=managestory.edit&id=' . $row->id); ?>" class="waves-effect waves-light btn blue"><i class="small material-icons">edit</i></a></td>
						<td><a href="<?php echo JRoute::_('index.php?option=com_stories&task=managestory.delete&cid=' . $row->id); ?>" class="waves-effect waves-light btn red"><i class="small material-icons">delete</i></a></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<div class="row">
			<div class="center">
				<?php echo $this->pagination->getListFooter(); ?>
			</div>
		</div>
	<?php endif; ?>
	
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
</form>