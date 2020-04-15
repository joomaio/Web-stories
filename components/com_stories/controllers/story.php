<?php

defined('_JEXEC') or die('Restricted access');

class StoriesControllerStory extends JControllerForm{

    public function getModel($name = 'Story', $prefix = 'StoriesModel', $config = array('ignore_request' => true))
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
            $this->setRedirect(JRoute::_('index.php?option=com_stories&view=categories', $message));
            return;
        }

        $app = JFactory::getApplication();
        $input = $app->input;
        $data  = $input->get('cid', array(), 'array');
        $model = $this->getModel("Story");
        $model->delete($data);


        $message = JText::_('COM_STORIES_STORIES_DELETE_COMPLETE') ;
        JFactory::getApplication()->enqueueMessage($message);
        $this->setRedirect(JRoute::_('index.php?option=com_stories&view=categories', $message));
    }

}

?>