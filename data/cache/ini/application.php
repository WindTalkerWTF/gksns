<?php
return array (
  'phpSettings' => 
  array (
    'error_reporting' => '32767',
    'display_startup_errors' => '1',
    'display_errors' => '1',
  ),
  'resources' => 
  array (
    'modules' => 
    array (
      0 => '',
    ),
    'FrontController' => 
    array (
      'moduleDirectory' => '/Applications/MAMP/htdocs/yusns/apps',
      'moduleControllerDirectoryName' => 'controllers',
      'defaultModule' => 'home',
      'plugins' => 
      array (
        'common' => 'My_Controller_Plugin_Common',
      ),
      'params' => 
      array (
        'displayExceptions' => '1',
      ),
    ),
  ),
  'bootstrap' => 
  array (
    'path' => '/Applications/MAMP/htdocs/yusns/apps/Bootstrap.php',
    'class' => 'Bootstrap',
  ),
  'pluginPaths' => 
  array (
    'My_Application_Resource' => '/Applications/MAMP/htdocs/yusns/library/My/Application/Resource/',
  ),
);
