<?php defined('_JEXEC') or die('Restricted access'); ?>

<div class="row">
    <div class="pull-right">
		<a href="<?php echo JRoute::_("index.php?option=com_stories&task=managecategory.edit&id=0"); ?>" class="waves-effect waves-light btn green btn-new">
			<?php echo JText::_("JTOOLBAR_NEW"); ?>
		</a>
    </div>
	<div class="pull-right">
        <div class="widget widget-search">
            <form role="search" method="post" class="search-form" action="<?php echo JRoute::_('index.php?option=com_stories&view=managecategories'); ?>" >
                <input type="text" class="form-control" name="searchword" placeholder="<?php echo JText::_('COM_STORIES_SEARCHWORD'); ?>">
                <button type="submit"><i class="material-icons">search</i></button>
            </form>
        </div>
	</div>
</div>
<form action="<?php echo JRoute::_('index.php?option=com_stories&view=managecategories'); ?>" method="post">
		<!-- <h3><?php //if ( $this->message ) echo $this->message; ?></h3> -->

		<div class="row">
		<div class="col s12">
	<?php if ( $this->items ): ?>
	<table class="centered">
		<thead>
            <tr>
                <th width="2%"><?php echo JText::_('COM_STORIES_NUM'); ?></th>
                <th width="15%"><?php echo JText::_('COM_STORIES_CATEGORY_NAME');?></th>
                <th width="65%"><?php echo JText::_('COM_STORIES_CATEGORIES_DESCRIPTION'); ?></th>
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
						<td>
                        <a href="<?php echo JRoute::_('index.php?option=com_stories&task=managecategory.edit&id=' . $row->id); ?>"> <?php echo $row->name; ?> </a>
						</td>
						<td>
							<?php echo $row->description; ?>
						</td>
						<td><a href="<?php echo JRoute::_('index.php?option=com_stories&task=managecategory.edit&id=' . $row->id); ?>" class="waves-effect waves-light btn blue"><i class="small material-icons">edit</i></a></td>
						<td><a href="<?php echo JRoute::_('index.php?option=com_stories&task=managecategory.delete&cid=' . $row->id); ?>" class="waves-effect waves-light btn red"><i class="small material-icons">delete</i></a></td>
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
</div>
</div>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
</form>
