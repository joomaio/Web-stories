<?php

defined('_JEXEC') or die('Restricted access');

class StoriesModelCategory extends JModelList
{
      protected $catid;

      public function __construct()
	{
		parent::__construct();
            $app    = JFactory::getApplication();
            $input = $app->input;
            if ( !empty( $input->get('id') ) ) 
                  $this->setState('id', $input->get('id', 0,"INT"));
            $this->catid = $this->getState('id');
      }

      public function getTable($type = 'Category', $prefix = 'StoriesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
      
      public function getListQuery(){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('a.id, a.name, a.created_time, a.created_user, a.last_modified_time, a.last_modified_user, a.feature_img')
                  ->from($db->quoteName('#__stories', 'a'));

            // Join over the categories.
            $query->select('id.id_cat')
                ->join('left', $db->quoteName('#__story_of_category', 'id') . ' ON id.id_story = a.id')
                ->where('id.id_cat = '.$this->catid);
            $query->select('c.name as category, c.id as catid')
                ->join('left', $db->quoteName('#__stories_categories', 'c') . ' ON c.id = id.id_cat');

            $query->select('u1.name AS creator')
                  ->join('left', '#__users u1 ON u1.id = a.created_user');
            
            return $query;
      }

      public function getCategory(){
            $category = $this->getTable();
            return $category->load($this->catid);
      }
      public function getCatid(){
            return $this->catid;
      }

}