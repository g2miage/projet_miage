<!-- File: /app/View/Events/index.ctp  (edit links added) -->

<h1>Evénements</h1>
<!--<p><?php echo $this->Html->link("Add Post", array('action' => 'add')); ?></p>-->
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
        
    </tr>
<?php endforeach; ?>

</table>