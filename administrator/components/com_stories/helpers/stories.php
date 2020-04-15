<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HelloWorld component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   1.6
 */
abstract class StoriesHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */

	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_STORIES_SUBMENU_STORIES'),
			'index.php?option=com_stories',
			$submenu == 'stories'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_STORIES_SUBMENU_CATEGORIES'),
			'index.php?option=com_stories&view=categories',
			$submenu == 'categories'
        );
        $document = JFactory::getDocument();
		if ($submenu == 'categories') 
			$document->setTitle(JText::_('COM_STORIES_ADMINISTRATION_CATEGORIES'));
		else
			$document->setTitle(JText::_('COM_STORIES_ADMINISTRATION_STORIES'));
	}
}
?>