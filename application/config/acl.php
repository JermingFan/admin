<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// visitor cannot view these pages
$config['auth'] = array(
    'admin' => array('index'),
    'user' => array('userList', 'userEdit', 'userBlack', 'userManage'),
    'dream' => array('dreamList', 'dreamEdit', 'dreamBlack', 'commentList', 'commentEdit', 'commentBlack'),
    'mood' => array('moodList', 'moodEdit', 'moodBlack', 'commentList', 'commentEdit', 'commentBlack'),
    'timeline' => array('timelineList', 'timelineEdit', 'timelineBlack', 'commentList', 'commentEdit', 'commentBlack'),
    'article' => array('articleList', 'articleEdit', 'articleBlack', 'commentList', 'commentEdit', 'commentBlack'),
    'group' => array('groupList', 'groupEdit', 'groupBlack', 'commentList', 'commentEdit', 'commentBlack'),

);