<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class StoriesViewStories extends JViewLegacy
{
	protected $message;
	protected $sidebar;
	protected $items;
	protected $canDo;

	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		if ( empty( $this->items ) ) $this->message = JText::_('COM_STORIES_STORIES_EMPTY') ;
		else $this->message = JText::_('COM_STORIES_STORIES_LIST') ;

		$this->canDo = JHelperContent::getActions('com_stories');
		$this->addToolBar();
		parent::display($tpl);
	}


	protected function addToolBar(){
		JToolbarHelper::title(JText::_("COM_STORIES_STORIES_LIST"), 'stories');
		StoriesHelper::addSubmenu('stories');
		if ( $this->canDo->get('core.create') ){
			JToolbarHelper::addNew('story.edit');
		}
		if ( $this->canDo->get('core.delete') ){
			JToolBarHelper::deleteList( JText::_('COM_STORIES_STORIES_DELETE'), "story.delete" );
		}
	}

}
?>