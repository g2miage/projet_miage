<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 * @author G2Miage
 */
class UsersController extends AppController {

    // Helper GoogleMap
    public $helpers = array('GoogleMap');
    public $name = 'Users';
    public $components = array(
        'Captcha' => array(
            'rotate' => true
        ),
        'RequestHandler'
    );

    public function signup() {
        $this->set('title_for_layout', 'Inscription');
        $this->loadModel('Suptype');
        $supt = $this->Suptype->find('list', array('fields' => array('stype')));
        $this->set(array('stype' => $supt));
        if ($this->request->is('post')) {
            $this->User->setCaptcha($this->Captcha->getCode());
            $this->User->set('captcha', $this->User->captcha);
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
            if ($this->User->save($d, true, array('username', 'password', 'mail', 'creationdate', 'scorpname', 'ssiret', 'suptype_id', 'sdesc', 'address', 'zip', 'city', 'country', 'role_id', 'captcha'))) {
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
        $this->set('title_for_layout', 'Connexion');
        if ($this->Auth->login()) {
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('lastlogin', date('Y-m-d H:i:s'));
            $this->Session->setFlash("Vous êtes connecté", "notif");
            $this->redirect('/');
        } else {
            // on n'affiche pas ce message si l'utilisateur viens de la page d'inscription
            if ($this->referer() != $this->referer(array('action' => 'signup'))) {
                //$this->Session->setFlash("Indentifiants incorrects", "notif", array('type' => 'error'));
                throw new ForbiddenException();
            }
        }
    }

    public function activate($token) {
        $token = explode('-', $token);
        //$this->User->contain('User');
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $token[0], 'active' => 0),
            'recursive' => -1
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
        $this->set('title_for_layout', 'Mon Profil');
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
        $this->set('title_for_layout', 'Modification du Profil');
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
            if (!empty($d['User']['website']) && strpos(strtolower($d['User']['website']), 'http://') === false) {
                $d['User']['website'] = 'http://' . strtolower($d['User']['website']);
            }
            if (isset($d['User']['formUser']) && $d['User']['formUser'] == TRUE) {
                if ($d['User']['role_id'] == 0 && isset($d['User']['address1'])) {
                    $d['User']['address'] = $d['User']['address1'];
                    $d['User']['zip'] = $d['User']['zip1'];
                    $d['User']['city'] = $d['User']['city1'];
                    $d['User']['country'] = $d['User']['country1'];
                }
                if ($this->User->save($d, true, array('firstname', 'lastname', 'mail', 'tel', 'city', 'zip', 'country',
                            'address', 'sex', 'ssiret', 'scorpname', 'sdesc', 'suptype_id', 'website'))) {
                    $this->Session->setFlash("Votre profil a bien été modifié", "notif");
                    $this->redirect(array('controller' => 'users', 'action' => 'profil'));
                } else {
                    $this->Session->setFlash("Impossible de sauvegarder, Merci de corriger", "notif", array('type' =>
                        'error'));
                }
            } else {
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
        $this->set('title_for_layout', 'Modification du Mot de Passe');
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

    public function suppliers($eventId = null) {
        $this->set('title_for_layout', 'Prestataires');
        $user_id = $this->Auth->user('id');
        if (!$user_id) {
            $this->redirect('/');
            die();
        }
        if (isset($eventId)) {
            $this->set(array('eventId' => $eventId));
        }
        //$this->loadModel('EventsUser');
        $this->loadModel('Suptype');
        $this->loadModel('Departement');
        $this->User->EventsUsers->contain('Event');

        $listEvents = $this->User->EventsUsers->find('all', array('conditions' => array('user_id' => $user_id, 'type_id in (1,2)', 'str_to_date(endday, \'%d/%m/%Y\') > date_format(now(),\'%Y-%m-%d\')')));
        $supplierEvents = $this->User->EventsUsers->find('all', array('conditions' => array('type_id' => '4'), 'contain' => false));
        $supt = $this->Suptype->find('list', array('fields' => array('stype')));
        $depts = $this->Departement->find('list', array('fields' => array('dept')));
        $this->set(array('stype' => $supt, 'depts' => $depts, 'listevent' => $listEvents, 'supplierevent' => $supplierEvents));

        //On verifie si une recherche a été effectuée
        if (isset($this->request->data['User']['suptype_id']) && isset($this->request->data['User']['suptype_id'])) {
            if (!empty($this->request->data['User']['suptype_id'])) { // le type est renseigné
                if (!empty($this->request->data['User']['dept'])) { // si les deux critères sont renseignés
                    $stmtopts = array(
                        'suptype_id = ' => $this->request->data['User']['suptype_id'],
                        'zip like ' => $this->request->data['User']['dept'] . '%',
                        'suptype_id <> ' => 0
                    );
                } else { // Type renseigné mais pas le Dept
                    $stmtopts = array(
                        'suptype_id = ' => $this->request->data['User']['suptype_id'],
                        'suptype_id <> ' => 0
                    );
                }
            } else {
                if (!empty($this->request->data['User']['dept'])) { // type non renseigné + dept renseigné
                    $stmtopts = array(
                        'zip like ' => $this->request->data['User']['dept'] . '%',
                        'suptype_id <> ' => 0
                    );
                } else { // rien renseigné....
                    $stmtopts = array();
                }
            }
            $this->recherche($stmtopts, $this->request->data['User']['dept']);
        } else {
            //requete par défaut
            $this->recherche(array(), null);
        }
    }

    private function recherche($stmtopts, $id_dept) {
        $this->loadModel('Departement');
        // On cherche les éléments
        $search_dept = "";
        if (empty($stmtopts)) { //pas d'options pour la requete, on renvoie tt
            $data = $this->getAllAverageNote(
                array('suptype_id <> ' => 0)
            );
        } else { // des options ont étés définies
            $data = $data = $this->getAllAverageNote($stmtopts);
            // récupération du département
            if (!empty($id_dept)) {
                $search_d = $this->Departement->find('first', array(
                    'conditions' => array(
                        'Departement.id' => $this->request->data['User']['dept']
                    )
                ));
                $search_dept = $search_d['Departement']['dept'];
            } else {
                $search_dept = "";
            }
        }

        $i = 0;
        foreach ($data as $key => $event) {
            $results[] = $data[$i];
            $i++;
        }
        if (isset($results)) {
            $this->set(array('suppliers' => $results, 'search_dept' => $search_dept));
        } else {
            $this->set('noresults', 'Aucun prestataire trouvé');
        }
    }

    public function view($id) {

        if (!$id) {
            throw new NotFoundException();
        }
        $user_id = $this->Auth->user('id');
        if (!$user_id) {
            throw new ForbiddenException();
        }
        // Récupération des infos du presta
        $supplier = $this->User->findById($id);
        //si on ne trouve pas d'infos
        if (!$supplier) {
            throw new NotFoundException();
        }

        // Cherche si l'utilisateur courant et le prestataire ont un événement en commun
        // Si oui, on pourra le noter
        $this->loadModel('Supplierrating');
        $this->loadModel('EventsUser');
        $eventsSuppliers = $this->EventsUser->find('all', array('conditions' =>
            array('user_id' => $id)));
        $eventsOrgas = $this->EventsUser->find('all', array('conditions' =>
            array('user_id' => $user_id, 'type_id IN (1,2)')));
        $ontTravailleEnsemble = false;
        foreach ($eventsSuppliers as $eventsSupplier) {
            foreach ($eventsOrgas as $eventsOrga) {
                if ($eventsSupplier['EventsUser']['event_id'] == $eventsOrga['EventsUser']['event_id']) {
                    $ontTravailleEnsemble = true;
                    break;
                }
            }
            if ($ontTravailleEnsemble) {
                break;
            }
        }
        $note = $this->Supplierrating->find('first', array('conditions' => array('id_user' => $user_id, 'id_supplier' => $id), 'fields' => array('note')));
        $this->User->id = $id;
        $this->set('canRate', $ontTravailleEnsemble);
        if (!empty($note)) {
            $this->set('note', $note['Supplierrating']['note']);
        }
        $this->set('supplier', $supplier);
        $this->set('noteMoyenne', round($this->getAverageNote($id), 1));
        $this->set('title_for_layout', 'Prestataire ' . $supplier['User']['scorpname']);
    }

    /**
     * Generate and render captcha image
     *
     * @access public
     * @return void
     */
    public function captcha() {
        $this->autoRender = false;
        $this->Captcha->generate();
    }

    public function messages() {
        $this->loadModel('MessagesUsers');
        $this->set('title_for_layout', 'Mes Messages');
        // récup des messages de l'user
        $messages = $this->MessagesUsers->find(
                'all', array(
            'fields' => 'status,event_id,Event.title',
            'conditions' => array('user_id' => $this->Auth->user('id'))
                )
        );
        $this->set(array('messages' => $messages));
    }

    public function readMsg($idevent, $titleevent) {
        $this->loadModel('MessagesUsers');
        $user_id = $this->Auth->user('id');
        if (!$user_id) {
            throw new ForbiddenException();
        }
        if (!$idevent) {
            throw new NotFoundException();
        }
        $this->MessagesUsers->updateAll(array('status' => 1), array('event_id' => $idevent, 'user_id' => $user_id));
        $this->redirect(array(
            'controller' => 'Events',
            'action' => 'view',
            $idevent,
            Inflector::slug($titleevent, '-'))
        );
    }

    private function getAverageNote($id) {
        $this->loadModel('Supplierrating');
        $moyenne = $this->Supplierrating->find('first', array(
            'conditions' => array(
                'Supplierrating.id_supplier' => $id
            ),
            'recursive' => 1,
            'fields' => array(
                'AVG( Supplierrating.note ) AS average'
            )
                )
        );
        return $moyenne[0]['average'];
    }

    public function getAllAverageNote($conditions = array()) {
        $this->User->contain('Suptype');
        $moyenne = $this->User->find('all', array(
            'contain' => false,
            'recursive' => 1,
            'joins' => array(
                array(
                    'table' => 'supplierratings',
                    'alias' => 'Supplierrating',
                    'type' => 'LEFT',
                    'foreignKey' => 'id_supplier',
                    'conditions' => array(
                        'User.id = Supplierrating.id_supplier'
                    ))
            ),
            'conditions' => $conditions,
            'fields' => array(
                '*',
                'ROUND(AVG( Supplierrating.note ),1) AS average'
            ),
            'group' => 'User.id'
          )
        );
        
        /*$suppliers = $this->User->query('SELECT u.username, u.firstname,u.lastname,u.scorpname,u.tel,u.mobile,u.fax,u.mail,u.address,u.zip,u.city,u.country,u.picture,u.website,u.ssiret,u.sdesc,suptype_id,
                                                ROUND( AVG( Supplierratings.note ) , 2 ) AS average
                                        FROM Users u
                                        LEFT JOIN Supplierratings ON u.id = Supplierratings.id_supplier
                                        WHERE suptype_id <>0
                                        GROUP BY (u.id)');*/
        //debug($moyenne);die();
        return $moyenne;
    }

}
