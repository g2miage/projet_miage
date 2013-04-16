<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 */
class User extends AppModel {
    
     public $hasMany = array(
        'EventsUsers');
     
     public $belongsTo = array(
             'Suptype');
    
    public $hasAndBelongsToMany = array(
        'Event' =>
            array(
                'className'              => 'Events',
                'joinTable'              => 'events_users',
                'foreignKey'             => 'user_id',
                'associationForeignKey'  => 'event_id',
                'unique'                 => true,
                
            ));
    
    public $validate = array(
        
        'username' => array(
            array(
                'rule' => 'alphanumeric',
                'required' => true,
                'allowEmpty' => false,
                'message' => "Votre pseudo n'est pas valide"
            ),
            array(
                'rule' => 'isUnique',
                'message' => 'Ce pseudo est déjà utilisé'
            )
        ),
        'password' => array( 
        'identicalFieldValues' => array( 
        'rule' => array('identicalFieldValues', 'password_confirm' ), 
        'message' => 'Les mots de passes doivent être identiques' 
                ) 
            ),
        'password_confirm' => array(
            'required' => true,
            'allowEmpty' => false,
            ),
        'mail' => array(
            array(
                'rule' => 'email',
                'required' => true,
                'allowEmpty' => false,
                'message' => "Votre email n'est pas valide"
            ),
            array(
                'rule' => 'isUnique',
                'message' => 'Cet email est déjà utilisé'
            )
        )
    );

  function identicalFieldValues( $field=array(), $compare_field=null )  
    {
      
        foreach( $field as $key => $value ){ 
            $v1 = $value; 
            $v2 = $this->data[$this->name][ $compare_field ];
         
            if($v1 !== $v2) { 
                return FALSE; 
            } else { 
                continue; 
            } 
        } 
        return TRUE; 
    } 
    
     function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }
        return $result;
    }
}

