<?php

class MessagesUsers extends AppModel{
    public $actsAs = array('Containable');
    public $belongsTo = array('Message', 'User'); 
  
    }
    
?>
