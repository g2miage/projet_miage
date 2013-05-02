<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
                
		$path = func_get_args();
                
		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
               if($title_for_layout == "Accueil"){
                    $this->layout = null; // la page d'accueil utilise un layout différent
                }else{
                    if($title_for_layout == "Contact"){
                        // si le formulaire est posté
                        if($this->request->data){
                            $name = $this->request->data['Page']['name'];
                            $email = $this->request->data['Page']['email'];
                            // Envoi du mail
                            App::uses('CakeEmail', 'Network/Email');
                            $mail = new CakeEmail();
                            $mail->from($email);
                            $mail->to('g2.miage@gmail.com');
                            $mail->cc($email);
                            $mail->subject("Contact de $name");
                            $mail->emailFormat('html');
                            $mail->template('mailprestataire');
                            $mail->viewVars(array(
                                    'eventTitle' => "Contact de $name",
                                    'username' => $name,
                                    'firstname' => '', 
                                    'lastname' => '',
                                    'message' => $this->request->data['Page']['desc']
                                )
                            );
                            $mail->send();
                            $this->Session->setFlash("Votre mail a bien été envoyé !", "notif");
                        }
                    }
                }
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));

                
	}
}
