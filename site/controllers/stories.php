<?php

defined('_JEXEC') or die('Restricted access');

class StoriesControllerStories extends JControllerForm{

    protected $view_item = 'form';
    protected $view_list = 'stories';

    /**
    * Method to get a table object, load it if necessary.
    *
    * @param   string  $type    The table name. Optional.
    * @param   string  $prefix  The class prefix. Optional.
    * @param   array   $config  Configuration array for model. Optional.
    *
    * @return  JTable  A JTable object
    *
    * @since   1.6
    */

    public function getModel($name = 'Stories', $prefix = 'StoriesModel', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function search(){
        
    }

}

?>