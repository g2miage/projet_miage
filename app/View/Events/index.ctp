<!-- File: /app/View/Events/index.ctp  (edit links added) -->


<h1>Liste des événements</h1>



    <?php echo $this->Form->create("Event",array('action' => 'index', 'div'=>false)); ?>
<ul class="inline">
    <li><?php echo $this->Form->input("searchEventTitle", array('label' => '', 'div'=>false)); ?> </li>
    <li><?php echo $this->Form->end( array('label' =>"Rechercher", 'class'=>'btn btn-primary btn_align', 'div'=>false)); 
?></li>
</ul>


<table  class="table table-striped table_index">
    <tr>
        <th>Nom de l'événement</th>
        <th></th>
    </tr>

<!-- Here's where we loop through our $posts array, printing out post info -->



<?php foreach ($events as $event):  ?>

    <tr>
        <td >
            <?php echo $this->Html->link($event['Event']['title'], array('action' => 'view', $event['Event']['id'])); ?>
        </td>
        <td class="actions">
            <?php echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $event['Event']['id']), array('escape' => false)); ?>
        </td>
        
    </tr>
<?php endforeach; ?>

</table>

<p><?php echo $this->Html->link("Créer un événement", array('action' => 'add'), array('class' => 'btn btn-info')); ?></p>


