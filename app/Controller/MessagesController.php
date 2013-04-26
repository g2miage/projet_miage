<?php

class MessagesController extends AppController {

    function index($eventId, $supplierId = null) {
        $this->loadModel('User');
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
                'message <>' => ''),
            array('order' => 'date')));
        $files = $this->Message->find('all', array(
            'conditions' => array(
                'event_id' => $eventId,
                'user_id' => $supplierId,
                'file <>' => ''),
            array('order' => 'date')));
        $this->set('messages', $messages);
        $this->set('files', $files);
        $this->set('eventId', $eventId);
    }

    function addMessage() {

        if ($this->request->is('post')) {
            $type = $this->request->data['Message']['type'];
            if ($type == 'organisateurs') {
                $orga_id = $this->Auth->user('id');
                $userId = $this->request->data['Message']['supplierId'];
            } else {
                $orga_id = null;
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

    function delete($messageId, $type, $eventId, $userId = null) {
        $message = current($this->Message->findById($messageId));
        if (!empty($message['file'])) {
            $fileTmp = new File($message['file'], false, 0777);
            $fileTmp->delete();
        }
        $this->Message->delete($messageId);
        if ($type == 'organisateurs') {
            $this->redirect(array('action' => 'index', $eventId, $userId));
        } else {
            $this->redirect(array('action' => 'index', $eventId));
        }
    }

    function addFile() {
        if ($this->request->is('post')) {
            $file = $this->uploadFile('files', $this->request->data, '');
            $type = $this->request->data['typeUser'];
            if (array_key_exists('urls', $file)) {
                if ($type == 'organisateurs') {
                    $message = array('user_id' => $this->request->data['Message']['supplierId'],
                        'event_id' => $this->request->data['Message']['eventId'],
                        'orga_id' => $this->Auth->user('id'), 'date' => date('Y-m-d H:i:s'),
                        'file' => $file['urls'][0]);
                } else {
                    $message = array('user_id' => $this->Auth->user('id'),
                        'event_id' => $this->request->data['Message']['eventId'],
                        'orga_id' => null, 'date' => date('Y-m-d H:i:s'),
                        'file' => $file['urls'][0]);
                }
                if ($this->Message->save($message, true, array('user_id', 'event_id', 'orga_id', 'date', 'file'))) {
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

}

?>
