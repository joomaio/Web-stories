<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Date\Date; 
use Joomla\CMS\Factory;

class StoriesController extends JControllerLegacy{
	protected $default_view = 'categories';

	public function search(){
		$data = $this->input->getVar('jform',array());
		$params = array('view' => 'search');

		if ( isset($data['searchword']) ) {
			$params['searchword']  = $data['searchword'];
			$params['limitstart'] = 0;
		}
		else $params['searchword'] =' ';
		if ( isset($data['catid']) )      $params['catid']    = $data['catid'];
		else $params['catid']='0';
        if ( !empty($data['from']) ){
            $params['from']     = JFactory::getDate($data['from'])->toSQL();
		}
		else $params['from']     = "0000-00-00 00:00:00";
        if ( !empty($data['to']) ){
            $params['to']       = JFactory::getDate($data['to'])->toSQL();
		}
		else $params['to']      = JFactory::getDate('now')->toSQL();

		
		$uri = JUri::getInstance();
		$uri->setQuery($params);
		$uri->setVar('option', 'com_stories');

		$this->setRedirect(JRoute::_('index.php' . $uri->toString(array('query', 'fragment')), false));
	}
}

?>