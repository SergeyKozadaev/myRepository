<?php
// массив соответсвий URI вызваемым Controller/Action
//для некоторых URI используятся регулярные выражения
return array(
    // URI => controller/action

    'show/([0-9]+)/(\S+)' => 'site/page404', // обработка адрессов типа show/24/23/21 и show/11/qwer

    'show/([0-9]+)' => 'task/show/$1', // показывает заявку с определенным номером $1

    'show' => 'task/list',

    'list/([0-9]+)/(\S+)' => 'site/page404', // обработка адрессов типа list/24/23/21 и list/11/qwer

    'list/([0-9]+)' => 'task/list/$1', // показывает определенную страницу $1 со списком заявок

    'list' => 'task/list',

    'new.+' => 'site/page404',

    'new' => 'task/new',

    'register.+' => 'site/page404',

    'register' => 'user/register',

    'login.+' => 'site/page404',

    'login' => 'user/login',

    'logout' => 'user/logout',

    'downloadXML' => 'task/downloadXML',

    '' => 'site/index',
);
