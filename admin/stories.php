<?php

defined('_JEXEC') or die('Restricted access');

JLoader::register('StoriesHelper', JPATH_COMPONENT . '/helpers/stories.php');

$controller = JControllerLegacy::getInstance('Stories');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

?>