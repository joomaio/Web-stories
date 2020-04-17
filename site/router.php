<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Routing class of com_content
 *
 * @since  3.3
 */
// class StoriesRouter implements JComponentRouterInterface{
// 	public function build(&$query)
//     {
//         $segments = array();
//         if (isset($query['view'])){
//             $segments[] = $query['view'];
//             unset($query['view']);
//         }
//         if ( isset($query['id']) && empty( $query['task'] ) ){
//             $segments[] = $query['id'];
//             unset($query['id']);
//         }
//         if ( isset($query['catid']) && empty($query['searchword']) ){
//             $segments[] = $query['catid'];
//             unset($query['catid']);
//         }
//         if (isset($query['layout'])){
//             unset($query['layout']);
//         };
//         return $segments;
//     }
      
//     public function parse(&$segments)
//     {
//         $vars = array();
//         $vars['view'] = $segments[0];
        
//         switch($segments[0])
//         {
//             case 'category':
//                 $id = explode(':', $segments[1]);
//                 $vars['catid'] = (int) $id[0];
//                 break;
//             case 'story':
//                 $id = explode(':', $segments[1]);
//                 $vars['id'] = (int) $id[0];
//                 $vars['layout'] = "read";
//                 break;
//             case 'managecategory':
//                 if ( isset($segments[1]) ) $id = explode(':', $segments[1]);
//                 else $id=0;
//                 $vars['id'] = (int) $id[0];
//                 break;
//             case 'managestory':
//                 if ( isset($segments[1]) ) $id = explode(':', $segments[1]);
//                 else $id=0;
//                 $vars['id'] = (int) $id[0];
//                 break;
//         }
//         return $vars;
//     }
//     public function preprocess($query)
// 	{
// 		return $query;
// 	}
// }
class StoriesRouter extends JComponentRouterView
{
	protected $noIDs = false;

	/**
	 * Content Component router constructor
	 *
	 * @param   JApplicationCms  $app   The application object
	 * @param   JMenu            $menu  The menu object to work with
	 */
	public function __construct($app = null, $menu = null)
	{
		
		$categories = new JComponentRouterViewconfiguration('categories');
		//$categories->setKey('id');
        $this->registerView($categories);
        
		$category = new JComponentRouterViewconfiguration('category');
		$category->setKey('id')->setParent($categories);
        $this->registerView($category);
        
		$story = new JComponentRouterViewconfiguration('story');
		$story->setKey('id')->setParent($category, 'catid');
        $this->registerView($story);
        
        $managecategories = new JComponentRouterViewconfiguration('managecategories');
		$this->registerView($managecategories);
		
        $managecategory = new JComponentRouterViewconfiguration('managecategory');
		$managecategory->setKey('id')->setParent($managecategories);
		$this->registerView($managecategory);


        $managestories = new JComponentRouterViewconfiguration('managestories');
        $this->registerView($managestories);

        $managestory = new JComponentRouterViewconfiguration('managestory');
		$managestory->setKey('id')->setParent($managestories);
        $this->registerView($managestory);

        $search = new JComponentRouterViewconfiguration('search');
        $this->registerView($search);

        parent::__construct($app, $menu);

		$this->attachRule(new JComponentRouterRulesMenu($this));
		$this->attachRule(new JComponentRouterRulesStandard($this));
        $this->attachRule(new JComponentRouterRulesNomenu($this));
	}

	public function getStorySegment($id, $query)
	{
		return array((int) $id => $id);
	}
	
	public function getStoryId($segment, $query)
	{
		return (int) $segment;
	}

	public function getCategorySegment($id, $query)
	{
		return array((int) $id => $id);
	}
	
	public function getCategoryId($segment, $query)
    {
		return (int) $segment;
    }
	
	public function getCategoriesSegment($id, $query)
	{
		return $this->getCategorySegment($id, $query);
	}

	public function getCategoriesId($segment, $query)
	{
		return $this->getCategoryId($segment, $query);
	}

	///////////////////////////////////////////////
	///////////////////////////////////////////////'///////////////////////////////////////////////
	///////////////////////////////////////////////

	///////////////////////////////////////////////
	

    public function getManagecategorySegment($id, $query){
        return $this->getCategorySegment($id, $query);
    }

    public function getManagecategoryId($segment, $query){
        return $this->getCategoryId($segment, $query);
    }

    public function getManagestorySegment($id, $query){
        return $this->getStorySegment($id, $query);
    }

    public function getManagestoryId($segment, $query){
        return $this->getStoryId($segment, $query);
    }

    public function getManagecategoriesSegment($id, $query){

    }

    public function getManagecategoriesId($id, $query){

    }

    public function getManagestoriesSegment($id, $query){

    }

    public function getSearchSegment($id, $query){
        //return array( $id => $id );
    }
	
	
}
?>
