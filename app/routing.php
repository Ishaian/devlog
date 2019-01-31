<?php
/**
 * This file hold all routes definitions.
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 * @link     https://github.com/WildCodeSchool/simple-mvc
 */

$routes = [
    'Item' => [ // Controller
        ['index', '/item', 'GET'], // action, url, method
        ['add', '/item/add', ['GET', 'POST']], // action, url, method
        ['edit', '/item/edit/{id:\d+}', ['GET', 'POST']], // action, url, method
        ['show', '/item/{id:\d+}', 'GET'], // action, url, method
        ['delete', '/item/delete/{id:\d+}', 'GET'], // action, url, method
    ],
    'Announce' => [ // Controller
        ['index', '/announce', 'GET'] , // action, url, method
        ['add', '/announce/add', ['GET','POST']], // action, url, method
        ['edit', '/announce/edit/{id:\d+}', ['GET', 'POST']], // action, url, method
        ['show', '/announce/{id:\d+}', ['GET', 'POST']], // action, url, method
        ['delete', '/announce/delete/{id:\d+}', 'GET'],
        ['showAnnounce', '/announce/showAnnounce/{id:\d+}', ['GET', 'POST']],
        ['quickSearch', '/quickAnnounce','GET'],
        ['search', '/searchAnnounce','GET'],
        // action, url, method
    ],
    'App' => [
        ['home', '/', 'GET'],
    ],
    'Admin' => [ // Controller
        ['indexAdmin', '/admin', 'GET'] , // action, url, method
        ['editAdmin', '/admin/edit/{id:\d+}', ['GET', 'POST']], // action, url, method
        ['deleteAdmin', '/admin/delete/{id:\d+}', 'GET'], // action, url, method
    ],
    'Connexion' => [ // Controller
        ['connexion', '/connexion', 'POST'] , // action, url, method
        ['signin', '/inscription', ['GET', 'POST']], // action, url, method
        ['logout', '/logout', 'GET'], // action, url, method
    ],
];
