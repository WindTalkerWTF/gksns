<?php
return array (
  'resources' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'msg-index-add' => 
        array (
          'route' => 'msg/add/:id',
          'defaults' => 
          array (
            'module' => 'msg',
            'controller' => 'index',
            'action' => 'add',
            'id' => '0',
          ),
          'reqs' => 
          array (
            'id' => '.*',
          ),
        ),
        'msg-index-notice' => 
        array (
          'route' => 'msg/notice/:page',
          'defaults' => 
          array (
            'module' => 'msg',
            'controller' => 'index',
            'action' => 'notice',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'page' => '(\\d*)',
          ),
        ),
      ),
    ),
  ),
);
