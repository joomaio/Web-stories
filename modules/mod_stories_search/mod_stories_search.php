<?php

defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
$placeholder     = htmlspecialchars($params->get('placeholder', JText::_("MOD_SEARCH_FIELD_LABEL_TEXT_LABEL"), ENT_COMPAT, 'UTF-8'));
$buttonText      = htmlspecialchars($params->get('buttonText', 0, ENT_COMPAT, 'UTF-8'));
$filterCategory  = htmlspecialchars($params->get('filterCategory', 0, ENT_COMPAT, 'UTF-8'));
$filterDate = htmlspecialchars($params->get('filterDate', 0, ENT_COMPAT, 'UTF-8'));

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('a.title, a.id');
$query->from($db->quoteName('#__categories','a'));
$query->where("a.extension = ".$db->quote('com_stories'));
$db->setQuery((string)$query, 0, 10);
$categories = $db->loadAssocList();

require JModuleHelper::getLayoutPath('mod_stories_search', 'default');

?>