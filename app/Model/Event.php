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
       'title' => array(
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false,
                'message' => "Il faut indiquer un titre à votre événement"
            )),
    
       'Event.desc' => array(
            array(
                'rule'    => 'notEmpty',
                'message'  => "Veuillez renseigner une description"
         )),
         
       'address' => array(
           array(
               'rule'    => 'notEmpty',
               'message'  => "Veuillez renseigner la zone"
            )), 
          
       'zip' => array(
            array(
                'rule'    => 'notEmpty',
                'message'  => "Veuillez renseigner la zone"
           )),
           
       'city' => array(
           array(
                'rule'    => 'notEmpty',
                'message'  => "Veuillez renseigner la zone"
           )),
           
       'startday' => array(
            array(
            'required' => true,
            'rule' => array('startDateValidation'),
            'message' => 'La date de début se trouve dans le passé' )),
         
       'endday' => array(
              array(
            'required' => true,
            'rule' => array('endDateValidation'),
            'message' => 'Date de fin inférieur à la date de début' )),
         
       'starttime' => array(
             array(
                'rule'     => 'time',
                'required' => true,
                'message'  => 'Veuillez renseigner une heure valide'
            )),
       'endtime' => array(
             array(
                'rule'     => 'time',
                'required' => true,
                'message'  => 'Veuillez renseigner une heure valide'
            )));
    
    function endDateValidation($field = array(), $compare_field = null) {
        foreach ($field as $key => $value) {
            $endDate = $value.' '.$this->data[$this->name]['endtime'];
            $startDate = $this->data[$this->name]['startday'].' '.$this->data[$this->name]['starttime'];
            $startDate = date_create_from_format('d/m/Y H:i', $startDate);
            $endDate = date_create_from_format('d/m/Y H:i', $endDate);
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
            $nowDate = date_create_from_format('d/m/Y H:i', date('d/m/Y H:m'));         
            if ($startTime < $nowDate) {
                return FALSE;
            }
        }
        return TRUE;
    }

}
?>
