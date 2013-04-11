<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 */
class User extends AppModel {
    
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


}

/*
 * 'password_confirm'=>array(
            'required' = true,
            'allowEmpty'=> false,
            'passwordequal'  => array('rule' =>'checkpasswords','message' => 'Passwords dont match')
        )
 */