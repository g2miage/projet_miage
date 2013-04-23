<h1>Liste de mes prestataires</h1>

<table  class="table table-striped table_index">
    <tr>
        <th>Entreprise</th>
        <th>Nom du prestatire</th>
        <th>Activité</th>
        <th>Devis</th>
    </tr>

<!-- Here's where we loop through our $posts array, printing out post info -->



<?php foreach ($users as $user):  ?>

    <tr>
        <td >
            <?php echo $this->Html->link($user['User']['scorpname'], array('controller'=>'users','action' => 'view', $user['User']['id'])); ?>
        </td>
        <td >
            <?php echo $this->Html->link($user['User']['lastname'], array('controller'=>'users','action' => 'view', $user['User']['id'])); ?>
        </td>
        <td >
            <?php echo $this->Html->link($user['Suptype']['stype'], array('controller'=>'users','action' => 'view', $user['User']['id'])); ?>
        </td>
        <td class="actions">
            
        </td>
        
    </tr>
<?php endforeach; ?>

</table>