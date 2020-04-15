<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_menu
 *
 * @since  1.5
 */
class ModStoriesCategoriesHelper
{
	/**
	 * Get a list of the menu items.
	 *
	 * @param   \Joomla\Registry\Registry  &$params  The module options.
	 *
	 * @return  array
	 *
	 * @since   1.5
	 */
	public static function getCategories($limit){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.name, a.id');
        $query->from($db->quoteName('#__stories_categories','a'));
        $db->setQuery((string)$query, 0, $limit);
        return $db->loadAssocList();
    }
}
