<?php
return array (
  'resources' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'fontend-index-rss' => 
        array (
          'route' => 'rss',
          'defaults' => 
          array (
            'module' => 'home',
            'controller' => 'index',
            'action' => 'rss',
          ),
        ),
      ),
    ),
  ),
);
