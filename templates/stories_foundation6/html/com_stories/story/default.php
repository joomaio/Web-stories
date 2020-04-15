<?php

defined('_JEXEC') or die('Restricted access');

?>

<form action="<?php echo JRoute::_('index.php?option=com_stories&layout=edit&task=story.edit&id=' . (int)$this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
            <nav aria-label="breadcrumb">
                <ul class="breadcrumbs">
                    <li>
                        <a href="<?php echo JRoute::_('index.php'); ?>"><?php echo JText::_('COM_STORIES_HOMEPAGE') ?></a>
                    </li>
                    <?php if ( $this->category ): ?>
                    <li>
                        <a href="<?php echo JRoute::_('index.php?option=com_stories&view=category&id=' . (int)$this->category->id); ?>"><?php echo $this->category->title; ?></a>
                    </li>
                    <?php endif; ?>
                    <li class="disable" aria-current="page"><?php echo $this->item->name; ?></li>
                </ul>
            </nav>
        <h2><?php echo $this->item->name; ?></h2>
        <?php if ( $this->item->img ): ?>
        <img class="img-thumbnail mb-3" src="<?php echo $this->item->img; ?>" width="50%" >
        <?php endif ?>
            <div class="stories-content"><?php echo $this->item->content; ?></div>
    <input type="hidden" name="boxchecked" value="<?php echo $this->item->id;  ?>"/>
    <span class="float-right">
        <?php if ( $this->category ): ?>
        <i><?php echo JText::_('COM_STORIES_CATEGORIES_OPTION') ?></i>
        <?php echo ": ".$this->category->title; ?>
        <?php endif; ?>
    </span>
</form>