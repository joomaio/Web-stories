<?php

defined('_JEXEC') or die('Restricted access');

?>

    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?php echo JText::_('COM_STORIES_HOMEPAGE') ?></a>
                    </li>
                    <?php if ( $this->category ): ?>
                        <li class="breadcrumb-item">
                        <a href="<?php echo JRoute::_('index.php?option=com_stories&view=category&id=' . (int)$this->category['id']); ?>"><?php echo $this->category['name']; ?></a>
                        </li>
                    <?php endif; ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $this->item->name; ?></li>
                </ol>
            </nav>
        <h2><?php echo $this->item->name; ?></h2>
        <?php if ( $this->item->feature_img ): ?>
        <img class="img-thumbnail mb-3" src="<?php echo $this->item->feature_img; ?>" width="50%" >
        <?php endif ?>
            <div class="stories-content"><?php echo $this->item->content; ?></div>
        </div>
    
    <span class="float-right">
        <?php if ( $this->category ): ?>
        <i><?php echo JText::_('COM_STORIES_CATEGORIES_OPTION') ?></i>
        <?php echo ": ".$this->category['name']; ?>
        <?php endif; ?>
    </span>

    </div>