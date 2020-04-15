<?php defined('_JEXEC') or die('Restricted access'); 
?>

<form action="<?php echo JRoute::_('index.php?option=com_stories&view=managecategories'); ?>" method="post" id="adminForm" name="adminForm" class="">
	<div id="j-main-container" class="span10">
	<div class="d-inline-block float-right">                                  
        <div class="input-group">
            <input type="text" name="searchword" class="form-control" placeholder="<?php echo JText::_('COM_STORIES_SEARCHWORD'); ?>" aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" id="button-addon2"><?php echo JText::_('COM_STORIES_SEARCH'); ?></button>
            </div>
			<button class="ml-3 btn btn-primary" >
				<a href="<?php echo JRoute::_("index.php?option=com_stories&task=managecategory.edit&id=0"); ?>"><?php echo JText::_("JTOOLBAR_NEW"); ?></a>
			</button>
        </div>
    </div>
	<h2><?php if ( $this->message ) echo $this->message; ?></h2>
	<?php if ( $this->items ): ?>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"><?php echo JText::_('COM_STORIES_NUM'); ?></th>
			<th width="20%">
				<?php echo JText::_('COM_STORIES_CATEGORY_NAME');?>
			</th>
			<th width="69%">
				<?php echo JText::_('COM_STORIES_CATEGORIES_DESCRIPTION'); ?>
			</th>
			<th width="10%">
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
						<td>
                        <a href="<?php echo JRoute::_('index.php?option=com_stories&task=managecategory.edit&id=' . $row->id); ?>"> <?php echo $row->name; ?> </a>
						</td>
						<td>
							<?php echo $row->description; ?>
						</td>
						<td align="center">
							<a href="<?php echo JRoute::_('index.php?option=com_stories&task=managecategory.delete&cid=' . $row->id); ?>" class="badge badge-danger mr-1"><?php echo JText::_("JTOOLBAR_DELETE"); ?></a>
							<a href="<?php echo JRoute::_('index.php?option=com_stories&task=managecategory.edit&id=' . $row->id); ?>" class="badge badge-success"><?php echo JText::_("JTOOLBAR_EDIT"); ?></a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
				<?php endif; ?>
	<input type="hidden" name="task">
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>