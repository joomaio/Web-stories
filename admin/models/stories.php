<?php

defined('_JEXEC') or die('Restricted access');

class StoriesModelStories extends JModelList
{
      public function getListQuery(){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('a.id, a.name, a.created_time, a.created_user, a.last_modified_time, a.last_modified_user')
                  ->from($db->quoteName('#__stories', 'a'));

            $query->select('u1.name AS creator, u2.name AS modifier')
                  ->join('left', '#__users u1 ON u1.id = a.created_user')
                  ->join('left', '#__users u2 ON u2.id = a.last_modified_user');
            
            return $query;
      }

}