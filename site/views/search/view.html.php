<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class StoriesViewSearch extends JViewLegacy
{
	protected $message;
	protected $items;
	protected $keyword;
	protected $category;
	protected $categories;
	protected $form;

	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->keyword 		= $this->get('Keyword');
		$this->category     = $this->get('Category'); 
		$this->categories   = $this->get('Categories');
		// var_dump($this->items);
		// die;

		if ( empty( $this->items ) ) $this->message = JText::_('COM_STORIES_STORIES_EMPTY') ;
		else{
			$this->addFullPath();
			$this->hightlight();
		}
		
		parent::display($tpl);
	}

	protected function hightlight(){
		
		foreach ($this->items as $key => $row) {
			$string = $row->name;
			$pattern = '#'. preg_quote($this->keyword) .'#ui';
			$replacement = "<span class='hightlight'>\\0</span>";
			$this->items[$key]->name = preg_replace($pattern, $replacement, $string);
		}
	}

	protected function addFullPath(){
		
		foreach ($this->items as $key => $row) {
			if ( $row->feature_img ) $this->items[$key]->feature_img = JUri::base().$this->items[$key]->feature_img;
		}
	}

}
?>