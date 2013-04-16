<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EventsController extends AppController {

    // Helper GoogleMap
    public $helpers = array('GoogleMap', 'Tinymce');

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
        $type = $this->Event->Eventtype->find();
       
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
            'current_user' => $current_user,
            'typename'=>$type['Eventtype']['name']
        );

        $this->set($v);
    }

    public function add() {
        
        if ($this->request->is('post')) {
            $this->Event->create();

            if (!empty($this->request->data['Event']['picture']['name'])){
                // upload the file to the server
                $fileOK = $this->uploadFiles('img/event', $this->request->data['Event']);
                if (array_key_exists('urls', $fileOK)) {
                    // save the url in the form data
                    $size = $this->request->data['Event']['picture']['size'];
                    $this->request->data['Event']['picture'] = $fileOK['urls'][0];
                }
            } else {
                $this->request->data['Event']['picture']='';
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
        }  else {
            debug($this->Event->Eventtype->find('list'));
            $this->set('eventtypes',  $this->Event->Eventtype->find('list',array('fields')));
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
                $file = new File('img/'.$img_path,FALSE);
                $file->delete();
                $fileOK = $this->uploadFiles('img/event', $this->request->data['Event']);
                
                if (array_key_exists('urls', $fileOK)) {
                    // save the url in the form data
                    $size = $this->request->data['Event']['picture']['size'];
                    $this->request->data['Event']['picture'] = substr($fileOK['urls'][0], 4);
                }
            }else {
                 $this->request->data['Event']['picture'] =$img_path;
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
    
    public function addorganisateur($id){
        
        if ($this->request->is('post')) {
        $chaine = $this->data['Event']['chaine'];
        
        $d = $this->searchuser($chaine);
        
        $this->set(array('resultat'=>$d, 'e_id'=>$id));
        } 
    }
    
     public function searchuser($chaine) {
            $this->loadModel('User');
            
            //$this->User->contain();
            $d =$this->User->find('all', array(
                'conditions' => array(
                    'OR'=>array(
                            'User.username LIKE' => "%" . $chaine . "%",
                            'User.lastname LIKE' => "%" . $chaine . "%",
                            'User.firstname LIKE' => "%" . $chaine . "%"
                ),'User.role_id'=>1),
                    'recursive'=> -1));
            
                return $d;
        
            
    }
    
     public function organisateur($u_id,$e_id) {
        $d = array('event_id'=>$e_id,'user_id'=>$u_id,'type_id'=>2);
         try {
             if($this->Event->EventsUsers->save($d)){
                $this->mailinvitation($e_id,$u_id,'Organisateur'); 
                $this->Session->setFlash('Vous avez ajouté un organisateur', 'notif');
            }else{
                $this->Session->setFlash('Impossible ', 'notif',array('type' =>'error'));
            }
             
         } catch (Exception $exc) {
             $this->Session->setFlash('Cet utilisateur est déjà organisateur ', 'notif',array('type' =>'error'));
         }
         $this->redirect(array('action' => 'view',$e_id));
     }
     
     
     public function inviter($u_id,$e_id) {
         $d = array('event_id'=>$e_id,'user_id'=>$u_id,'type_id'=>3);
         try {
             if($this->Event->EventsUsers->save($d)){
                $this->mailinvitation($e_id,$u_id,'Invité'); 
                $this->Session->setFlash('Vous avez ajouté un nouvel invité', 'notif');
            }else{
                $this->Session->setFlash('Impossible ', 'notif',array('type' =>'error'));
            }
             
         } catch (Exception $exc) {
             $this->Session->setFlash('Cet utilisateur est déjà invité ou organisateur', 'notif',array('type' =>'error'));
         }
         $this->redirect(array('action' => 'view',$e_id));
     }
     
     
     function mailinvitation($e_id,$u_id,$role){
         $this->loadModel('User');
         $invite= current($this->User->findById($u_id));
         $user  = current($this->User->findById($this->Auth->user('id')));
         $event = current($this->Event->findById($e_id));
         
         App::uses('CakeEmail', 'Network/Email');
       
                
        $mail = new CakeEmail();
        $mail->from('no-reply@events.com')
                ->to($user['mail'])
                ->subject('Invitation Events')
                ->emailFormat('html')
                ->template('mailinvitation')
                ->viewVars(array('name' => $invite['firstname'],'user'=>$user['lastname'],'event' => $event['title'],'role'=>$role))
                ->send();
     }

     function deleteimg($id){
        $event =  current($this->Event->findById($id));
        $file = new File('img/'.$event['picture'],FALSE);
                $file->delete();
        $this->Event->id = $id;        
        if($this->Event->saveField('picture','')){
        
             $this->Session->setFlash('L\'image a été supprimé ' , 'notif');
        }
        
        $this->redirect(array('action' => 'edit',$id));
        
        
     }

}
