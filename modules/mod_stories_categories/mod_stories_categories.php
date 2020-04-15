<?php

defined('_JEXEC') or die;

JLoader::register('ModStoriesCategoriesHelper', __DIR__ . '/helper.php');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
$categories = ModStoriesCategoriesHelper::getCategories($params->get('count'));

require JModuleHelper::getLayoutPath('mod_stories_categories', 'default');

?>