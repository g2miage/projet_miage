<?php

App::uses('AppModel', 'Model');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Event extends AppModel{
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
    
    
}
?>
