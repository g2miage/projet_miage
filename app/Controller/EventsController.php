<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EventsController extends AppController {
    
    public function index() {
        $this->set('events', $this->Event->find('all'));
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
    
}

?>
