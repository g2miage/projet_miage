<?php

class EventsUsersController extends AppController {
    
    function add($eventId){
       
        $userId = $this->Auth->user('id');
       
        $EventsUser = array ('EventsUser' => array( 'event_id' => $eventId, 
            'user_id' => $userId, 'type_id' => "1"));
        
         $this->EventsUser->save($EventsUser, true, array( 'event_id', 'user_id' , 'type_id' ));
              
          
        
     
    }
    
    
}
?>
