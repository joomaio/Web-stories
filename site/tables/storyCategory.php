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
class StoriesTableStoryCategory extends JTable
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
		parent::__construct('#__story_of_category', '', $db);
	}
	
	public function loadByStory($id){
		$query = $this->_db->getQuery(true)
				->select('a.id_cat')
				->from( $this->_db->quoteName( $this->_tbl,'a' ));
		if ( $id > 0 )
			$query->where( $this->_db->quoteName("a.id_story").' = '.$id  );
		else return array();
		$query->select('c.name')
				->join('left', $this->_db->quoteName('#__stories_categories','c').' ON c.id = a.id_cat');
		$query->order('a.id_cat ASC');
		$this->_db->setQuery($query);
		return $this->_db->loadAssocList();
	}

	public function loadByCategory($id){
        
	}

	public function insert($id_cat, $id_story){
		$columns = array( "id_cat","id_story" );
		$values = array( $id_cat, $id_story );
		$query = $this->_db->getQuery(true)
						->insert($this->_tbl)
						->columns($this->_db->quoteName($columns))
						->values(implode(',', $values));
		$this->_db->setQuery($query);
		$this->_db->execute();
	}
    
    public function deleteByStory($id){
		$query = $this->_db->getQuery(true);
		$conditions = array(
			'id_story = '. $id
		);

		$query->delete($this->_db->quoteName($this->_tbl));
		$query->where($conditions);
		$this->_db->setQuery($query);
		$this->_db->execute();
	}

}
?>
