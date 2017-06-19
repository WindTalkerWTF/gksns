<?php
return array (
  'resources' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'ask-index-index' => 
        array (
          'route' => 'ask/:t/:page',
          'defaults' => 
          array (
            'module' => 'ask',
            'controller' => 'index',
            'action' => 'index',
            't' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            't' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'ask-index-view' => 
        array (
          'route' => 'ask/view/:id/:page',
          'defaults' => 
          array (
            'module' => 'ask',
            'controller' => 'index',
            'action' => 'view',
            'id' => '1',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'ask-index-add' => 
        array (
          'route' => 'ask/add',
          'defaults' => 
          array (
            'module' => 'ask',
            'controller' => 'index',
            'action' => 'add',
          ),
        ),
        'ask-index-edit' => 
        array (
          'route' => 'ask/edit/:id',
          'defaults' => 
          array (
            'module' => 'ask',
            'controller' => 'index',
            'action' => 'edit',
            'id' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
          ),
        ),
        'ask-tag-index' => 
        array (
          'route' => 'ask/tag/:t/:page',
          'defaults' => 
          array (
            'module' => 'ask',
            'controller' => 'tag',
            'action' => 'index',
            't' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            't' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
      ),
    ),
  ),
);
