<?php


class Eventtype extends AppModel{
    
    public $actsAs = array('Containable');
    
    public $hasMany = array('Event');
}

?>
