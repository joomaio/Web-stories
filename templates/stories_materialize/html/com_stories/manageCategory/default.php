<?php

defined('_JEXEC') or die('Restricted access');

?>

<form action="<?php echo JRoute::_('index.php?option=com_stories&layout=edit&task=managecategory.edit&id=' . (int)$this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <h2>
            <?php echo
                empty($this->item->id) ? JText::_('COM_STORIES_CATEGORY_NEW') : JText::_('COM_STORIES_CATEGORY_EDIT'); 
            ?>
        </h2>
            <div class="row-fluid">
                <?php echo $this->form->renderFieldset('detail');  ?>    
            </div>
        <?php echo $this->toolbar; ?>
        <input id="jform_title" type="hidden" name="com_stories-message-title"/>        
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>