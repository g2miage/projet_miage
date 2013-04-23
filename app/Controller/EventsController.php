<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EventsController extends AppController {

    // Helper GoogleMap
    public $helpers = array('GoogleMap', 'Tinymce', 'Rating');

    public function index() {
        //On verifie si une recherche a été effectuée,
        if (isset($this->request->data['Event']['searchEventTitle']) == TRUE
        ) {

            if ($this->request->data['Event']['searchEventTitle'] != "") {
                $this->recherche("Title");
            } else {
                $this->recherche("all");
            }
        } else {
            $this->recherche("all");
        }
        $this->set('current_user', $this->Auth->user('id'));
    }

    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $current_user = $this->Auth->user('id');
        $data = $this->Event->EventsUsers->find('first', array(
            'conditions' => array('EventsUsers.type_id' => 1, 'Event.id' => $id)
        ));
        $event = $data['Event'];

        $createur = $data['User'];

        $type = $this->Event->Eventtype->findById($data['Event']['eventtype_id']);


        $this->Event->EventsUsers->contain('User');
        $invites = $this->Event->EventsUsers->find('all', array(
            'conditions' => array('EventsUsers.type_id' => 3, 'EventsUsers.event_id' => $id),
            'fields' => array('User.username')
        ));
        $participants = $this->Event->EventsUsers->find('all', array(
            'conditions' => array('EventsUsers.type_id' => 5, 'EventsUsers.event_id' => $id),
            'fields' => array('User.id', 'User.username')
        ));

        $organisateurs = $this->Event->EventsUsers->find('all', array(
            'conditions' => array('EventsUsers.type_id' => 2, 'EventsUsers.event_id' => $id),
            'fields' => array('User.id', 'User.username')
        ));
        
        $prestataires = $this->Event->EventsUsers->find('all', array(
            'conditions' => array('EventsUsers.type_id' => 4, 'EventsUsers.event_id' => $id),
            'fields' => array('User.id', 'User.username')
        ));

        if (!$event) {
            throw new NotFoundException(__('Invalid post'));
        }

        $v = array(
            'event' => $event,
            'createur' => $createur,
            'invites' => $invites,
            'organisateurs' => $organisateurs,
            'participants' => $participants,
            'current_user' => $current_user,
            'typename' => $type['Eventtype']['name'],
            'prestataires' => $prestataires
        );

        $this->set($v);
    }

    public function add() {

        if ($this->request->is('post')) {
            $this->Event->create();

            if (!empty($this->request->data['Event']['picture']['name'])) {
                // upload the file to the server
                $fileOK = $this->uploadFiles('img/event', $this->request->data['Event']);
                if (array_key_exists('urls', $fileOK)) {
                    // save the url in the form data
                    $size = $this->request->data['Event']['picture']['size'];
                    $this->request->data['Event']['picture'] = $fileOK['urls'][0];
                }
            } else {
                $this->request->data['Event']['picture'] = '';
            }

            if ($this->Event->saveAll($this->request->data)) {
                // enregistrement du user créateur
                $eventId = $this->Event->id;
                $this->requestAction('/EventsUsers/add/' . $eventId);
                $this->Session->setFlash('Votre événement a bien été créé.', 'notif');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Votre événement n\'a pas été créé.', 'notif', array('type' => 'error'));
                $this->set('eventtypes', $this->Event->Eventtype->find('list', array('fields')));
            }
        } else {
            $this->set('eventtypes', $this->Event->Eventtype->find('list', array('fields')));
        }
    }

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid event'));
        }
        $event = $this->Event->findById($id);
        if (!$event) {
            throw new NotFoundException(__('Invalid event'));
        }
        $img_path = $event['Event']['picture'];
        foreach ($event['User'] as $key => $user) {

            if ($user['id'] == $this->Auth->user('id')) {
                $this->Auth->deny();
            }
        }


        if ($this->request->is('event') || $this->request->is('put')) {
            $this->Event->id = $id;
            if (!empty($this->request->data['Event']['picture']['name'])) {

                $ext = pathinfo($this->request->data['Event']['picture']['name']);
                $extension = $ext['extension'];
                $this->request->data['Event']['picture']['name'] = $id . '_' . $this->request->data['Event']['title'] . '.' . $extension;
                $file = new File('img/' . $img_path, FALSE);
                $file->delete();
                $fileOK = $this->uploadFiles('img/event', $this->request->data['Event']);

                if (array_key_exists('urls', $fileOK)) {
                    // save the url in the form data
                    $size = $this->request->data['Event']['picture']['size'];
                    $this->request->data['Event']['picture'] = substr($fileOK['urls'][0], 4);
                }
            } else {
                $this->request->data['Event']['picture'] = $img_path;
            }

            if ($this->Event->save($this->request->data)) {
                $this->Session->setFlash('Votre événement a bien été mis à jour.', 'notif');
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash('Votre événement n\'a pas été mis à jour.');
            }
        }




        if (!$this->request->data) {
            $this->request->data = $event;
        }
    }

    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Event->delete($id)) {
            $this->Session->setFlash('L\'événement avec l\'id ' . $id . ' a été supprimé.');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function search() {
        $this->set('results', $this->Event->find('all', array(
                    'conditions' => array('Event.title LIKE' => '%' . $this->request->data['Event']['searchEvent'] . '%'))));
    }

    private function recherche($type) {

        // On cherche les éléments
        if ($type == "all") {
            $data = $this->Event->find('all');
        } else {
            $data = $data = $this->Event->find('all', array('conditions' =>
                array('Event.title LIKE' => '%' . $this->request->data['Event']['searchEventTitle'] . '%')));
        }

        $i = 0;
        foreach ($data as $key => $event) {
            if ($event['Event']['visibility'] == 0) {
                $results[] = $data[$i];
            } else {
                foreach ($event['User'] as $key => $user) {
                    if ($user['EventsUser']['user_id'] == $this->Auth->user('id')) {
                        $results[] = $data[$i];
                    }
                }
            }
            $i++;
        }
        if (isset($results)) {
            $this->set('events', $results);
        } else {
            $this->set('noresults', 'Acun evenement');
        }
    }

    public function beforeFilter() {
        // $this->Auth->deny();
    }

    public function participate($event_id) {
        $this->loadModel('EventsUsers');
        $eventUser = $this->EventsUsers->find('all', array('conditions' => array('event_id' => $event_id, 'user_id' => $this->Auth->user('id'))));
        if (empty($eventUser)) {
            $eventUser = array('event_id' => $event_id, 'user_id' => $this->Auth->user('id'), 'type_id' => "5");
            $this->EventsUsers->save($eventUser);
        } else {
            $this->Event->EventsUser->updateAll(
                    array('EventsUser.type_id' => 5), array(
                'EventsUser.event_id' => $event_id,
                'EventsUser.user_id' => $this->Auth->user('id')
            ));
        }
        $this->Session->setFlash('Votre inscription a été prise en compte', 'notif');
        $this->redirect(array('action' => 'view', $event_id));
    }

    public function refuse($event_id) {
        $this->Event->EventsUser->updateAll(
                array('EventsUser.type_id' => 3), array(
            'EventsUser.event_id' => $event_id,
            'EventsUser.user_id' => $this->Auth->user('id')
        ));
        $this->Session->setFlash('Votre désinscription a été prise en compte', 'notif');
        $this->redirect(array('action' => 'view', $event_id));
    }

    public function addfile($eventId) {
        $this->loadModel('User');
        $this->uploadCsv('csv', $this->request->data, '', 'projet_'.$eventId);
        $fichier = 'csv/projet_'.$eventId.'.csv';

        $handle = @fopen('csv/projet_'.$eventId.'.csv', "r");

        if ($handle) {
            while (($buffer = fgets($handle, 4096)) != false) {


                $results = explode(";", $buffer);
                // création du password et hashage
                $password = ($this->User->generatePassword());
                $passwordUnhash = $password;
                $password = Security::hash($password, null, true);
                array_unshift($results, $password);
                $schema = array('password_confirm' => $results[0],
                    'username' => '',
                    'password' => $results[0],
                    'firstname' => $results[1],
                    'lastname' => $results[2],
                    'tel' => $results[3],
                    'mail' => $results[4],
                    'address' => $results[5],
                    'zip' => $results[6],
                    'city' => $results[7],
                    'country' => $results[8],
                    'sex' => $results[9],
                    'active' => '1'
                );

                if ($schema['sex'] == 'M') {
                    $schema['sex'] = '1';
                } else {
                    $schema['sex'] = '0';
                }


                if (!$this->User->findByMail($schema['mail'])) {
                    // Si l'email existe pas alors on creer le user
                    $schema['username'] = $schema['firstname'] . '' . $schema['lastname'];

                    $i = 0;
                    while ($this->User->hasAny(array('username' => $schema['username'])) == true) {
                        $schema['username'] = $schema['firstname'] . '' . $schema['lastname'] . '' . $i;
                        $i++;
                    }

                    $this->User->create();
                    if ($this->User->save($schema, true, array('username',
                                'password',
                                'firstname',
                                'lastname',
                                'tel',
                                'mail',
                                'address',
                                'zip',
                                'city',
                                'country',
                                'sex',
                                'active'))) {
                        // Création liaison avec nouveau User
                        $userId = $this->User->id;
                        $schemaEventUser = array('event_id' => $eventId,
                            'user_id' => $userId,
                            'type_id' => '3');
                        $this->loadModel('EventsUser');
                        if ($this->EventsUser->hasAny(array('event_id' => $schemaEventUser['event_id'],
                                    'user_id' => $schemaEventUser['user_id'])) == false) {
                            $this->EventsUser->create();
                            $this->EventsUser->save($schemaEventUser, true, array('event_id', 'user_id', 'type_id'));

                            // Recherche des infos pour le mail    
                            $Event = $this->Event->findById($eventId);
                            $userName = $schema['firstname'] . '' . $schema['lastname'];
                            $EventsUserCreator = $this->EventsUser->find('all', array(
                                'conditions' => array('event_id =' => $eventId,
                                    'type_id  =' => "1")));

                            $UserCreatorId = $EventsUserCreator[0]['EventsUser']['user_id'];

                            $userCreator = $this->User->findById($UserCreatorId);
                            if (empty($userCreator)) {
                                $userCreatorName = "Créateur inconnu";
                            } else {
                                $userCreatorName = $userCreator['User']['firstname'] . ' ' . $userCreator['User']['lastname'];
                            }

                            // Envoi du mail
                            App::uses('CakeEmail', 'Network/Email');
                            $mail = new CakeEmail();
                            $mail->from('no-reply@events.com');
                            $mail->to($schema['mail']);
                            $mail->subject('Activation compte Events');
                            $mail->emailFormat('html');
                            $mail->template('invitation_newuser');
                            $mail->viewVars(array('userName' => $userName, 'eventTitle' => $Event['Event']['title'],
                                'eventCreator' => $userCreatorName, 'username' => $schema['username'],
                                'password' => $passwordUnhash));
                            $mail->send();
                        }
                    }
                } else {
                    // Création liaison avec user existant
                    $user = $this->User->findByMail($schema['mail']);
                    $schemaEventUser = array('event_id' => $eventId,
                        'user_id' => $user['User']['id'],
                        'type_id' => '3');
                    $this->loadModel('EventsUser');
                    if ($this->EventsUser->hasAny(array('event_id' => $schemaEventUser['event_id'],
                                'user_id' => $schemaEventUser['user_id'])) == false) {
                        $this->EventsUser->create();
                        $this->EventsUser->save($schemaEventUser, true, array('event_id', 'user_id', 'type_id'));


                        // Recherche des infos pour le mail    
                        $Event = $this->Event->findById($eventId);
                        $userName = $schema['firstname'] . '' . $schema['lastname'];
                        $EventsUserCreator = $this->EventsUser->find('all', array(
                            'conditions' => array('event_id =' => $eventId,
                                'type_id  =' => "1")));

                        $UserCreatorId = $EventsUserCreator[0]['EventsUser']['user_id'];
                        $userCreator = $this->User->findById($UserCreatorId);
                        $userCreatorName = $userCreator['User']['firstname'] . '' . $userCreator['User']['lastname'];

                        // Envoi du mail
                        App::uses('CakeEmail', 'Network/Email');
                        $mail = new CakeEmail();
                        $mail->from('no-reply@events.com');
                        $mail->to($schema['mail']);
                        $mail->subject('Activation compte Events');
                        $mail->emailFormat('html');
                        $mail->template('invitation_olduser');
                        $mail->viewVars(array('userName' => $userName, 'eventTitle' => $Event['Event']['title'],
                            'eventCreator' => $userCreatorName, 'username' => $schema['username']));
                        $mail->send();
                    }
                }
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
            unlink('csv/projet_'.$eventId.'.csv');
        }
        $this->redirect(array('action' => 'view', $eventId));
    }

    // add organisateur
    public function addorganisateur($eventId) {

        if (!empty($this->data)) {
            $chaine = $this->data['Event']['chaine'];
        } else {
            $chaine = "";
        }

        $d = $this->searchuser($chaine, $eventId);

        $this->set(array('resultat' => $d, 'e_id' => $eventId));
    }

    public function searchuser($chaine, $eventId) {
        $this->loadModel('User');
        $this->loadModel('EventsUsers');
        $currentUser = $this->Auth->user('id');
        $creatorId = $this->EventsUsers->find('first', array(
            'conditions' => array('EventsUsers.type_id' => 1, 'EventsUsers.event_id' => $eventId)));
        $creatorId = $creatorId['EventsUsers']['id'];
     

        $d = $this->User->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'User.username LIKE' => "%" . $chaine . "%",
                    'User.lastname LIKE' => "%" . $chaine . "%",
                    'User.firstname LIKE' => "%" . $chaine . "%"
                ),
            ),
            'recursive' => -1));

        foreach ($d as $key => $user) {
           
            if ($user['User']['id'] == $currentUser || $user['User']['id'] == $creatorId) {
                unset($d[$key]);
            }
             
        }
        

        return $d;
    }

    public function organisateur($u_id, $e_id) {
        try {
            $this->loadModel('EventsUsers');
            $eventUser = $this->EventsUsers->find('all', array('conditions' => array('event_id' => $e_id, 'user_id' => $u_id)));
            if (empty($eventUser)) {
                $eventUser = array('event_id' => $e_id, 'user_id' => $u_id, 'type_id' => "2");
                $this->EventsUsers->save($eventUser);
            } else {

                if ($this->Event->EventsUser->updateAll(
                                array('EventsUser.type_id' => 2), array(
                            'EventsUser.event_id' => $e_id,
                            'EventsUser.user_id' => $u_id)
                        )) {
                    $this->mailinvitation($e_id, $u_id, 'Organisateur');
                    $this->Session->setFlash('Vous avez ajouté un organisateur', 'notif');
                } else {
                    $this->Session->setFlash('Impossible ', 'notif', array('type' => 'error'));
                }
            }
        } catch (Exception $exc) {
            $this->Session->setFlash('Cet utilisateur est déjà organisateur ', 'notif', array('type' => 'error'));
        }
        $this->redirect(array('action' => 'view', $e_id));
    }

    public function inviter($u_id, $e_id) {
        try {
            $this->loadModel('EventsUsers');
            $eventUser = $this->EventsUsers->find('all', array('conditions' => array('event_id' => $e_id, 'user_id' => $u_id)));
            if (empty($eventUser)) {
                $eventUser = array('event_id' => $e_id, 'user_id' => $u_id, 'type_id' => "3");
                $this->EventsUsers->save($eventUser);
            } else {
                if ($this->Event->EventsUser->updateAll(
                                array('EventsUser.type_id' => 3), array(
                            'EventsUser.event_id' => $e_id,
                            'EventsUser.user_id' => $u_id)
                        )) {
                    $this->mailinvitation($e_id, $u_id, 'Invité');
                    $this->Session->setFlash('Vous avez ajouté un nouvel invité', 'notif');
                } else {
                    $this->Session->setFlash('Impossible ', 'notif', array('type' => 'error'));
                }
            }
        } catch (Exception $exc) {
            $this->Session->setFlash('Cet utilisateur est déjà invité ou organisateur', 'notif', array('type' => 'error'));
        }
        $this->redirect(array('action' => 'view', $e_id));
    }
    
    function participant($u_id, $e_id){
                try {
            $this->loadModel('EventsUsers');
            $eventUser = $this->EventsUsers->find('all', array('conditions' => array('event_id' => $e_id, 'user_id' => $u_id)));
            if (empty($eventUser)) {
                $eventUser = array('event_id' => $e_id, 'user_id' => $u_id, 'type_id' => "5");
                $this->EventsUsers->save($eventUser);
            } else {
                if ($this->Event->EventsUser->updateAll(
                                array('EventsUser.type_id' => 5), array(
                            'EventsUser.event_id' => $e_id,
                            'EventsUser.user_id' => $u_id)
                        )) {
                    $this->mailinvitation($e_id, $u_id, 'Invité');
                    $this->Session->setFlash('Vous avez ajouté un nouveau participant', 'notif');
                } else {
                    $this->Session->setFlash('Impossible ', 'notif', array('type' => 'error'));
                }
            }
        } catch (Exception $exc) {
            $this->Session->setFlash('Cet utilisateur est déjà invité ou organisateur', 'notif', array('type' => 'error'));
        }
        $this->redirect(array('action' => 'view', $e_id));

    }
    

    function mailinvitation($e_id, $u_id, $role) {
        $this->loadModel('User');
        $invite = current($this->User->findById($u_id));
        $user = current($this->User->findById($this->Auth->user('id')));
        $event = current($this->Event->findById($e_id));

        App::uses('CakeEmail', 'Network/Email');
        $mail = new CakeEmail();
        /*  $mail->from('no-reply@events.com')
          ->to($invite['mail'])
          ->subject('Invitation Events')
          ->emailFormat('html')
          ->template('mailinvitation')
          ->viewVars(array('name' => $invite['firstname'], 'user' => $user['lastname'], 'event' => $event['title'], 'role' => $role))
          ->send(); */
    }

    function deleteimg($id) {
        $event = current($this->Event->findById($id));
        $file = new File('img/' . $event['picture'], FALSE);
        $file->delete();
        $this->Event->id = $id;
        if ($this->Event->saveField('picture', '')) {

            $this->Session->setFlash('L\'image a été supprimé ', 'notif');
        }

        $this->redirect(array('action' => 'edit', $id));
    }

    function deleteEventUser($userId, $eventId) {
        $this->loadModel('EventsUsers');
        $eventUser = array('event_id' => $eventId, 'user_id' => $userId);
        $this->EventsUsers->deleteAll($eventUser);
        $this->redirect(array('action' => 'view', $eventId));
    }

}
