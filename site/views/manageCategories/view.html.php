<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class StoriesViewManagecategories extends JViewLegacy
{
	protected $message;
	protected $toolbar;
	protected $items;
	protected $canDo;
	protected $pagination;

	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->canDo = JHelperContent::getActions('com_stories');
		$this->addToolBar();

		if ( empty( $this->items ) ) $this->message = JText::_('COM_STORIES_CATEGORIES_EMPTY') ;
		else $this->message = JText::_('COM_STORIES_CATEGORIES_LIST') ;
		
		parent::display($tpl);
	}


	protected function addToolBar(){
		JToolbarHelper::title(JText::_("COM_STORIES_STORIES_LIST"), 'stories');
		if ( $this->canDo->get('core.create') ){
			JToolbarHelper::addNew('managecategory.edit');
			$this->toolbar = JToolbar::getInstance()->render();
		}
	}

}
?>