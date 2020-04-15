<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');
JHtml::_('behavior.core');


JFactory::getDocument()->addScriptDeclaration("
document.addEventListener('DOMContentLoaded', function() {
	var elems = document.querySelectorAll('.collapsible');
	var options = 'accordion';
	var instances = M.Collapsible.init(elems, options);
});
");
?>

<main class="container">
	<div class="row categories-list<?php echo $this->pageclass_sfx; ?>">
		<div class="list-all-categories">
			<?php
				echo JLayoutHelper::render('joomla.content.categories_default', $this);
				echo $this->loadTemplate('items');
			?>
		</div>
	</div>
</main>
