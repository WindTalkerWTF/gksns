<?php
return array (
  'resources' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'site-index-add' => 
        array (
          'route' => 'site/add',
          'defaults' => 
          array (
            'module' => 'site',
            'controller' => 'index',
            'action' => 'add',
          ),
        ),
        'site-index-edit' => 
        array (
          'route' => 'site/edit/:id',
          'defaults' => 
          array (
            'module' => 'site',
            'controller' => 'index',
            'action' => 'edit',
            'id' => '0',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
          ),
        ),
        'site-index-index' => 
        array (
          'route' => 'site/:id/:page',
          'defaults' => 
          array (
            'module' => 'site',
            'controller' => 'index',
            'action' => 'index',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'site-index-view' => 
        array (
          'route' => 'site/view/:id/:page',
          'defaults' => 
          array (
            'module' => 'site',
            'controller' => 'index',
            'action' => 'view',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
      ),
    ),
  ),
);
