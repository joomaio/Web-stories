<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Including fallback code for the placeholder attribute in the search field.
JHtml::_('jquery.framework');

?>
<form action="<?php echo JRoute::_('index.php?option=com_stories&view=search');?>" method="post" 
	class="input-group" role="search" id="search" class="search<?php echo $moduleclass_sfx; ?>" >
    <h4><?php if ( $module->showtitle )  echo "<span>$module->title</span>"; ?></h4>
	<input class="input-group-field" name="jform[searchword]" id="mod_search_searchword<?php echo $module->id; ?>" maxlength="20" placeholder="<?php echo $placeholder; ?>"/>
	<?php if ( $filterCategory ): ?>
		<label for="inputState" class="input-group-label"><?php echo JText::_("COM_STORIES_CATEGORIES_OPTION"); ?></label>
		<select id="inputState" class="input-group-field" name="jform[catid]">
			<?php foreach ($categories as $key => $category): ?>
				<option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
			<?php endforeach; ?>
		</select>
	<?php endif; ?>
	<?php if ( $filterDate ): ?>
		<label for="inputZip1" class="input-group-label"><?php echo JText::_("COM_STORIES_FIELD_FROM"); ?></label>
		<input type="date" class="input-group-field" id="inputZip1" name="jform[form]">
		<label for="inputZip2" class="input-group-label"><?php echo JText::_("COM_STORIES_FIELD_TO"); ?></label>
		<input type="date" class="input-group-field" id="inputZip2" name="jform[to]">
	<?php endif; ?>
	<div class="input-group-button">
		<input type="submit" class="input-group-button button" value="<?php echo $buttonText; ?>" >
	</div>
	<input type="hidden" name="task" value="search" />
</form>

