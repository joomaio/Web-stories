<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_categories
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Category table
 *
 * @since  1.6
 */
class StoriesTableCategory extends JTable
{
	/**
	 * Method to delete a node and, optionally, its child nodes from the table.
	 *
	 * @param   integer  $pk        The primary key of the node to delete.
	 * @param   boolean  $children  True to delete child nodes, false to move them up a level.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.5
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__stories_categories', 'id', $db);
	}

	public function loadList($start = 0, $limit = 0){
		$query = $this->_db->getQuery(true)
					->select('a.name, a.id')
					->from( $this->_db->quoteName( $this->_tbl, 'a' ) );
		$this->_db->setQuery($query, $start, $limit);
        return $this->_db->loadAssocList();
	}

	public function loadAll(){
		$query = $this->_db->getQuery(true)
					->select('a.name, a.id')
					->from( $this->_db->quoteName( $this->_tbl, 'a' ));
		$this->_db->setQuery($query);
        return $this->_db->loadAssocList();
	}

}
