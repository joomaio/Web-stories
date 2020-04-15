<?php

defined('_JEXEC') or die;
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
$intro           = htmlspecialchars($params->get('intro'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_stories_intro', 'default');

?>