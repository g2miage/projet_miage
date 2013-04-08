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
class UsersController extends AppController{
    //put your code here

    public function signup(){
      if($this->request->is('post')){
          $d = $this->request->data;
          $d['User']['id']=null;
          $d['User']['lastlogin'] ='2009-08-08 12:17:00';
          if(!empty($d['User']['password'])){
              $d['User']['password'] = Security::hash($d['User']['password']);
          }
          if($this->User->save($d,true,array('username','password','mail'))){
              $link = array('controller'=>'users','action'=>'activate',  $this->User->id.'-'.md5($d['User']['password']));
              App::uses('CakeEmail', 'Network/Email');
              $mail =new CakeEmail();
              $mail->from('noreplay@events.com')
                   ->to($d['User']['mail'])
                   ->subject('Dors bien, nous avons du boulot demin (-_-)')
                   ->emailFormat('html')
                   ->template('signup')
                   ->viewVars(array('username'=>$d['User']['username'],'link'=>$link))
                   ->send();
              $this->Session->setFlash('Votre compte a bien été créé','notif');
          }else {
              $this->Session->setFlash('Merci de corriger vos erreurs','notif',array(
                  'type'=>'error'));
        
          }
              
      }  
    }
    
    
    
    public function activate($token){
        $token = explode('-', $token);
        $user = $this->User->find('first',array(
            'conditions'=>array('id'=>$token[0],'active'=>0)
        ));
        if(!empty($user)){
            $this->User->id = $user['User']['id'];
            $this->User->saveField('active',1);
            $this->Session->setFlash ("Votre compte a bien été activé","notif");         
        }
        else {
            $this->Session->setFlash ("Votre lien ne semble pas valide","notif", array('type'=>'error'));         
        }
        $this->redirect('/');
    }
}

?>
