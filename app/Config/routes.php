<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'accueil'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
        Router::connect('/img/captcha.jpg', array('controller' => 'users', 'action' => 'captcha'));

        // Inscription/connexion
        Router::connect('/inscription', array('controller' => 'Users', 'action' => 'signup'));
        Router::connect('/connexion', array('controller' => 'Users', 'action' => 'login'));
        
        // Routes pour les prestataires
        Router::connect(
            '/prestataires',
            array('controller' => 'Users', 'action' => 'suppliers')
        );
        
        Router::connect(
            '/prestataire/*',
            array('controller' => 'Users', 'action' => 'view')
        );
        
        //lien vers mon profil
        Router::connect(
            '/profil',
            array('controller' => 'Users', 'action' => 'profil')
        );
        
        // Routes pour les evenements
        Router::connect(
            '/evenements',
            array('controller' => 'Events', 'action' => 'index')
        );
        
        Router::connect(
            '/evenement/*',
            array('controller' => 'Events', 'action' => 'view')
        );
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
