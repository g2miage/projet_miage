<h1>Ajouter un membre à l'événement</h1>

   <?php echo $this->Form->create('Event',array('class'=>'form-search'));?> 
    <div class="input-append">
   <?php echo $this->Form->input('chaine',array('class'=>'span2 search-query','label'=>false,'div'=>false)); ?>
   <?php echo $this->Form->end(array('label' => 'Rechercher','class'=>'btn','div'=>false)); ?>    
    </div>


<?php 
    if(!empty($resultat)){
?>
    <table  class="table table-striped table_index">
        <tr>
            <th>Nom de l'événement</th>
            <th></th>
        </tr>
    <!-- Here's where we loop through our $posts array, printing out post info -->
    <?php foreach ($resultat as $user):  ?>
        <tr>
            <td >
                <?php echo $user['User']['username']; ?>
            </td>
            <td class="actions">
                <?php echo $this->Html->link('<i class="icon-user"> Organisateur</i>', array('action' => 'organisateur', $user['User']['id'],$e_id), array('escape' => false)); ?>
                <?php echo $this->Html->link('<i class="icon-user"> Invité</i>', array('action' => 'inviter', $user['User']['id'],$e_id), array('escape' => false)); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php    }
?>