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
       'title' => array(
           'alphaNumeric' => array(
            'required' => true)),
       'desc' => array(
           'alphaNumeric' => array(
            'required' => true),
           'between' => array(
               'rule' => array('minLength', '20')
           )),
       'address' => array(
           'alphaNumeric' => array(
            'required' => true)),
       'zip' => array(
           'alphaNumeric' => array(
            'required' => true)),
       'city' => array(
           'alphaNumeric' => array(
            'required' => true)),
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
            'required' => true)),
       'endtime' => array(
           'alphaNumeric' => array(
            'required' => true))
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
            $startTime = $value.' '.$this->data[$this->name]['starttime'];
            if($startTime < date('d/m/Y H:m')) {
                return FALSE;
            }
        }
        return TRUE;
    }
}
?>
