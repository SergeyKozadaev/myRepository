<?php
// массив соответсвий URI вызваемым Controller/Action
//для некоторых URI используятся регулярные выражения
return array(
    // URI => controller/action

    '^show/(\d+)$' => 'task/show/$1', // показывает заявку с определенным номером $1

    '^list/(\d+)$' => 'task/list/$1', // показывает определенную страницу $1 со списком заявок

    '^list$' => 'task/list',

    '^new$' => 'task/new',

    '^register$' => 'user/register',

    '^login$' => 'user/login',

    '^logout$' => 'user/logout',

    '^downloadXML$' => 'task/downloadXML',

    '^noTasks$' => 'site/noTasks',

    '^404$' => 'site/page404',

    '' => 'site/index',
);
