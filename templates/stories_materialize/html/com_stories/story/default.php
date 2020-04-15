<?php

defined('_JEXEC') or die('Restricted access');

?>

<div class="posts-content single-post">
    <article class="post-wrapper">
        <header class="entry-header-wrapper clearfix">
            <div class="entry-header">
                <h2 class="entry-title"><?php echo $this->item->name; ?></h2>
                <div class="entry-meta">
                    <ul class="list-inline">
                        <li>
                        <p> <?php echo JText::_("TPL_STORIES_AUTHOR").": ".$this->item->created_user; ?></p>
                        </li>
                        <li class="breadcrumb-item">
                        <a href="<?php echo JRoute::_('index.php?option=com_stories&view=category&id=' . (int)$this->category['id']); ?>"><?php echo $this->category['name']; ?></a>
                    </li>
                        <li>
                        <p> <?php echo JText::_("TPL_STORIES_PUBLISHED").": ".$this->item->created_time; ?></p>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="thumb-wrapper">
            <img src="<?php echo $this->item->feature_img; ?>" class="img-responsive" alt="">
        </div>
        <div class="entry-content">
            <p><?php echo $this->item->content; ?></p>
        </div>
    </article>
</div>