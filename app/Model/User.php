<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

    public $validate = array(
        'username'=>array(
            array(
                'rule'=>'alphanumeric',
                'required'=>true,
                'allowEmpty'=> false,
                'message'=>"Votre pseudo n'est pas valide" 
            ),
            array(
                'rule'=>'isUnique',
                'message'=>'Ce pseudo est déjà utilisé'
            )
        ),
        'mail'=>array(
            array(
                'rule'=>'email',
                'required'=>true,
                'allowEmpty'=> false,
                'message'=>"Votre email n'est pas valide" 
            ),
            array(
                'rule'=>'isUnique',
                'message'=>'Cet email est déjà utilisé'
            )
        ),
        'password'=>array(
            'rule'=>'notEmpty',
            'message'=>"Vous devez saisir un mot de passe",
            'allowEmpty'=> false      
        )
    );


}
