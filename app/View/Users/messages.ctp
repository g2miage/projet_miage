<?php 
    $unread = array(); $read = array();
    // séparation des messages lus et non lus
    foreach ($messages as $m):
        if($m['MessagesUsers']['status']){
            $read[] = array('title'=>$m['Event']['title'],'ide'=>$m['MessagesUsers']['event_id']);
        }else{
            $unread[] = array('title'=>$m['Event']['title'],'ide'=>$m['MessagesUsers']['event_id']);
        }
    endforeach;
?>

<h1>Mes messages</h1>

<h2>Reçus</h2>

<h3>Non-lus</h3>
    <table  class="table table-striped table_index">
        <tr>
            <th>Evénement</th>
            <th></th>
        </tr>
    <?php 
    // affichage des messages....
    foreach ($unread as $i => $value) {
        echo "<tr>";
            echo "<td>".$unread[$i]['title']."</td>";
            echo "<td>". 
                        $this->Html->link("<i class='icon-hand-right'></i>", array('controller' => 'Users','action' => 'readMsg'),array('escape'=>false,'title'=>'Voir le message')).
                    "</td>";
        echo "<tr>";
    }
    ?>
    </table>

<h3>Lus</h3>
    <table  class="table table-striped table_index">
        <tr>
            <th>Evénement</th>
            <th></th>
        </tr>
    <?php 
    // affichage des messages....
    foreach ($read as $i => $value) {
        echo "<tr>";
            echo "<td>".$read[$i]['title']."</td>";
            echo "<td>". 
                        $this->Html->link("<i class='icon-hand-right'></i>", array('controller' => 'Users','action' => 'readMsg'),array('escape'=>false,'title'=>'Voir le message')).
                    "</td>";
        echo "<tr>";
    }
    ?>
    </table>