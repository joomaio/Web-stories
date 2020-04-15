<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class StoriesViewManagecategory extends JViewLegacy
{
	protected $form = null;
	protected $canDo;
	protected $toolbar;
	protected $category;

	public function display($tpl = null)
	{
		// Get the Data
		$this->form = $this->get('Form');		
		$this->item = $this->get('Item');
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		$this->canDo = JHelperContent::getActions('com_stories', 'category', $this->item->id);
		$this->addToolBar();
		// Display the template
		parent::display($tpl);
	}


	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;

		// Hide Joomla Administrator Main menu
		//$input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);
		if ($isNew){
			$title = JText::_('COM_STORIES_STORY_NEW');
			if ( $this->canDo->get('core.create') ){
				JToolbarHelper::save('managecategory.save', 'JTOOLBAR_SAVE');
			}
			}
			else{
				$title = JText::_('COM_STORIES_STORY_EDIT');
				if ( $this->canDo->get('core.edit') ){
					JToolbarHelper::save('managecategory.save', 'JTOOLBAR_SAVE');
			}	
		}
		JToolbarHelper::title($title, 'category');
		JToolbarHelper::cancel( 'managecategory.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE' );
		$this->toolbar = JToolbar::getInstance()->render();
	}
}