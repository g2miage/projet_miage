<?php

class EventsUsers extends AppModel{
    public $actsAs = array('Containable');
    public $belongsTo = array('Event', 'User'); 
  
    }
    
?>
