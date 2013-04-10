<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Event extends AppModel{
    
    public $hasAndBelongsToMany= array('User'); 
}
?>
