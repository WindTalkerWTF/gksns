<?php
return array (
  'appname' => 'yusns',
  'site' => 
  array (
    'salt' => 
    array (
      'key' => '19607614248377875937',
    ),
    'title' => 
    array (
      'word' => 
      array (
        'count' => '120',
      ),
    ),
    'config' => 
    array (
      'isrewrite' => '0',
    ),
    'pwd' => 
    array (
      'join' => 
      array (
        'salt' => '1',
      ),
    ),
  ),
  'app' => 
  array (
    'core' => 
    array (
      0 => 'home',
      1 => 'admin',
      2 => 'user',
      3 => 'msg',
    ),
  ),
  'cache' => 
  array (
    'file' => 
    array (
      'dir' => 'file',
    ),
    'handle' => 'file',
    'memcache' => 
    array (
      'lifetime' => '3600',
      'server' => 
      array (
        1 => 
        array (
          'ip' => '127.0.0.1',
          'port' => '11211',
          'weight' => '10',
        ),
      ),
    ),
  ),
  'session' => 
  array (
    'handle' => 'db',
    'domain' => '.gk.com',
  ),
);
