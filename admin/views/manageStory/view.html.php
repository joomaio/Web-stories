<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HelloWorld View
 *
 * @since  0.0.1
 */
class StoriesViewManageStory extends JViewLegacy
{
	/**
	 * View form
	 *
	 * @var         form
	 */
	protected $form = null;
	protected $canDo;
	protected $toolbar;
	protected $category;

	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
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

		$this->canDo = JHelperContent::getActions('com_stories', 'story', $this->item->id);
		$this->addToolBar();
		// Display the template
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;

		// Hide Joomla Administrator Main menu
		//$input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);
		if ($isNew){
			$title = JText::_('COM_STORIES_STORY_NEW');
			if ( $this->canDo->get('core.create') ){
				JToolbarHelper::save('manageStory.save', 'JTOOLBAR_SAVE');
			}
			}
			else{
				$title = JText::_('COM_STORIES_STORY_EDIT');
				if ( $this->canDo->get('core.edit') ){
					JToolbarHelper::save('manageStory.save', 'JTOOLBAR_SAVE');
			}	
		}
		JToolbarHelper::title($title, 'story');
		JToolbarHelper::cancel( 'manageStory.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE' );
		$this->toolbar = JToolbar::getInstance()->render();
	}
}