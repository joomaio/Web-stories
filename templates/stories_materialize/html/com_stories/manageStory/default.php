<?php

defined('_JEXEC') or die('Restricted access');

$numCol=4;

?>


<form action="<?php echo JRoute::_('index.php?option=com_stories&layout=edit&task=managestory.edit&id=' . (int)$this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <h2>
            <?php echo
                empty($this->item->id) ? JText::_('COM_STORIES_STORY_NEW') : JText::_('COM_STORIES_STORY_EDIT'); 
            ?>
        </h2>
        <?php echo $this->form->renderFieldset('detail');  ?>    
        <div class="controls">
            <label for="select-catid"><?php echo JText::_("COM_STORIES_SELECT_CATEGORIES"); ?></label>
            <table class="col-8 none-bordered" id="select-catid">
                <thead>
                    <tr>
                        <?php for( $i=0; $i < $numCol; $i++ ): ?>
                        <th width="<?php echo ( 100 )/$numCol; ?>%"></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($this->categories as $key => $category): ?>
                        <?php if ( $key % $numCol == 0 ) echo "<tr>" ?>
                            <td>
                                <label for="categoryid<?php echo $key; ?>">
                                <input type="checkbox" id="categoryid<?php echo $key; ?>" name="<?php echo "catid[$key]"; ?>" value="<?php echo $category['id'] ?>" <?php if ( isset( $this->checked[ (int)$category['id'] ] ) ) echo 'checked="checked"'; ?> />
                                <span><?php echo $category['name']; ?><span>
                                </label>
                            </td>
                        <?php if ( $key % $numCol == $numCol - 1 ) echo "</tr>" ?>
                    <?php endforeach; ?>
                    <?php if ( count($this->categories) % ($numCol-1) ) echo "</tr>" ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->toolbar; ?>
        <input id="jform_title" type="hidden" name="com_stories-message-title"/>        
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>