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
        /*$this->loadModel('User');
        //$this->EventsUser->contain('User');
        $EventsUser = $this->EventsUser->find('all', array(
            'contain' => array('User'),
            'conditions' => array(
                'event_id' => $eventId, 'type_id' => "4")
        ));*/
        $EventsUser = $this->EventsUser->find('all', array('conditions' => array('event_id' => $eventId, 'type_id' => "4")));
        

        $this->set('users', $EventsUser);
    }

    function addsupplier($userId, $eventId) {


        $EventsUser = array('EventsUser' => array('event_id' => $eventId,
                'user_id' => $userId, 'type_id' => "4"));

        $this->EventsUser->save($EventsUser, true, array('event_id', 'user_id', 'type_id'));

        $this->redirect(array('action' => 'suppliers', 'controller' => 'Users'));
    }

}

?>
