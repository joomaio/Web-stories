<?php

defined('_JEXEC') or die('Restricted access');

class StoriesModelSearch extends JModelList
{
    protected $keyword;
    protected $catid;
    protected $from;
    protected $to;

    public function __construct()
	{
        parent::__construct();
        $app = JFactory::getApplication();
        $input = $app->input;

        if ( !empty( $input->get('searchword') ) ) $this->setState('searchword', $input->get('searchword',' ','raw'));
        if ( !empty( $input->get('catid') ) ) $this->setState('catid', $input->get('catid', 0));
        if ( !empty( $input->get('from') ) ) $this->setState('from', $input->get('from', null, 'raw'));
        if ( !empty( $input->get('to') ) ) $this->setState('to', $input->get('to', null, 'raw'));
        $this->setState('limitstart', $input->get('limitstart', 0));
        
    }
      
    public function getListQuery(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id, a.name, a.created_time, a.created_user, a.feature_img')
                ->from($db->quoteName('#__stories', 'a'));
        if ( $this->getState('searchword') != ' ' ) {
            $this->keyword = $this->getState('searchword');
            $query->where("a.name like ".$db->quote("%$this->keyword%"));
        }
        if ( $this->getState('from') ) {
            $this->from = $this->getState('from');
            $query->where("a.created_time >= ".$db->quote($this->from));
        }
        if ( $this->getState('to') ) {
            $this->to = $this->getState('to');
            $query->where("a.created_time <= ".$db->quote($this->to));    
        }

        //Join over the categories.
        
        
        if ( $this->getState('catid') > 0 ) {
            $this->catid = $this->getState('catid',0,"int");
            $query->select('id.id_cat')
                ->join('left', $db->quoteName('#__story_of_category', 'id') . ' ON id.id_story = a.id')
                ->where('id.id_cat = '.$this->catid);
            $query->select('c.name as category, c.id as catid')
                ->join('left', $db->quoteName('#__stories_categories', 'c') . ' ON c.id = id.id_cat');
        }

        $query->select('u1.name AS creator')
                ->join('left', '#__users u1 ON u1.id = a.created_user');

        return $query;
    }

    // public function getForm($data = array(), $loadData = true){
    //     $form = $this->loadForm(
	// 		'search_form.xml',  // just a unique name to identify the form
	// 		'search',				// the filename of the XML form definition
	// 									// Joomla will look in the models/forms folder for this file
	// 		array(
	// 			'control' => 'jform',	// the name of the array for the POST parameters
	// 			'load_data' => $loadData	// will be TRUE
	// 		)
	// 	);

	// 	if (empty($form))
	// 	{
    //         $errors = $this->getErrors();
	// 		throw new Exception(implode("\n", $errors), 500);
	// 	}
	// 	return $form;
	// }
	
	// protected function loadFormData()
	// {
	// 	// Check the session for previously entered form data.
	// 	$data = JFactory::getApplication()->getUserState(
	// 		'com_stories.edit.story.data',
	// 		array()
	// 	);

	// 	if (empty($data))
	// 	{
    //         $data = array();
	// 	}

	// 	return $data;
	// }

    public function getKeyword(){
        return $this->keyword;
    }

    public function getCategory(){
        if ( !$this->catid ) return null;
        $categories = $this->getTable("Category","StoriesTable");
        return $categories->load($this->catid); 
    }

    public function getCategories(){
        $categories = $this->getTable("Category","StoriesTable");
        return $categories->loadAll(); 
    }

}