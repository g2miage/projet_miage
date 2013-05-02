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

<p>Les événements suivants ont reçus des notifications.</p>

<h3>Non-lus</h3>
    <?php if(!$unread){ ?>
<div class="row">
    <div class="span4">
        <p class="text-center alert alert-info">Aucun message non lu <b>:)</b></p>        
    </div>
    </div>
    <?php }else{?>
    <table  class="table table-striped" style="display: block">
        <tr>
            <th>Evénement</th>
            <th></th>
        </tr>
    <?php 
    // affichage des messages....
    foreach ($unread as $i => $value) {
        echo "<tr>";
            echo "<td class='span4'>".$unread[$i]['title']."</td>";
            echo "<td>". 
                        $this->Html->link("<i class='icon-hand-right'></i> Voir la discussion", array('controller' => 'Users','action' => 'readMsg',$unread[$i]['ide'],Inflector::slug($unread[$i]['title'], '-')),array('escape'=>false,'title'=>'Voir le message')).
                    "</td>";
        echo "<tr>";
    }
    ?>
    </table>
    <?php } ?>
<h3>Lus</h3>
    <?php if(!$read){ ?>
<div class="row">
    <div class="span4">
        <p class="text-center alert alert-info">Aucun message non lu <b>:)</b></p>        
    </div>
    </div>
    <?php }else{?>
    <table  class="table table-striped" style="display: block;text-align: right">
        <tr>
            <th>Evénement</th>
            <th></th>
        </tr>
    <?php 
    // affichage des messages....
    foreach ($read as $i => $value) {
        echo "<tr>";
            echo "<td  class='span4'>".$read[$i]['title']."</td>";
            echo "<td>". 
                        $this->Html->link("<i class='icon-hand-right'></i> Voir la discussion", array('controller' => 'Events','action' => 'view',$read[$i]['ide'], Inflector::slug($read[$i]['title'], '-')),array('escape'=>false,'title'=>'Voir le message')).
                    "</td>";
        echo "<tr>";
    }
    ?>
    </table>
    <?php } ?>