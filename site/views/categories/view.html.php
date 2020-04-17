<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class StoriesViewCategories extends JViewLegacy{

    protected $categories;
    protected $items;

    public function display($tpl = null){
        $this->categories = $this->get('Categories');
        $this->items      = $this->get('Items');
        parent::display($tpl);
    }

}

?>