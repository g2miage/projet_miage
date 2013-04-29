<?php

class Message extends AppModel{
    public $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'   => 'user_id'
        )
    );
    
    public $hasMany = array(
        'MessagesUsers'
    );
}

?>
