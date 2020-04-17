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
        if ( !empty( $input->get('from') ) ) $this->setState('from', $input->get('from', null));
        if ( !empty( $input->get('to') ) ) $this->setState('to', $input->get('to', null));
        $this->setState('limitstart', $input->get('limitstart', 0));
        
    }
      
    public function getListQuery(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id, a.name, a.created_time, a.created_user, a.img')
                ->from($db->quoteName('#__stories', 'a'));

        // Join over the categories.
        $query->select('c.title as category, c.id as catid')
                ->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON c.id = a.catid');

        $query->select('u1.name AS creator')
                ->join('left', '#__users u1 ON u1.id = a.created_user');

        if ( $this->getState('searchword') != ' ' ) {
            $this->keyword = $this->getState('searchword');
            $query->where("a.name like ".$db->quote("%$this->keyword%"));
        }
        if ( $this->getState('catid') > 0 ) {
            $this->catid = $this->getState('catid');
            $query->where("c.id = ".$db->quote($this->catid));
        }
        if ( $this->getState('from') ) {
            $this->from = $this->getState('from');
            $query->where("a.created_time >= ".$db->quote($this->from));
        }
        if ( $this->getState('to') ) {
            $this->to = $this->getState('to');
            $query->where("a.created_time <= ".$db->quote($this->to));    
        }

        return $query;
    }

    public function getForm($data = array(), $loadData = true){
        $form = $this->loadForm(
			'search_form.xml',  // just a unique name to identify the form
			'search',				// the filename of the XML form definition
										// Joomla will look in the models/forms folder for this file
			array(
				'control' => 'jform',	// the name of the array for the POST parameters
				'load_data' => $loadData	// will be TRUE
			)
		);

		if (empty($form))
		{
            $errors = $this->getErrors();
			throw new Exception(implode("\n", $errors), 500);
		}
		return $form;
	}
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_stories.edit.story.data',
			array()
		);

		if (empty($data))
		{
            $data = array();
		}

		return $data;
	}

    public function getKeyword(){
        return $this->keyword;
    }

    public function getCategory(){
        if ( !$this->catid ) return null;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.title')
              ->from($db->quoteName('#__categories', 'a'))
              ->where(" a.id = $this->catid");
        $db->setQuery((string)$query);
        return $db->loadObject()->title; 
  }

}