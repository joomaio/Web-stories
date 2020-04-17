<?php

defined('_JEXEC') or die('Restricted access');

$numCol = 4;

?>


<form action="<?php echo JRoute::_('index.php?option=com_stories&task=stories.edit&id=' . (int)$this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', 
            empty($this->item->id) ? JText::_('COM_STORIES_STORY_EDIT') : JText::_('COM_STORIES_STORY_NEW')); 
        ?>
        <fieldset class="adminform">
            <?php echo $this->form->renderFieldset('detail');  ?>
            <!-- n cat - n story -->
            <!-- <div class="control-group">
                <div class="control-label">
                    <label for="select-catid"><?php echo JText::_("COM_STORIES_SELECT_CATEGORIES"); ?></label>
                </div>
                <div class="controls" id="select-catid">
                    
                    <table class="col-8">
                        <thead>
                            <tr>
                            <?php for( $i=0; $i < $numCol; $i++ ): ?>
                                <th width="2%"></th>
                                <th width="<?php echo ( 100 - 2*$numCol )/$numCol; ?>%"></th>
                            <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($this->categories as $key => $category): ?>
                                <?php if ( $key % $numCol == 0 ) echo "<tr>" ?>
                                <td>
                                <input type="checkbox" id="categoryid<?php echo $key; ?>" name="<?php echo "catid[$key]"; ?>" value="<?php echo $category['id'] ?>" <?php if ( isset( $this->checked[ (int)$category['id'] ] ) ) echo "checked"; ?> />
                                </td>
                                <td>
                                    <label for="categoryid<?php echo $key; ?>"><?php echo $category['name']; ?></label>
                                </td>
                                <?php if ( $key % $numCol == $numCol - 1 ) echo "</tr>" ?>
                            <?php endforeach; ?>
                            <?php if ( count($this->categories) % ($numCol-1) ) echo "</tr>" ?>
                        </tbody>
                    </table>
                </div> 
            </div> -->
            <!-- n cat - n story -->
            <div class="control-group">
                <div class="control-label">
                    <label for="select-catid"><?php echo JText::_("COM_STORIES_FIELD_CATID"); ?></label> 
                </div>
                <div class="controls" id="select-catid">
                        <!-- 1 cat - n story -->
                    <select name="catid[0]" class="form-control">
                        <option value="0"><?php echo JText::_("COM_STORIES_FIELD_CATID"); ?></option>
                        <?php foreach($this->categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" <?php if (isset( $this->checked[ (int)$category['id'] ] )) echo 'selected="selected"'; ?> >
                                <?php echo $category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>    
                </div> 
            </div>
        </fieldset>
    <?php echo JHtml::_('bootstrap.endTab'); ?>

        <!-- <?php //echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('COM_STORIES_TAB_PERMISSIONS')); ?>
            <fieldset class="adminform">
                <div class="row-fluid">
                    <div class="span12">
                        <?php //echo $this->form->renderFieldset('accesscontrol');  ?>
                    </div>
                </div>
            </fieldset>
        <?php echo JHtml::_('bootstrap.endTab'); ?> -->
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
        <input id="jform_title" type="hidden" name="com_stories-message-title"/>        
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>