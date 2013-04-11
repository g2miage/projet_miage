<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EventsController extends AppController {

    public function index() {
        //On verifie si une recherche a été effectuée,
        if (isset($this->request->data['Event']['searchEventTitle']) == TRUE
        ) {

            if ($this->request->data['Event']['searchEventTitle'] != "") {

                $this->recherche();
            } else {
                $this->set('events', $this->Event->find('all'));
            }
            // On effectue la recherche
        } else {
            $this->set('events', $this->Event->find('all'));
        }
    }

    public function view($id) {

        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $event = $this->Event->findById($id);

        $user = current($event['User']);
        
        if (!$event) {
            throw new NotFoundException(__('Invalid post'));
        }

        $v = array('event' => $event, 'user' => $user);

        $this->set($v);
    }

    public function add() {
        if ($this->request->is('post')) {
            //$this->Event->create();
            if (AuthComponent::user('id')) {
                $user_id = AuthComponent::user('id');
            }

            if ($this->Event->save($this->request->data)) {
                $Event_id = $this->Event->getLastInsertID();
             
            } else {
                $this->Session->setFlash('Impossible de sauvegarder');
            }


            $this->Session->setFlash('Votre événement a bien été créé.');
            $this->redirect(array('action' => 'index'));
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

        if ($this->request->is('event') || $this->request->is('put')) {
            $this->Event->id = $id;
            if ($this->Event->save($this->request->data)) {
                $this->Session->setFlash('Votre événement a bien été mis à jour.');
                $this->redirect(array('action' => 'index'));
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

    private function recherche() {

        $this->set('events', $this->Event->find('all', array('conditions' =>
                    array('Event.title LIKE' => '%' . $this->request->data['Event']['searchEventTitle'] . '%'))));
    }

    

}
?>
