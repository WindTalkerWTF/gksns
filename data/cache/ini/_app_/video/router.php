<?php
return array (
  'resources' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'video' => 
        array (
          'route' => '/video',
          'defaults' => 
          array (
            'module' => 'video',
            'controller' => 'index',
            'action' => 'index',
          ),
        ),
        'video-index-view' => 
        array (
          'route' => 'video/view/:id/:page',
          'defaults' => 
          array (
            'module' => 'video',
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
