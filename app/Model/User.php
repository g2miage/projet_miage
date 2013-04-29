<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 */
class User extends AppModel {

    public $actsAs = array('Containable',
        'Captcha' => array(
            'field' => 'captcha',
            'error' => 'Le code captcha n\'est pas bon.'
        ));
    public $hasMany = array(
                        'EventsUsers',
                        'MessagesUsers'
                 );
    public $belongsTo = array(
        'Suptype');
    public $hasAndBelongsToMany = array(
        'Event' =>
        array(
            'className' => 'Events',
            'joinTable' => 'events_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'event_id',
            'unique' => true,
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
                'rule' => array('identicalFieldValues', 'password_confirm'),
                'message' => 'Les mots de passe doivent être identiques'
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
        ),
        'scorpname' => array(
            'rule' => array('validateSuppliers'),
            'message' => 'Les champs avec * sont obligatoires.'
        ),
        'address' => array(
            'rule' => array('validateSuppliers'),
            'message' => 'Les champs avec * sont obligatoires.'
        ),
        'zip' => array(
            'rule' => array('validateSuppliers'),
            'message' => 'Les champs avec * sont obligatoires.'
        ),
        'city' => array(
            'rule' => array('validateSuppliers'),
            'message' => 'Les champs avec * sont obligatoires.'
        ),
        'country' => array(
            'rule' => array('validateSuppliers'),
            'message' => 'Les champs avec * sont obligatoires.'
        )
    );

    function identicalFieldValues($field = array(), $compare_field = null) {

        foreach ($field as $key => $value) {
            $v1 = $value;
            $v2 = $this->data[$this->name][$compare_field];

            if ($v1 !== $v2) {
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

    function validateSuppliers($field = array()) {
        foreach ($field as $key => $value) {
            if ($this->data[$this->name]['role_id'] == 1 && empty($value)) {
                return FALSE;
            }
        }
        return TRUE;
    }

}

