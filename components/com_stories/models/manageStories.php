<?php

defined('_JEXEC') or die('Restricted access');

class StoriesModelManagestories extends JModelList
{
      public function __construct()
	{
        parent::__construct();
        $app = JFactory::getApplication();
        $input = $app->input;

        if ( !empty( $input->get('searchword') ) ) 
        {
            $this->setState('searchword', $input->get('searchword',' ','raw'));
            $this->setState('limitstart', $input->get('limitstart', 0));
        }
    }
      
      public function getListQuery(){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('a.id, a.name, a.created_time, a.created_user, a.last_modified_time, a.last_modified_user')
                  ->from($db->quoteName('#__stories', 'a'));


            $query->select('u1.name AS creator, u2.name AS modifier')
                  ->join('left', '#__users u1 ON u1.id = a.created_user')
                  ->join('left', '#__users u2 ON u2.id = a.last_modified_user');
            $search = $this->getState('searchword');
            if ( $search != ' ' && $search != null ){
                  $query->where("a.name like ".$db->quote("%$search%"));
            }
            
            return $query;
      }

}