<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EventsController extends AppController {

    // Helper GoogleMap
    public $helpers = array('GoogleMap','Tinymce');

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
            // $this->set('events',$this->Event->find('all'));
        }
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

        $this->Event->EventsUsers->contain('User');
        $invites = $this->Event->EventsUsers->find('all', array(
            'conditions' => array('EventsUsers.type_id' => 3, 'EventsUsers.event_id' => $id),
            'fields' => array('User.username')
        ));

        $organisateurs = $this->Event->EventsUsers->find('all', array(
            'conditions' => array('EventsUsers.type_id' => 2, 'EventsUsers.event_id' => $id),
            'fields' => array('User.username')
        ));

        if (!$event) {
            throw new NotFoundException(__('Invalid post'));
        }

        $v = array(
            'event' => $event,
            'createur' => $createur,
            'invites' => $invites,
            'organisateurs' => $organisateurs,
            'current_user' => $current_user
        );

        $this->set($v);
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Event->create();
            
            // upload the file to the server
            $fileOK = $this->uploadFiles('img/event',$this->request->data['Event']);
            if (array_key_exists('urls', $fileOK)) {
                // save the url in the form data
                $size = $this->request->data['Event']['picture']['size'];
                $this->request->data['Event']['picture'] = $fileOK['urls'][0];
            }
            
            if ($this->Event->save($this->request->data)) {
                // enregistrement du user créateur
                $eventId = $this->Event->id;
                $this->requestAction('/EventsUsers/add/' . $eventId);
                $this->Session->setFlash('Votre événement a bien été créé.', 'notif');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Votre événement n\'a pas été créé.', 'notif');
            }
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


        foreach ($event['User'] as $key => $user) {

            if ($user['id'] == $this->Auth->user('id')) {
                $this->Auth->deny();
            }
        }

        if ($this->request->is('event') || $this->request->is('put')) {
            $this->Event->id = $id;
            
            if(!empty($this->request->data['Event']['picture'])){
                $fileOK = $this->uploadFiles('img/event',$this->request->data['Event']);
                if (array_key_exists('urls', $fileOK)) {
                    // save the url in the form data
                    $size = $this->request->data['Event']['picture']['size'];
                    $this->request->data['Event']['picture'] = $fileOK['urls'][0];
                }
            }
            
            if ($this->Event->save($this->request->data)) {
                $this->Session->setFlash('Votre événement a bien été mis à jour.');
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

        $this->Event->EventsUser->updateAll(
                array('EventsUser.type_id' => 5), array(
            'EventsUser.event_id' => $event_id,
            'EventsUser.user_id' => $this->Auth->user('id')
        ));

        $this->redirect(array('action' => 'view', $event_id));
    }

    public function refuse($event_id) {
        $data = $this->Event->read(null, $event_id);
        $data['User'][0]['EventsUser']['type_id'] = "3";
        $this->Event->save($data, true, array('User' => 'EventsUser', 'type_id'));
        $this->redirect(array('action' => 'view', $event_id));
    }
    
      public function addfile() {
        $this->loadModel('User');
        $eventId = "5";
        $this->uploadCsv('csv', $this->request->data, '', 'projet');
        $fichier = 'csv/projet.csv';

        $handle = @fopen("csv/projet.csv", "r");
        
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
                        $userName = $schema['firstname'].''.$schema['lastname'];
                        $EventsUserCreator = $this->EventsUser->find('all',   array(
                                           'conditions' => array('event_id =' => $eventId, 
                                                                 'type_id  =' => "1")));
                        
                        $UserCreatorId = $EventsUserCreator[0]['EventsUser']['user_id'];
                        $userCreator = $this->User->findById($UserCreatorId);
                        $userCreatorName = $userCreator['User']['firstname'].' '.$userCreator['User']['lastname'];
                                
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
                }
                else {
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
                        $userName = $schema['firstname'].''.$schema['lastname'];
                        $EventsUserCreator = $this->EventsUser->find('all',   array(
                                           'conditions' => array('event_id =' => $eventId, 
                                                                 'type_id  =' => "1")));
                        
                        $UserCreatorId = $EventsUserCreator[0]['EventsUser']['user_id'];
                        $userCreator = $this->User->findById($UserCreatorId);
                        $userCreatorName = $userCreator['User']['firstname'].''.$userCreator['User']['lastname'];
                        
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
        }
    }
    
    
}
