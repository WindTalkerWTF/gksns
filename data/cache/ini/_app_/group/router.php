<?php
return array (
  'resources' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'group-index-index' => 
        array (
          'route' => 'group/list/*',
          'defaults' => 
          array (
            'module' => 'group',
            'controller' => 'index',
            'action' => 'index',
          ),
        ),
        'group-index-all-view' => 
        array (
          'route' => 'group/all-view/:page',
          'defaults' => 
          array (
            'module' => 'group',
            'controller' => 'index',
            'action' => 'all-view',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'page' => '(\\d*)',
          ),
        ),
        'group-index-view' => 
        array (
          'route' => 'group/view/:id/:page',
          'defaults' => 
          array (
            'module' => 'group',
            'controller' => 'index',
            'action' => 'view',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d+)',
            'page' => '(\\d+)',
          ),
        ),
        'group-index-g' => 
        array (
          'route' => 'group/:id/*',
          'defaults' => 
          array (
            'module' => 'group',
            'controller' => 'index',
            'action' => 'g',
            'id' => '0',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
          ),
        ),
        'group-index-my' => 
        array (
          'route' => 'group/my/:t',
          'defaults' => 
          array (
            'module' => 'group',
            'controller' => 'index',
            'action' => 'my',
            't' => '1',
          ),
          'reqs' => 
          array (
            'id' => '.*',
          ),
        ),
      ),
    ),
  ),
);
