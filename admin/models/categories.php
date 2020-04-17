<?php

defined('_JEXEC') or die('Restricted access');

class StoriesModelCategories extends JModelList
{
      public function getListQuery(){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('a.id, a.name, a.description')
                  ->from($db->quoteName('#__stories_categories', 'a'));
            
            return $query;
      }

}