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

<form action="<?php echo JRoute::_('index.php');?>" method="post" 
	class="form-inline form-row mt-2 mt-md-0" role="search" id="search" class="search<?php echo $moduleclass_sfx; ?>" >
	<h4><?php if ( $module->showtitle )  echo "<span>$module->title</span>"; ?></h4>
	<?php
		$output = '<input name="jform[searchword]" id="mod_search_searchword' .$module->id. '"  class="form-control mr-sm-2" type="search" maxlength="20"';
		$output .= 'placeholder="' . $placeholder . '" />';
		echo $output;
	?>
	<?php if ( $filterCategory ): ?>
		<div class="form-group col-md-3">
            <label for="inputState"><?php echo JText::_("COM_STORIES_CATEGORIES_OPTION"); ?></label>
                <select id="inputState" class="form-control" name="jform[catid]">
					<?php foreach ($categories as $key => $category): ?>
						<option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
					<?php endforeach; ?>
                </select>
        </div>
	<?php endif; ?>
	<?php if ( $filterDate ): ?>
		<div class="form-group col-md-3">
			<label for="inputZip1"><?php echo JText::_("COM_STORIES_FIELD_FROM"); ?></label>
			<input type="date" class="form-control" id="inputZip1" name="jform[form]">
		</div>
		<div class="form-group col-md-3">
			<label for="inputZip2"><?php echo JText::_("COM_STORIES_FIELD_TO"); ?></label>
			<input type="date" class="form-control" id="inputZip2" name="jform[to]">
		</div>
	<?php endif; ?>
	<input type="submit" class="btn btn-primary" value="<?php echo $buttonText; ?>" >
	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="option" value="com_stories" />
</form>

