<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 * @author Cheikh
 */
class UsersController extends AppController {

    //put your code here
    
    public function signup() {
        if ($this->request->is('post')) {
            $d = $this->request->data;
            if (!empty($d['User']['password'])) {
                $d['User']['password'] = Security::hash($d['User']['password'],null,true);
            }
            if (!empty($d['User']['password_confirm'])) {
                $d['User']['password_confirm'] = Security::hash($d['User']['password_confirm'],null,true);
            }

            if ($this->User->save($d, true, array('username', 'password', 'mail'))) {
                $link = array('controller' => 'users', 'action' => 'activate', $this->User->id . '-' . md5($d['User']['password']));
                App::uses('CakeEmail', 'Network/Email');
                $mail = new CakeEmail();
                $mail->from('no-reply@events.com')
                        ->to($d['User']['mail'])
                        ->subject('Activation compte Events')
                        ->emailFormat('html')
                        ->template('signup')
                        ->viewVars(array('username' => $d['User']['username'], 'link' => $link))
                        ->send();
                $this->Session->setFlash("Votre compte a bien été créé. Vous allez recevoir un mail d'activation", 'notif');
                $this->redirect('/');
                
            } else {
                $this->Session->setFlash('Merci de corriger vos erreurs', 'notif', array(
                    'type' => 'error'));
            }
        }
    }

    
    
    public function logout(){
        $user_id = $this->Auth->user('id');
        if(!$user_id){
            $this->redirect('/');
            die();
        }
        $this->Auth->logout();
        $this->redirect('/');
    }
    
    public function login(){
        if($this->Auth->login()){
           $this->User->id = $this->Auth->user('id');
           $this->User->saveField('lastlogin',date('Y-m-d H:i:s'));
           $this->Session->setFlash("Vous êtes connecté", "notif"); 
           $this->redirect('/');
        }  else {
            $this->Session->setFlash("Indendifiants incorrects", "notif", array('type' => 'error'));
           
        }
    }

    public function activate($token) {
        $token = explode('-', $token);
        $user = $this->User->find('first', array(
            'conditions' => array('id' => $token[0], 'active' => 0)
        ));
        if (!empty($user)) {
            $this->User->id = $user['User']['id'];
            $this->User->saveField('active', 1);
            $this->Session->setFlash("Votre compte a bien été activé", "notif");
            $this->Auth->login($user['User']);
            
        } else {
            $this->Session->setFlash("Votre lien ne semble pas valide", "notif", array('type' => 'error'));
        }
        $this->redirect('/');
    }
    
    public function profil(){
        $user_id = $this->Auth->user('id');
        if(!$user_id){
            $this->redirect('/');
            die();
        }
    }
    public function edit(){
        $user_id = $this->Auth->user('id');
        if(!$user_id){
            $this->redirect('/');
            die();
        }
        $this->User->id = $user_id;
        if ($this->request->is('put') || $this->request->is('post')){
             $d = $this->request->data;   
             $d['User']['id'] = $user_id;
                if (!empty($d['User']['password1'])) {
                    $d['User']['password'] = Security::hash($d['User']['password1'],null,true);

                    if (!empty($d['User']['password_confirm'])) {
                        $d['User']['password_confirm'] = Security::hash($d['User']['password_confirm'],null,true);
                    
                    }
                }
                
                if($this->User->save($d, true, array('firstname','lastname','mail','tel','city','zip','country','address','sex'))){
                         $this->Session->setFlash("Votre profil a bien été modifié", "notif");
                         $this->redirect(array('controller'=>'users', 'action'=>'profil'));

                     }  else {
                        $this->Session->setFlash("Impossible de sauvegarder, Merci de corriger", "notif", array('type' => 'error'));   
                     }
         }else {
         $this->request->data = $this->User->read();
         }
         $this->request->data['User']['password1']=$this->request->data['User']['password_confirm']='';
    }  
    
    function uploadImage()
    {
        $fileOK = $this->User->uploadFiles('../',$this->request->data['picture']);
        $this->redirect(array('controller'=>'users','action' => 'edit'));
    }
    
    public function editpassword() {
        $user_id = $this->Auth->user('id');
        if(!$user_id){
            $this->redirect('/');
            die();
        }
        $id = AuthComponent::user('id');
        $currentUser= current($this->User->findById($id));
        if ($this->request->is('post')) {
           $d = $this->request->data;
           if (Security::hash($d['User']['password1'],null,true) == $currentUser['password']) {      
                   $d['User']['id'] = $currentUser['id'];
                   $d['User']['password'] = Security::hash($d['User']['password'],null,true);
                   $d['User']['password_confirm'] = Security::hash($d['User']['password_confirm'],null,true);
                   if($this->User->save($d, true, array('password'))){
                        $this->Session->setFlash("Votre profil a bien été modifié", "notif");
                        $this->redirect(array('controller'=>'users', 'action'=>'profil'));
                   }  else {
                       $this->Session->setFlash("Impossible de sauvegarder, Merci de corriger", "notif", array('type' => 'error'));
                   }        
           } else {
               $this->Session->setFlash("Mot de passe in correcte", "notif", array('type' => 'error'));
           }   
        }
    }
    
    
}
?>
