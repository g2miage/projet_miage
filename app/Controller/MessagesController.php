<?php

class MessagesController extends AppController {

    function index($eventId, $supplierId = null) {
        $this->loadModel('User');
        $this->loadModel('Event');
        $currentEvent = current($this->Event->findById($eventId));
        
        if ($supplierId != null) {
            $user = current($this->User->findById($supplierId));
            $this->set('supplierName', $user['username']);
            $this->set('supplierId', $supplierId);
            $this->set('type', 'organisateurs');
        } else {
            $supplierId = $this->Auth->user('id');
            $user = current($this->User->findById($supplierId));
            $this->set('supplierName', $user['username']);
            $this->set('type', 'prestataires');
        }
        $messages = $this->Message->find('all', array(
            'conditions' => array(
                'event_id' => $eventId,
                'user_id' => $supplierId,
                'message <>' => '',
                'presta_event' => '0'),
            array('order' => 'date')));
        $files = $this->Message->find('all', array(
            'conditions' => array(
                'event_id' => $eventId,
                'user_id' => $supplierId,
                'file <>' => '',
                'presta_event' => '0'),
            array('order' => 'date')));
        $this->set('messages', $messages);
        $this->set('files', $files);
        $this->set('eventId', $eventId);
        $this->set('eventName', $currentEvent['title']);
    }

    function addMessage() {

        if ($this->request->is('post')) {
            $type = $this->request->data['Message']['type'];
            if ($type == 'organisateurs') {
                $orga_username = $this->getCurrentUsername();
                $userId = $this->request->data['Message']['supplierId'];
            } else {
                $orga_username = null;
                $userId = $this->Auth->user('id');
            }

            $text = $this->request->data['Message']['message'];
            $eventId = $this->request->data['Message']['eventId'];
            $date = date('Y-m-d H:i:s');
            $message = array('event_id' => $eventId, 'user_id' => $userId, 'message' => $text, 'satus' => '0', 'date' => $date, 'orga_username' => $orga_username,'presta_event' => '0');
            $this->Message->save($message);
            if ($type == 'organisateurs') {
                $this->redirect(array('action' => 'index', $eventId, $userId));
            } else {
                $this->redirect(array('action' => 'index', $eventId));
            }
        }
    }

    function delete($messageId, $eventId = null,$type = null, $userId = null) {
        $message = current($this->Message->findById($messageId));
        if (!empty($message['file'])) {
            $fileTmp = new File($message['file'], false, 0777);
            $fileTmp->delete();
        }
        $this->Message->delete($messageId);
        if ($type != null && $eventId != null) {
            if ($type == 'organisateurs') {
                $this->redirect(array('action' => 'index', $eventId, $userId));
            } else {
                $this->redirect(array('action' => 'index', $eventId));
            }
        } elseif ($eventId != null) {
            $this->redirect(array('action' => 'view', 'controller' => 'events', $eventId));
        }
    }

    function addFile() {
        if ($this->request->is('post')) {
            $file = $this->uploadFile('files', $this->request->data, '');
            $type = $this->request->data['typeUser'];
            if (array_key_exists('urls', $file)) {
          
                if ($type == 'organisateurs') {
                    $orgaUsername = $this->getCurrentUsername();
                    $message = array(
                        'user_id' => $this->request->data['Message']['supplierId'],
                        'event_id' => $this->request->data['Message']['eventId'],
                        'date' => date('Y-m-d H:i:s'),
                        'orga_username' => $orgaUsername, 
                        'file' => $file['urls'][0],
                        'presta_event' => '0');
                } else {
                    $message = array('user_id' => $this->Auth->user('id'),
                        'event_id' => $this->request->data['Message']['eventId'],
                        'orga_username' => null, 'date' => date('Y-m-d H:i:s'),
                        'file' => $file['urls'][0], 'presta_event' => '0');
                }
                if ($this->Message->save($message, true, array('user_id', 'event_id', 'orga_username', 'date', 'file','presta_event'))) {
                    //$this->Session->setFlash('Vous avez ajouté un fichier', 'notif');
                }
            } else {
                $this->Session->setFlash('Votre fichier n\'a pas pu être sauvegarder.', 'notif', array('type' => 'error'));
            }
            if ($type == 'organisateurs') {
               $this->redirect(array('action' => 'index', $this->request->data['Message']['eventId'], $this->request->data['Message']['supplierId']));
            } else {
               $this->redirect(array('action' => 'index', $this->request->data['Message']['eventId']));
            }
        }
    }

    private function getCurrentUsername() {
        $this->loadModel('User');
        $currentUser = current($this->User->findById($this->Auth->user('id')));
        $orga_username = $currentUser['username'];
        return $orga_username;
    }
    
    function addMessageEvent() {
        if ($this->request->is('post')) {
            $eventId = $this->request->data['Message']['eventId'];
            $userId =  $this->Auth->user('id');
            $message = array(
              'event_id' => $eventId,
              'user_id' => $userId,
              'message' => $this->request->data['Message']['message'],
              'presta_event' => '1', 'date' => date('Y-m-d H:i:s')
            );
            
            if(!$this->Message->save($message)) {
                $this->Session->setFlash('Votre message \'a pas pu être envoyé correctement, veuillez réessayer.', 'notif', array('type' => 'error'));
            }
        }
        $this->redirect(array('action' => 'view', 'controller' => 'events', $eventId));
    }

    function validateDoc($messageId, $type, $eventId, $userId = null){
        $message = current($this->Message->findById($messageId));
        $this->Message->updateAll( array('status' => 1), array('Message.id' => $messageId));
        if ($type == 'organisateurs') {
            $this->redirect(array('action' => 'index', $eventId, $userId));
        } else {
            $this->redirect(array('action' => 'index', $eventId));
        }
    }
 
    
    function refuseDoc($messageId, $type, $eventId, $userId = null){
        $message = current($this->Message->findById($messageId));
        $this->Message->updateAll( array('status' => 0), array('Message.id' => $messageId));
        if ($type == 'organisateurs') {
            $this->redirect(array('action' => 'index', $eventId, $userId));
        } else {
            $this->redirect(array('action' => 'index', $eventId));
        }
    }
    
}

?>
