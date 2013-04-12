<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EventsController extends AppController {
    // Helper GoogleMap
    public $helpers = array('GoogleMap');

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

        $event = $this->Event->findById($id);
        if (!$event) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('event', $event);
    
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Event->create();
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
        $data = $this->Event->read(null, $event_id);
        $data['User'][0]['EventsUser']['type_id'] = "2";
        $this->Event->save($data, true, array(User => EventsUser, 'type_id'));
        $this->redirect(array('action' => 'view', $event_id));
    }

    public function refuse($event_id) {
        $data = $this->Event->read(null, $event_id);
        $data['User'][0]['EventsUser']['type_id'] = "3";
        $this->Event->save($data, true, array(User => EventsUser, 'type_id'));
        $this->redirect(array('action' => 'view', $event_id));
    }

}
?>

