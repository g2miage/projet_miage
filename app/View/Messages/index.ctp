
<h1>Communication avec les Préstataires</h1>
<?php
 
    foreach ($messages as $message){
        if($message['Message']['orga_id'] == NULL){
             echo '<table class="table">';
            echo '<tr class="warning"><td>'.$message['Message']['message'].'</td>';
            if($type == 'prestataires'){
            echo '<td>';
                echo $this->Html->link('<i class="icon-trash"></i>', array('action' => 'delete', $message['Message']['id'], $type, $eventId), array('escape' => false, 'class' => 'pull-right'));
            echo '</td>';
            }
            
             echo '</tr></table>';
        }
        else{
             echo '<table class="table">';
            echo '<tr class="success"><td>'.$message['Message']['message'].'</td>';
             if($type == 'organisateurs'){
            echo '<td>';
                echo $this->Html->link('<i class="icon-trash"></i>',
                     array('action' => 'delete', $message['Message']['id'], $type, $eventId, $supplierId ), array('escape' => false, 'class' => 'pull-right'));
            echo '</td>';
            }
             echo '</tr></table>';
        }
    }
  
    
    

    // Création du formulaire de contact presta
   
    echo $this->Form->create('Message', array('action' => 'addMessage', 'div' => false));
    
    echo $this->Tinymce->input('Message.message', array('label' => ''),null, 'basic');
    echo $this->Form->input('Message.eventId', array('type' => 'hidden', 'value' => $eventId));
    echo $this->Form->input('Message.type', array('type' => 'hidden', 'value' => $type));
    if(isset($supplierId)){
    echo $this->Form->input('Message.supplierId', array('type' => 'hidden', 'value' => $supplierId));
    }
    echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary'));
    
    
    
   