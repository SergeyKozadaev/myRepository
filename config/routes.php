<?php

// массив соответсвий URI вызваемым Controller/Action
//для некоторых URI используятся регулярные выражения
return array(

    // URI => controller/action
    'show/([0-9]+)' => 'task/show/$1', // показывает заявку с определенным номером $1

    'show' => 'site/index',

    'list/([0-9]+)' => 'task/list/$1', // показывает определенную страницу $1 со списком заявок

    'list' => 'task/list',

    'new' => 'task/new',

    'register' => 'user/register',

    'login' => 'user/login',

    'logout' => 'user/logout',

    'downloadXML' => 'task/downloadXML',

    '' => 'site/index',


);
