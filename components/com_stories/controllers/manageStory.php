<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Date\Date; 
use Joomla\CMS\Factory;

class StoriesControllerManagestory extends JControllerForm{

    public function getModel($name = 'Managestory', $prefix = 'StoriesModel', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    protected function allowAdd($data = array())
    {
        return parent::allowAdd($data);
    }
    /**
    * Implement to allow edit or not
    * Overwrites: JControllerForm::allowEdit
    *
    * @param array $data
    * @param string $key
    * @return bool
    */
    protected function allowEdit($data = array(), $key = 'id')
    {
        $id = isset( $data[ $key ] ) ? $data[ $key ] : 0;
        if( !empty( $id ) )
        {
            return JFactory::getUser()->authorise( "core.edit", "com_stories.message." . $id );
        }
        return 1;
    }

    protected function canDelete(){
		return JFactory::getUser()->authorise('core.delete', $this->option);
	}

    public function delete(){
        if ( !$this->canDelete() ){
            $message = JText::_('COM_STORIES_ACCESS_DELETE_FAILED') ;
            JFactory::getApplication()->enqueueMessage($message);
            $this->setRedirect(JRoute::_('index.php?option=com_stories&view=managestories', $message));
            return;
        }

        $app = JFactory::getApplication();
        $input = $app->input;
        $data  = $input->get('cid', array(), 'array');
        $model = $this->getModel("Story");
        $model->delete($data);


        $message = JText::_('COM_STORIES_STORIES_DELETE_COMPLETE') ;
        JFactory::getApplication()->enqueueMessage($message);
        $this->setRedirect(JRoute::_('index.php?option=com_stories&view=managestories', $message));
    }

    public function save($key = null, $urlVar = null)
	{
		// Check for request forgeries.
		$this->checkToken();

		$app   = \JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();
        $data  = $this->input->post->get('jform', array(), 'array');
        $data['catid'] = $this->input->post->get('catid', array(), 'array');
        $currentTime = new Date('now');
		$user = Factory::getUser();
		$data['last_modified_time'] = $currentTime->toSQL();
		$data['last_modified_user'] = $user->id;
        if ( $data['id'] == null ) {
            $data['created_time'] = $currentTime->toSQL(); 
	        $data['created_user'] = $user->id; 
        }

        $model->save($data);
        if ( $data['id'] > 0 )
            $message = JText::_('COM_STORIES_EDIT_SUCCESSFUL') ;
        else  $message = JText::_('COM_STORIES_ADD_SUCCESSFUL') ;
        JFactory::getApplication()->enqueueMessage($message);
        $this->setRedirect(JRoute::_('index.php?option=com_stories&view=managestories'),"");
        
	}

}

?>