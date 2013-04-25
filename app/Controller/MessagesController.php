<?php

class MessagesController extends AppController {

    function index($eventId, $supplierId = null) {
        if ($supplierId != null) {

            $messages = $this->Message->find('all', array(
                'conditions' => array(
                    'event_id' => $eventId,
                    'user_id' => $supplierId),
                array('order' => 'date')));
            $this->set('eventId', $eventId);
            $this->set('messages', $messages);
            $this->set('supplierId', $supplierId);
            $this->set('type', 'organisateurs');
        } else {
            $supplierId = $this->Auth->user('id');
            $messages = $this->Message->find('all', array(
                'conditions' => array(
                    'event_id' => $eventId,
                    'user_id' => $supplierId),
                array('order' => 'date')));

            $this->set('eventId', $eventId);
            $this->set('messages', $messages);
            $this->set('type', 'prestataires');
        }
    }

    function addMessage() {

        if ($this->request->is('post')) {
            $type = $this->request->data['Message']['type'];
            if ($type == 'organisateurs') {
                $orga_id = $this->Auth->user('id');
                $userId = $this->request->data['Message']['supplierId'];
            } else {
                $userId = $this->Auth->user('id');
            }

            $text = $this->request->data['Message']['message'];
            $eventId = $this->request->data['Message']['eventId'];
            $date = date('Y-m-d H:i:s');
            $message = array('event_id' => $eventId, 'user_id' => $userId, 'message' => $text, 'satus' => '0', 'date' => $date, 'orga_id' => $orga_id);
            $this->Message->save($message);
            if ($type == 'organisateurs') {
                $this->redirect(array('action' => 'index', $eventId, $userId));
            } else {
                $this->redirect(array('action' => 'index', $eventId));
            }
        }
    }

    function delete($messageId, $type, $eventId){
        
       $this->Message->delete($messageId);
       if ($type == 'organisateurs') {
                $this->redirect(array('action' => 'index', $eventId, $userId));
            } else {
                $this->redirect(array('action' => 'index', $eventId));
            }
    }
    
    
}

?>
