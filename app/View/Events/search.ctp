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

<?php foreach ($results as $event): ?>
    <tr>
        <td><?php echo $event['Event']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($event['Event']['title'], array('action' => 'view', $event['Event']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Html->link('Editer', array('action' => 'edit', $event['Event']['id'])); ?>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $event['Event']['id']),
                array('confirm' => 'Etes-vous sûr ?'));
            ?>
        </td>        
    </tr>
<?php endforeach; ?>

</table>