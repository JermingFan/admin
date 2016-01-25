<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// visitor cannot view these pages
$config['auth'] = array(
  //'account' => array('settings'),
  'article' => array('add', 'edit'),
  'feeds' => array('index')
);