<?php

defined('_JEXEC') or die('Restricted access');

class StoriesControllerCategory extends JControllerForm{

    public function getModel($name = 'Category', $prefix = 'StoriesModel', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
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
        $model = $this->getModel("Category");
        $model->delete($data);


        $message = JText::_('COM_STORIES_STORIES_DELETE_COMPLETE') ;
        JFactory::getApplication()->enqueueMessage($message);
        $this->setRedirect(JRoute::_('index.php?option=com_stories&view=categories', $message));
    }

}

?>