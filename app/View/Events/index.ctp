<!-- File: /app/View/Events/index.ctp  (edit links added) -->
<?php  
    echo $this->Form->create("Event",array('action' => 'search')); 
    echo $this->Form->input("searchEvent", array('label' => 'Search for')); 
    echo $this->Form->end("Search"); 
?> 

<h1>Evénements</h1>
<p><?php echo $this->Html->link("Créer un événement", array('action' => 'add')); ?></p>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
    </tr>

<!-- Here's where we loop through our $posts array, printing out post info -->

<?php foreach ($events as $event): ?>
    <tr>
        <td><?php echo $event['Event']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($event['Event']['title'], array('action' => 'view', $event['Event']['id'])); ?>
        </td>
        <td>
            <!-- echo $this->Html->link($this->Html->image('editButton.png'), array('action' => 'edit', $event['Event']['id'])); ?>-->
            <?php echo $this->Html->image("editButton.png", array(
            "alt" => "Editer",
            'url' => array('controller' => 'events', 'action' => 'edit', $event['Event']['id'])
)); ?>
            <?php echo $this->Form->postLink(
                $this->Html->image('deleteButton.png',array(
                "alt" => "Editer")),
                array('action' => 'delete', $event['Event']['id']),
                array('escape' => false, 'confirm' => 'Etes-vous sûr ?'));
            ?>
        </td>        
    </tr>
<?php endforeach; ?>

</table>