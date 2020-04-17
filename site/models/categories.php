<?php

defined('_JEXEC') or die('Restricted access');

class StoriesModelCategories extends JModelList
{     
    protected $categories;
    protected $catid;

    public function __construct()
	{
        parent::__construct();

    }

    public function getTable($type = 'Category', $prefix = 'StoriesTable', $config = array())
    {
		return JTable::getInstance($type, $prefix, $config);
    }
    
    public function getCategories(){
        $categories = $this->getTable();
        $app = JFactory::getApplication();
        $input = $app->input;
        if ( !empty( $input->get('numStories') ) ) $this->setState('list.limit', $input->get('numStories','3','int'));
        $this->categories = $categories->loadList( 0, $input->get('numCat','5','int') );
        return $this->categories;
    }
    
    public function getListQuery(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id, a.name, a.feature_img, a.created_time, a.created_user')
                ->from($db->quoteName('#__stories', 'a'));

        // Join over the categories.
        $query->select('c.id_cat')
                ->join('LEFT', $db->quoteName('#__story_of_category', 'c') . ' ON c.id_story = a.id')
                ->where('c.id_cat = '.$this->catid);
        $query->select('u1.name AS creator')
                ->join('left', '#__users u1 ON u1.id = a.created_user');
                
        return $query;
        // $query->select('a.id, a.name, a.feature_img, a.created_time, a.created_user')
        //         ->from($db->quoteName('#__stories', 'a'));

        // // Join over the categories.
                
        // $query->select('id.id_cat')
        //         ->join('LEFT', $db->quoteName('#__story_of_category', 'id') . ' ON id.id_story = a.id');
        // $query->select('c.name as category, c.id as catid')
        //         ->join('LEFT', $db->quoteName('#__stories_categories', 'c') . ' ON c.id = id.id_cat');
        // $query->where("id.id_cat = ".$db->quote($this->catid));

        // $query->select('id1.id_cat')
        //         ->join('LEFT', $db->quoteName('#__story_of_category', 'id1') . ' ON id1.id_story = a.id');
        // $query->select('c1.name as category1, c1.id as catid1')
        //         ->join('LEFT', $db->quoteName('#__stories_categories', 'c1') . ' ON c1.id = id1.id_cat');
        // $query->where("id1.id_story = a.id");

        // $query->select('u1.name AS creator')
        //         ->join('left', '#__users u1 ON u1.id = a.created_user');
    }

    protected function populateState($ordering = null, $direction = null)
	{
		// If the context is set, assume that stateful lists are used.
		if ($this->context)
		{
			$app         = \JFactory::getApplication();
			$inputFilter = \JFilterInput::getInstance();

			// Receive & set filters
			if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array'))
			{
				foreach ($filters as $name => $value)
				{
					// Exclude if blacklisted
					if (!in_array($name, $this->filterBlacklist))
					{
						$this->setState('filter.' . $name, $value);
					}
				}
            }
            $limit = $app->input->get('numStories','3','int');

			// Receive & set list options
			if ($list = $app->getUserStateFromRequest($this->context . '.list', 'list', array(), 'array'))
			{
				foreach ($list as $name => $value)
				{
					// Exclude if blacklisted
					if (!in_array($name, $this->listBlacklist))
					{
						// Extra validations
						switch ($name)
						{
							case 'fullordering':
								$orderingParts = explode(' ', $value);

								if (count($orderingParts) >= 2)
								{
									// Latest part will be considered the direction
									$fullDirection = end($orderingParts);

									if (in_array(strtoupper($fullDirection), array('ASC', 'DESC', '')))
									{
										$this->setState('list.direction', $fullDirection);
									}
									else
									{
										$this->setState('list.direction', $direction);

										// Fallback to the default value
										$value = $ordering . ' ' . $direction;
									}

									unset($orderingParts[count($orderingParts) - 1]);

									// The rest will be the ordering
									$fullOrdering = implode(' ', $orderingParts);

									if (in_array($fullOrdering, $this->filter_fields))
									{
										$this->setState('list.ordering', $fullOrdering);
									}
									else
									{
										$this->setState('list.ordering', $ordering);

										// Fallback to the default value
										$value = $ordering . ' ' . $direction;
									}
								}
								else
								{
									$this->setState('list.ordering', $ordering);
									$this->setState('list.direction', $direction);

									// Fallback to the default value
									$value = $ordering . ' ' . $direction;
								}
								break;

							case 'ordering':
								if (!in_array($value, $this->filter_fields))
								{
									$value = $ordering;
								}
								break;

							case 'direction':
								if (!in_array(strtoupper($value), array('ASC', 'DESC', '')))
								{
									$value = $direction;
								}
								break;

							case 'limit':
								$value = $inputFilter->clean($value, 'int');
                                $limit = $value;
								break;

							case 'select':
								$explodedValue = explode(',', $value);

								foreach ($explodedValue as &$field)
								{
									$field = $inputFilter->clean($field, 'cmd');
								}

								$value = implode(',', $explodedValue);
								break;
						}

						$this->setState('list.' . $name, $value);
					}
				}
			}
			else
			// Keep B/C for components previous to jform forms for filters
			{
				// Pre-fill the limits
				if ( empty($limit) ) $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'), 'uint');
				$this->setState('list.limit', $limit);

				// Check if the ordering field is in the whitelist, otherwise use the incoming value.
				$value = $app->getUserStateFromRequest($this->context . '.ordercol', 'filter_order', $ordering);

				if (!in_array($value, $this->filter_fields))
				{
					$value = $ordering;
					$app->setUserState($this->context . '.ordercol', $value);
				}

				$this->setState('list.ordering', $value);

				// Check if the ordering direction is valid, otherwise use the incoming value.
				$value = $app->getUserStateFromRequest($this->context . '.orderdirn', 'filter_order_Dir', $direction);

				if (!in_array(strtoupper($value), array('ASC', 'DESC', '')))
				{
					$value = $direction;
					$app->setUserState($this->context . '.orderdirn', $value);
				}

				$this->setState('list.direction', $value);
			}

			// Support old ordering field
			$oldOrdering = $app->input->get('filter_order');

			if (!empty($oldOrdering) && in_array($oldOrdering, $this->filter_fields))
			{
				$this->setState('list.ordering', $oldOrdering);
			}

			// Support old direction field
			$oldDirection = $app->input->get('filter_order_Dir');

			if (!empty($oldDirection) && in_array(strtoupper($oldDirection), array('ASC', 'DESC', '')))
			{
				$this->setState('list.direction', $oldDirection);
			}

			$value = $app->getUserStateFromRequest($this->context . '.limitstart', 'limitstart', 0, 'int');
            $limitstart = ($limit != 0 ? (floor($value / $limit) * $limit) : 0);
			$this->setState('list.start', $limitstart);
		}
		else
		{

            $this->setState('list.start', 0);
			$this->setState('list.limit', 0);
		}
	}

    public function getItems(){
        
        foreach ($this->categories as $key => $category) {
            $this->catid = $category['id'];
            $this->cache[$this->getStoreId()] = null;
            $this->query= null;
            $items[] = parent::getItems();
        }
        return $items;
    }

}