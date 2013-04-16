<?php

class Suptype extends AppModel{
    
    public $actsAs = array('Containable');
    
    public $hasMany = array('User');
  
    }
    
?>
