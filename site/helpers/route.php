<?php

defined('_JEXEC') or die;

abstract class StoriesHelperRoute
{
	/**
	 * Get the article route.
	 *
	 * @param   integer  $id        The route of the content item.
	 * @param   integer  $catid     The category ID.
	 * @param   integer  $language  The language code.
	 * @param   string   $layout    The layout value.
	 *
	 * @return  string  The article route.
	 *
	 * @since   1.5
	 */
	public static function getStoryRoute($id = 0, $catid = 0, $layout = null)
	{
		// Create the link
		$link = 'index.php?option=com_stories&view=story&id=' . $id;

		if ((int) $catid > 1)
		{
			$link .= '&catid=' . $catid;
		}

		if ($layout)
		{
			$link .= '&layout=' . $layout;
		}

		return JRoute::_($link);
	}

	/**
	 * Get the category route.
	 *
	 * @param   integer  $catid     The category ID.
	 * @param   integer  $language  The language code.
	 * @param   string   $layout    The layout value.
	 *
	 * @return  string  The article route.
	 *
	 * @since   1.5
	 */
	public static function getCategoryRoute($catid = 0, $layout = null)
	{
		$id = (int) $catid;

		if ($id < 1)
		{
			return '';
		}

		$link = 'index.php?option=com_stories&view=category&id=' . $id;

		if ($layout)
		{
			$link .= '&layout=' . $layout;
		}

		return JRoute::_($link);
	}

	public static function getManagestoryRoute($id = 0)
	{
		return JRoute::_('index.php?option=com_stories&task=managestory.edit&id=' . (int) $id);
    }
    
    public static function getManagecategoryRoute($id = 0)
	{
		return JRoute::_('index.php?option=com_stories&task=managecategory.edit&id=' . (int) $id);
	}
}
