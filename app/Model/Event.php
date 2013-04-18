<?php

App::uses('AppModel', 'Model');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Event extends AppModel{
    public $actsAs = array('Containable');
    
    public $hasMany = array(
        'EventsUsers'
    );
    
    public $belongsTo = array(
        'Eventtype'
        );
     public $hasAndBelongsToMany = array(
        'User' =>
            array(
                'className'              => 'Users',
                'joinTable'              => 'events_users',
                'foreignKey'             => 'event_id',
                'associationForeignKey'  => 'user_id',
                'unique'                 => true,
                
            )
    );
     
     public $validate = array(
       'title'  => array(
            'alphaNumeric' => array(
                'rule'    => 'notEmpty',
                'required' => true,
                'message'  => 'Chiffres et lettres uniquement !'
            )),
       'Event.desc' => array(
                //'rule'    => array('minLength', 20  ),
                'rule'    => 'notEmpty',
                'message'  => 'Chiffres et lettres uniquement !'
         ),
       'address' => array(
            'alphaNumeric' => array(
                'rule'    => 'notEmpty',
                'required' => true,
                'message'  => 'Chiffres et lettres uniquement !'
            )
         ),
       'zip' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Chiffres et lettres uniquement !'
            )),
       'city' => array(
            'alphaNumeric' => array(
                'rule'     => 'notEmpty',
                'required' => true,
                'message'  => 'Chiffres et lettres uniquement !'
            )),
       'startday' => array(
           'alphaNumeric' => array(
            'required' => true,
            'rule' => array('startDateValidation'),
            'message' => 'La date de début se trouve dans le passé' )),
       'endday' => array(
           'alphaNumeric' => array(
            'required' => true,
            'rule' => array('endDateValidation'),
            'message' => 'Date de fin inférieur à la date de début' )),
       'starttime' => array(
            'alphaNumeric' => array(
                'rule'     => 'time',
                'required' => true,
                'message'  => 'Veuillez renseigner une heure valide'
            )),
       'endtime' => array(
            'alphaNumeric' => array(
                'rule'     => 'time',
                'required' => true,
                'message'  => 'Veuillez renseigner une heure valide'
            ))
     );
    
    function endDateValidation($field = array(), $compare_field = null) {
        foreach ($field as $key => $value) {
            $endDate = $value.' '.$this->data[$this->name]['endtime'];
            $startDate = $this->data[$this->name]['startday'].' '.$this->data[$this->name]['starttime'];
            if($startDate > $endDate) {
                return FALSE;
            }
        }
        return TRUE;
    }
    
    function startDateValidation($field = array(), $compare_field = null) {
        foreach ($field as $key => $value) {
            $startTime = $value . ' ' . $this->data[$this->name]['starttime'];
            $startTime = date_create_from_format('d/m/Y H:i', $startTime);
            $startTime = $startTime->format('d/m/Y H:i');
            if ($startTime < date('d/m/Y H:m')) {
                return FALSE;
            }
        }
        return TRUE;
    }

}
?>
