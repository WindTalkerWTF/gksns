<?php
return array (
  'resources' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'user-index-index' => 
        array (
          'route' => 'user/:id',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'index',
            'id' => '0',
          ),
          'reqs' => 
          array (
            'id' => '.*',
          ),
        ),
        'user-index-login' => 
        array (
          'route' => 'login',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'login',
          ),
        ),
        'user-index-reg' => 
        array (
          'route' => 'reg',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'reg',
          ),
        ),
        'user-setting-index' => 
        array (
          'route' => 'setting/:action',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'setting',
            'action' => 'index',
          ),
          'reqs' => 
          array (
            'action' => '.*',
          ),
        ),
        'user-index-logout' => 
        array (
          'route' => 'logout',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'logout',
          ),
        ),
        'user-index-follow' => 
        array (
          'route' => 'user/follow/:id/:page',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'follow',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'user-index-interested' => 
        array (
          'route' => 'user/interested/:id/:page',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'interested',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'user-index-blog' => 
        array (
          'route' => 'user/blog/:id/:page',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'blog',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'user-index-answer' => 
        array (
          'route' => 'user/answer/:id/:page',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'answer',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'user-index-ask' => 
        array (
          'route' => 'user/ask/:id/:page',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'ask',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'user-index-post' => 
        array (
          'route' => 'user/post/:id/:page',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'post',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'user-index-feed' => 
        array (
          'route' => 'user/feed/:id/:page',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'feed',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'user-index-tag' => 
        array (
          'route' => 'user/tag/:id/:page',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'tag',
            'id' => '0',
            'page' => '1',
          ),
          'reqs' => 
          array (
            'id' => '(\\d*)',
            'page' => '(\\d*)',
          ),
        ),
        'user-index-group' => 
        array (
          'route' => 'user/group/:id/:page',
          'defaults' => 
          array (
            'module' => 'user',
            'controller' => 'index',
            'action' => 'group',
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
