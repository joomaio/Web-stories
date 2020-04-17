<?php

defined('_JEXEC') or die('Restricted access');

?>


<form action="<?php echo JRoute::_('index.php?option=com_stories&task=category.edit&id=' . (int)$this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', 
            empty($this->item->id) ? JText::_('COM_STORIES_STORY_EDIT') : JText::_('COM_STORIES_STORY_NEW')); 
        ?>
        <fieldset class="adminform">
            <div class="row-fluid">
                    <?php echo $this->form->renderFieldset('detail');  ?>
            </div>
        </fieldset>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
        <input id="jform_title" type="hidden" name="com_stories-message-title"/>        
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>