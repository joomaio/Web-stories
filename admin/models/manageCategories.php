<?php

defined('_JEXEC') or die('Restricted access');

class StoriesModelManageCategories extends JModelList
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
            //$this->setState('limit', 5);
        }
    }
      
      public function getListQuery(){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('c.id, c.title, c.description')
                  ->from( $db->quoteName('#__categories', 'c') )
                  ->where( "extension = ".$db->quote('com_stories'));
            $search = $this->getState('searchword');
            if ( $search != ' ' && $search != null ){
                  $query->where("c.title like ".$db->quote("%$search%"));
            }
            
            return $query;
      }

}