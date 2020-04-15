<?php

defined('_JEXEC') or die('Restricted access');

class StoriesModelCategories extends JModelList
{     
    protected $categories;
    protected $catid;

    public function getTable($type = 'Category', $prefix = 'StoriesTable', $config = array())
    {
		return JTable::getInstance($type, $prefix, $config);
    }
    
    public function getCategories(){
        $categories = $this->getTable();
        $this->categories = $categories->loadList();
        return $this->categories;
    }
    
    public function getListQuery(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id, a.name, a.feature_img, a.created_time, a.created_user')
                ->from($db->quoteName('#__stories', 'a'));

        // Join over the categories.
        $query->select('c.id_cat')
                ->join('LEFT', $db->quoteName('#__story_of_category', 'c') . ' ON c.id_story = a.id')
                ->where('c.id_cat = '.$this->catid);
        $query->select('u1.name AS creator')
                ->join('left', '#__users u1 ON u1.id = a.created_user');
                
        return $query;
        // $query->select('a.id, a.name, a.feature_img, a.created_time, a.created_user')
        //         ->from($db->quoteName('#__stories', 'a'));

        // // Join over the categories.
                
        // $query->select('id.id_cat')
        //         ->join('LEFT', $db->quoteName('#__story_of_category', 'id') . ' ON id.id_story = a.id');
        // $query->select('c.name as category, c.id as catid')
        //         ->join('LEFT', $db->quoteName('#__stories_categories', 'c') . ' ON c.id = id.id_cat');
        // $query->where("id.id_cat = ".$db->quote($this->catid));

        // $query->select('id1.id_cat')
        //         ->join('LEFT', $db->quoteName('#__story_of_category', 'id1') . ' ON id1.id_story = a.id');
        // $query->select('c1.name as category1, c1.id as catid1')
        //         ->join('LEFT', $db->quoteName('#__stories_categories', 'c1') . ' ON c1.id = id1.id_cat');
        // $query->where("id1.id_story = a.id");

        // $query->select('u1.name AS creator')
        //         ->join('left', '#__users u1 ON u1.id = a.created_user');
    }

    public function getItems(){
        foreach ($this->categories as $key => $category) {
            $this->catid = $category['id'];
            $this->cache[$this->getStoreId()] = null;
            $this->query= null;
            $items[] = parent::getItems();
        }
        return $items;
    }

}