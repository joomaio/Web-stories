<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Hello Table class
 *
 * @since  0.0.1
 */
class StoriesTableStory extends JTable
{
    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  A database connector object
     */
    public function __construct(&$db)
    {
        parent::__construct('#__stories', 'id', $db);
    }

    public function getMax(){
        $query = $this->_db->getQuery(true)
                    ->select('MAX(id)')
					->from( $this->_db->quoteName( $this->_tbl ) );
		$this->_db->setQuery($query);
        return $this->_db->loadResult();
    }
    
}