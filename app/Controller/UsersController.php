<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 * @author Cheikh (et moi)
 */
class UsersController extends AppController {

    // Helper GoogleMap
    public $helpers = array('GoogleMap');
    
     public $components = array(
        'Captcha' => array(
            'rotate' => true
        ),
        'RequestHandler'
    );

    public function signup() {
        $this->loadModel('Suptype');
        $supt = $this->Suptype->find('list', array('fields' => array('stype')));
        $this->set(array('stype' => $supt));
        if ($this->request->is('post')) {
            $this->User->setCaptcha($this->Captcha->getCode());
            $this->User->set('captcha',$this->User->captcha);
            $d = $this->request->data;
            if (!empty($d['User']['password'])) {
                $d['User']['password'] = Security::hash($d['User']['password'], null, true);
            }
            if (!empty($d['User']['password_confirm'])) {
                $d['User']['password_confirm'] = Security::hash($d['User']['password_confirm'], null, true);
            }
            
            $d['User']['creationdate'] = date('Y-m-d H:i:s');
            if ($d['User']['role_id'] == 0) {
                $d['User']['scorpname'] = '';
                $d['User']['ssiret'] = '';
                $d['User']['suptype_id'] = 0;
                $d['User']['sdesc'] = '';
                $d['User']['address'] = '';
                $d['User']['zip'] = '';
                $d['User']['city'] = '';
                $d['User']['country'] = '';
            }
            if ($this->User->save($d, true, array('username', 'password', 'mail', 'creationdate', 'scorpname', 'ssiret', 'suptype_id', 'sdesc','address','zip','city','country','captcha'))) {
                $link = array('controller' => 'users', 'action' => 'activate', $this->User->id . '-' . md5($d['User']['password']));
                App::uses('CakeEmail', 'Network/Email');
                $mail = new CakeEmail();
                $mail->from('no-reply@events.com')
                        ->to($d['User']['mail'])
                        ->subject('Activation compte Events')
                        ->emailFormat('html')
                        ->template('signup')
                        ->viewVars(array('username' => $d['User']['username'], 'link' => $link))
                        ->send();
                $this->Session->setFlash("Votre compte a bien été créé. Vous allez recevoir un mail d'activation", 'notif');
                $this->redirect('/');
            } else {
                $this->Session->setFlash('Merci de corriger vos erreurs', 'notif', array(
                    'type' => 'error'));
            }
        }
    }

    public function logout() {
        $this->Auth->logout();
        $this->redirect('/');
    }

    public function login() {
        if ($this->Auth->login()) {
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('lastlogin', date('Y-m-d H:i:s'));
            $this->Session->setFlash("Vous êtes connecté", "notif");
            $this->redirect('/');
        } else {
            $this->Session->setFlash("Indendifiants incorrects", "notif", array('type' => 'error'));
        }
    }

    public function activate($token) {
        $token = explode('-', $token);
        //$this->User->contain('User');
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $token[0], 'active' => 0),
            'recursive'=>-1
        ));
        
        
        
        if (!empty($user)) {
            $this->User->id = $user['User']['id'];
            $this->User->saveField('active', 1);
            $this->Session->setFlash("Votre compte a bien été activé", "notif");
            $this->Auth->login($user['User']);
        } else {
            $this->Session->setFlash("Votre lien ne semble pas valide", "notif", array('type' => 'error'));
        }
        $this->redirect('/');
    }

    public function profil() {
        $user_id = $this->Auth->user('id');
        if (!$user_id) {
            $this->redirect('/');
            die();
        }
        $user_id = $this->Auth->user('id');
        $user = $this->User->findById($user_id);
        $v = array('user' => $user);
        $this->set($v);

        if ($this->request->is('put') || $this->request->is('post')) {
        $d = $this->request->data;
        $ext = pathinfo($d['User']['picture']['name']);
        $extension = $ext['extension'];
        $d['User']['picture']['name'] = $user_id . '.' . $extension;

        // upload the file to the server
        $fileOK = $this->uploadFiles('img/user', $d['User']);
        if (array_key_exists('urls', $fileOK)) {
            // save the url in the form data
            $size = $d['User']['picture']['size'];
            $d['User']['picture'] = $fileOK['urls'][0];
        }
        if ($size < 2000000) {
            if ($this->User->save($d, true, array('picture'))) {
                $this->Session->setFlash("Votre profil a bien été modifié", "notif");
                $this->redirect(array('controller' => 'users', 'action' => 'profil'));
            } else {
                $this->Session->setFlash("Impossible de sauvegarder l'image, Merci de corriger", "notif", array
                    ('type' => 'error'));
            }
        } else {
            $this->Session->setFlash("Impossible de sauvegarder l'image, la taille de l'image est trop grande", "notif", array('type' => 'error'));
        }
        
        }
    }

    public function edit() {
        $this->loadModel('Suptype');
        $supt = $this->Suptype->find('list', array('fields' => array('stype')));
        $this->set(array('stype' => $supt));
        
        $user_id = $this->Auth->user('id');
        if (!$user_id) {
            $this->redirect('/');
            die();
        }
        $this->User->id = $user_id;
        if ($this->request->is('put') || $this->request->is('post')) {
            $d = $this->request->data;
            $d['User']['id'] = $user_id;
            if (!empty($d['User']['password1'])) {
                $d['User']['password'] = Security::hash($d['User']['password1'], null, true);

                if (!empty($d['User']['password_confirm'])) {
                    $d['User']['password_confirm'] = Security::hash($d['User']['password_confirm'], null, true);
                }
            }
            if(!empty($d['User']['website']) && strpos(strtolower($d['User']['website']),'http://') === false) {
                $d['User']['website'] = 'http://'.strtolower($d['User']['website']);
            }
            if (isset($d['User']['formUser']) && $d['User']['formUser'] == TRUE) {
                if ($this->User->save($d, true, array('firstname', 'lastname', 'mail', 'tel', 'city', 'zip', 'country',
                            'address', 'sex', 'ssiret','scorpname','sdesc','suptype_id','website'))) {
                    $this->Session->setFlash("Votre profil a bien été modifié", "notif");
                    $this->redirect(array('controller' => 'users', 'action' => 'profil'));
                } else {
                    $this->Session->setFlash("Impossible de sauvegarder, Merci de corriger", "notif", array('type' =>
                        'error'));
                }
            } else 
                
                
                {
                $ext = pathinfo($d['User']['picture']['name']);
                $extension = $ext['extension'];
                $d['User']['picture']['name'] = $user_id . '.' . $extension;

                // upload the file to the server
                $fileOK = $this->uploadFiles('img/user', $d['User']);
                if (array_key_exists('urls', $fileOK)) {
                    // save the url in the form data
                    $size = $d['User']['picture']['size'];
                    $d['User']['picture'] = $fileOK['urls'][0];
                }
                if ($size < 2000000) {
                    if ($this->User->save($d, true, array('picture'))) {
                        $this->Session->setFlash("Votre profil a bien été modifié", "notif");
                        $this->redirect(array('controller' => 'users', 'action' => 'profil'));
                    } else {
                        $this->Session->setFlash("Impossible de sauvegarder l'image, Merci de corriger", "notif", array
                            ('type' => 'error'));
                    }
                } else {
                    $this->Session->setFlash("Impossible de sauvegarder l'image, la taille de l'image est trop grande", "notif", array('type' => 'error'));
                }
            }
            
            
        } else {
            $this->request->data = $this->User->read();
        }
        $this->request->data['User']['password1'] = $this->request->data['User']['password_confirm'] = '';
    }

    public function editpassword() {
        $user_id = $this->Auth->user('id');
        if (!$user_id) {
            $this->redirect('/');
            die();
        }
        $id = AuthComponent::user('id');
        $currentUser = current($this->User->findById($id));
        if ($this->request->is('post')) {
            $d = $this->request->data;
            if (Security::hash($d['User']['password1'], null, true) == $currentUser['password']) {
                $d['User']['id'] = $currentUser['id'];
                $d['User']['password'] = Security::hash($d['User']['password'], null, true);
                $d['User']['password_confirm'] = Security::hash($d['User']['password_confirm'], null, true);
                if ($this->User->save($d, true, array('password'))) {
                    $this->Session->setFlash("Votre profil a bien été modifié", "notif");
                    $this->redirect(array('controller' => 'users', 'action' => 'profil'));
                } else {
                    $this->Session->setFlash("Impossible de sauvegarder, Merci de corriger", "notif", array('type' =>
                        'error'));
                }
            } else {
                $this->Session->setFlash("Mot de passe in correcte", "notif", array('type' => 'error'));
            }
        }
    }
    
    public function suppliers() {
        $user_id = $this->Auth->user('id');
        if (!$user_id) {
            $this->redirect('/');
            die();
        }
        $this->loadModel('Suptype');
        $this->loadModel('Departement');
        $supt = $this->Suptype->find('list', array('fields' => array('stype')));
        $depts = $this->Departement->find('list', array('fields' => array('dept')));
        $this->set(array('stype' => $supt,'depts'=>$depts));
        
        //On verifie si une recherche a été effectuée
		if(isset($this->request->data['User']['suptype_id']) && isset($this->request->data['User']['suptype_id'])){
			if(!empty($this->request->data['User']['suptype_id'])){ // le type est renseigné
				if(!empty($this->request->data['User']['dept'])){ // si les deux critères sont renseignés
					$stmtopts = array(
						'suptype_id = ' => $this->request->data['User']['suptype_id'],
						'zip like ' => $this->request->data['User']['dept'].'%',
                                                'suptype_id <> ' => 0
					);
				}else{ // Type renseigné mais pas le Dept
					$stmtopts = array(
						'suptype_id = ' => $this->request->data['User']['suptype_id'],
                                                'suptype_id <> ' => 0
					);
				}
			}else{ 
				if(!empty($this->request->data['User']['dept'])){ // type non renseigné + dept renseigné
					$stmtopts = array(
						'zip like ' => $this->request->data['User']['dept'].'%',
                                                'suptype_id <> ' => 0
					);
				}else{ // rien renseigné....
					$stmtopts = array();
				}
			}
			$this->recherche($stmtopts,$this->request->data['User']['dept']);
		}else{
			//requete par défaut
			$this->recherche(array(),null);
		}
        
    }
	
    private function recherche($stmtopts,$id_dept) {
        $this->loadModel('Departement');
        // On cherche les éléments
        $search_dept = "";
        if (empty($stmtopts)) { //pas d'options pour la requete, on renvoie tt
            $data = $this->User->find('all', array('conditions' =>
					array('suptype_id <> ' => 0)
			));
        } else { // des options ont étés définies
            $data = $data = $this->User->find('all', array('conditions' =>
					$stmtopts
			));
            // récupération du département
			if(!empty($id_dept)){
				$search_d = $this->Departement->find('first',array(
					'conditions'=>array(
						'Departement.id' => $this->request->data['User']['dept']
					)
				));
				$search_dept = $search_d['Departement']['dept'];
			}else{
				$search_dept = "";
			}
        }

        $i = 0;
        foreach ($data as $key => $event) {
            $results[] = $data[$i];
            $i++;
        }
        if (isset($results)) {
            $this->set(array('suppliers'=>$results,'search_dept'=> $search_dept));
        } else {
            $this->set('noresults', 'Aucun prestataire trouvé');
        }
    }
    
    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $user_id = $this->Auth->user('id');
        if (!$user_id) {
            $this->redirect('/');
            die();
        }
        $supplier = $this->User->findById($id);
        $this->User->id = $id;
        $this->set('supplier',$supplier);
    }
    
    /**
     * Generate and render captcha image
     *
     * @access public
     * @return void
     */
    public function captcha()  {
        $this->autoRender = false;
        $this->Captcha->generate();
    }
}
