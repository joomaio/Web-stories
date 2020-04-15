<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class StoriesViewCategory extends JViewLegacy
{
	protected $message;
	protected $items;
	protected $category;
	protected $catid;

	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->category     = $this->get('Category'); 

		if ( empty( $this->items ) ) $this->message = JText::_('COM_STORIES_STORIES_EMPTY') ;
		else $this->message = JText::_('COM_STORIES_STORIES_LIST') ;
		
		$this->addFullPath();
		
		parent::display($tpl);
	}

	protected function addFullPath(){
		
		foreach ($this->items as $key => $row) {
			if ( $row->feature_img ) $this->items[$key]->feature_img = JUri::base().$this->items[$key]->feature_img;
		}
	}

}
?>