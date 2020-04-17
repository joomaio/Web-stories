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
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class StoriesModelStory extends JModelAdmin
{
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
	protected $storyId;

	public function getTable($type = 'Story', $prefix = 'StoriesTable', $config = array())
    {
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function save($data){
		$storyCategory = $this->getTable("StoryCategory");
		$catid = $data['catid'];
		unset($data['catid']);
		
		parent::save($data);

		if ( $data['id'] == 0 ){
			$story = $this->getTable();
			$id = $story->getMax();
		}
		else {
			$id = $data['id'];
			$storyCategory->deleteByStory($id);
		}
		
		foreach( $catid as $value ){
			$storyCategory->insert($value,$id);
		}
	}

	
	public function delete(&$data){
		$story = $this->getTable();
		foreach ($data as $value){
            $story->delete($value);
        }
	}

	public function getItem($pk = null){
		$item = parent::getItem();
		$this->storyId = $item->id;
		return $item;
	}    

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
    public function getForm($data = array(), $loadData = true){
        $form = $this->loadForm(
			'story_form.xml',  		// just a unique name to identify the form
			'story',				// the filename of the XML form definition
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

	public function getCategories(){
		$categories = $this->getTable('Category');
		return $categories->loadAll();
	}

	public function getStoryCategories(){
		$storyCategory = $this->getTable('StoryCategory');
		return $storyCategory->loadByStory($this->storyId);
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
			$data = $this->getItem();
		}

		return $data;
	}
}

?>