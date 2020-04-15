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

	public function loadByStory($id = 1){
		$query = $this->_db->getQuery(true);
		$query->select('id.id_cat, id.id_story')
					->where('id_story = '.$this->_db->quote($id))
					->from( $this->_db->quoteName( '#__story_of_category', 'id' ) );
		$query->select('a.name, a.id')
					->join('left', $this->_tbl.' a ON a.id = id.id_story ');
		$this->_db->setQuery($query);
        return $this->_db->loadAssoc();
	}

	public function load($keys = null, $reset = true)
	{
		// Implement \JObservableInterface: Pre-processing by observers
		$this->_observers->update('onBeforeLoad', array($keys, $reset));

		if (empty($keys))
		{
			$empty = true;
			$keys  = array();

			// If empty, use the value of the current key
			foreach ($this->_tbl_keys as $key)
			{
				$empty      = $empty && empty($this->$key);
				$keys[$key] = $this->$key;
			}

			// If empty primary key there's is no need to load anything
			if ($empty)
			{
				return true;
			}
		}
		elseif (!is_array($keys))
		{
			// Load by primary key.
			$keyCount = count($this->_tbl_keys);

			if ($keyCount)
			{
				if ($keyCount > 1)
				{
					throw new \InvalidArgumentException('Table has multiple primary keys specified, only one primary key value provided.');
				}

				$keys = array($this->getKeyName() => $keys);
			}
			else
			{
				throw new \RuntimeException('No table keys defined.');
			}
		}

		if ($reset)
		{
			$this->reset();
		}

		// Initialise the query.
		$query = $this->_db->getQuery(true)
			->select('*')
			->from($this->_tbl);
		$fields = array_keys($this->getProperties());

		foreach ($keys as $field => $value)
		{
			// Check that $field is in the table.
			if (!in_array($field, $fields))
			{
				throw new \UnexpectedValueException(sprintf('Missing field in database: %s &#160; %s.', get_class($this), $field));
			}

			// Add the search tuple to the query.
			$query->where($this->_db->quoteName($field) . ' = ' . $this->_db->quote($value));
		}

		$this->_db->setQuery($query);

		$row = $this->_db->loadAssoc();

		// Check that we have a result.
		if (empty($row))
		{
			$result = false;
		}
		else
		{
			// Bind the object with the row and return.
			$result = $this->bind($row);
		}

		// Implement \JObservableInterface: Post-processing by observers
		$this->_observers->update('onAfterLoad', array(&$result, $row));

		return $row;
	}


}
