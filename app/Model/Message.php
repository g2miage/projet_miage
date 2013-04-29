<?php

class Message extends AppModel{
    public $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'   => 'user_id'
        ),
        'Event' => array(
            'className'    => 'Event',
            'foreignKey'   => 'event_id'
        )
    );

}

?>
