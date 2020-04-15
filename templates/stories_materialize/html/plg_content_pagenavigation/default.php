<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagenavigation
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$lang = JFactory::getLanguage();

?>

<nav class="single-post-navigation white" role="navigation">
    <div class="row">
        <div class="col m6">
            <?php if ($row->prev) :
	            $direction = $lang->isRtl() ? 'right' : 'left'; ?>
                <div class="previous-post-link">
                    <a class="waves-effect waves-light" href="<?php echo $row->prev; ?>">
                        <?php echo '<span class="icon-chevron-' . $direction . '" aria-hidden="true"></span> <span aria-hidden="true">' . $row->prev_label . '</span>'; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
                
        <div class="col m6">
            <?php if ($row->next) :
                $direction = $lang->isRtl() ? 'left' : 'right'; ?>
                <div class="next-post-link">
                    <a class="waves-effect waves-light" href="<?php echo $row->next; ?>">
                    <?php echo '<span aria-hidden="true">' . $row->next_label . '</span> <span class="icon-chevron-' . $direction . '" aria-hidden="true"></span>'; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div> 
</nav>