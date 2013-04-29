<?php

class EventsUsersController extends AppController {

    function add($eventId) {

        $userId = $this->Auth->user('id');

        $EventsUser = array('EventsUser' => array('event_id' => $eventId,
                'user_id' => $userId, 'type_id' => "1"));

        $this->EventsUser->save($EventsUser, true, array('event_id', 'user_id', 'type_id'));
    }

    function prestataire($eventId) {
        $userId = $this->Auth->user('id');
        /* $this->loadModel('User');
          //$this->EventsUser->contain('User');
          $EventsUser = $this->EventsUser->find('all', array(
          'contain' => array('User'),
          'conditions' => array(
          'event_id' => $eventId, 'type_id' => "4")
          )); */
        $EventsUser = $this->EventsUser->find('all', array('conditions' => array('event_id' => $eventId, 'type_id' => "4")));


        $this->set('users', $EventsUser);
    }

    function addsupplier($eventId = null, $supplierId = null) {

        $user_id = $this->Auth->user('id');
        if (!$user_id) {
            $this->redirect('/');
            die();
        }
        if ($this->request->is('post') || isset($eventId)) {
            if(isset($eventId) && isset($supplierId)) {
                $eventBool = true;
            } else {
                $eventId = $this->request->data['User']['event_id'];
                $supplierId = $this->request->data['User']['user_id'];
                $eventBool = false;
            }
            $eventsUser = array('EventsUser' => array('event_id' => $eventId,
                'user_id' => $supplierId, 'type_id' => '4'));
            
            $eventSupplier = $this->EventsUser->find('all',array('conditions' => array('event_id' => $eventId, 'user_id' => $supplierId)));
            if(empty($eventSupplier)) {
                if ($this->EventsUser->save($eventsUser)) {
                    if ($this->request->data['User']['avertirMail'] && !empty($this->request->data['User']['message'])) {
                        $this->loadModel('User');
                        $this->loadModel('Event');
                        $user = $this->User->findById($user_id);
                        $supplier = $this->User->findById($this->request->data['User']['user_id']);
                        $event = $this->Event->findById($this->request->data['User']['event_id']);

                        // Envoi du mail
                        App::uses('CakeEmail', 'Network/Email');
                        $mail = new CakeEmail();
                        $mail->from($user['User']['mail']);
                        $mail->to($supplier['User']['mail']);
                        $mail->cc($user['User']['mail']);
                        $mail->subject('Demande de prestation');
                        $mail->emailFormat('html');
                        $mail->template('mailprestataire');
                        $mail->viewVars(array('eventTitle' => $event['Event']['title'],
                            'username' => $user['User']['username'],
                            'firstname' => $user['User']['firstname'], 'lastname' => $user['User']['lastname'],
                            'message' => $this->request->data['User']['message']));
                        $mail->send();
                    }
                    $this->Session->setFlash("Le prestataire a bien été ajouté à l'événement.", "notif");
                } 
            } else {
                if($this->EventsUser->updateAll(array('EventsUser.type_id' => 4), 
                        array('EventsUser.event_id' => $eventId, 'EventsUser.user_id' => $supplierId))) {
                    $this->Session->setFlash("Le prestataire a bien été ajouté à l'événement.", "notif");
                }
            }
            if($eventBool) {
                $this->redirect(array('action' => 'view', 'controller' => 'Events', $eventId));
            } else {
                $this->redirect(array('action' => 'suppliers', 'controller' => 'Users'));
            }
        }
    }
    
    function delete($userId, $eventId) {
        $eventUser = array('event_id' => $eventId, 'user_id' => $userId);
        $this->EventsUser->deleteAll($eventUser, false);
        $this->redirect(array('action' => 'view', 'controller' => 'events', $eventId));
    }
    function rateEvent(){
       if ($this->request->is('post')){
           $rate = $this->request->data['EventsUser']['rating'];
           if(!$this->EventsUser->updateAll( array('EventsUser.note' => $rate),
                   array('EventsUser.event_id'=>$this->request->data['EventsUser']['event_id'],'EventsUser.user_id'=>$this->Auth->user('id')) ))
           {
               $this->session->setFlash('La mise à jour de la note n\'a pas été prise en compte');
           }
                          $this->redirect(array('action'=>'view','controller'=>'events',$this->request->data['EventsUser']['event_id']));

       }
    }

}

?>