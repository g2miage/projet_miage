<!-- File: /app/View/Events/index.ctp  (edit links added) -->
<?php
	// Déclaration variables:
    $inscription = 0;

	// On recherche si l'Utilisateur est invité ou est inscrit
	// Type_id : 1 organisateur, créateur
	//           2 Participant
	//           3 Invité

    foreach ($event['User'] as $key => $users) {

        $user_connected = $_SESSION['Auth']['User']['id'];
        if ($users['id'] == $user_connected && $users['EventsUser']['type_id'] == "1") {
            $inscription = 1;
        } elseif ($users['id'] == $user_connected && $users['EventsUser']['type_id'] == "2") {
            $inscription = 2;
        } elseif ($users['id'] == $user_connected && $users['EventsUser']['type_id'] == "3") {
            $inscription = 3;
        }
    }
    if ($inscription == 2) {
        echo $this->Html->link("Se désinscrire", array('action' => 'refuse', $event['Event']['id']), array('class' => 'btn btn-danger pull-right'));
    } elseif ($inscription == 3) {
        echo $this->Html->link("S'inscrire", array('action' => 'participate', $event['Event']['id']), array('class' => 'btn btn-info pull-right'));
    } elseif ($inscription == 1) {
        echo $this->Html->link("Modifier l'evenement", array('action' => 'edit', $event['Event']['id']), array('class' => 'btn btn-info pull-right'));
   
    }
?>
<div class="event">
    <div class='padding'>
        <h1 class='title_event'><?php echo $event['Event']['title']; ?></h1>
        <?php echo $this->Html->link("<i class='icon-remove'></i> Refuser", array('action' => 'refuse'),
              array('class' => 'btn btn-danger pull-right','escape'=>false));

              echo $this->Html->link("<i class='icon-ok'></i> Participer", array('action' => 'participate'),
              array('class' => 'btn btn-info pull-right','escape'=>false));
        ?>
    </div>


    <table class="event_view">
        <tr>
            <td>
                <?php   
                    if($event['Event']['visibility'] == 0){
                        echo "<i class='icon-globe'></i></td><td>
                              <p>Public a Créé par : Createur</p>";
                    }else{
                        echo "<i class='icon-group'></i></td><td>
                             <p>Privé . Créé par : "."Jean Valjean</p>";
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td><i class="icon-time"></i></td>
            <?php 
                if($event['Event']['startday'] == $event['Event']['endday']){ 
                    echo "<td>
                            Le <b>".$event['Event']['startday']."</b> 
                            de <b><span class='text-success'>".$event['Event']['starttime']."</span></b> 
                            à <b><span class='text-error'>".$event['Event']['endtime']."</span></b></p></td>";
                 }else{ 
                    echo "<td>
                            Commence le <b>".$event['Event']['startday']."</b> 
                            à partir de <b><span class='text-success'>".$event['Event']['starttime']."</span></b> 
                            et se termine le <b>".$event['Event']['endday']."</b> le 
                            à <b><span class='text-error'>".$event['Event']['endtime']."</span></b>.</p>
                          </td>";
                 } 
            ?>
        </tr>
        
        <?php 
            if(!is_null($event['Event']['picture'])){ 
                echo "<tr><td></td><td>".$this->Html->image($event['Event']['picture'], array('alt' => ':/'))."</td></tr>";
            } 
         ?>
            
        <tr>
            <td><i class="icon-align-justify"></i></td>
            <td><p><?php echo nl2br($event['Event']['desc']);?></p></td>
        </tr>
    <tr>
        <td><i class="icon-user"></i></td>
        <td>
            Participant
        </td>
    </tr>

            <?php
            foreach ($event['User'] as $key => $users) {

                if ($users['EventsUser']['type_id'] == "2") {
                    echo "<tr>
                 <td></td>
                 <td>" . $users['firstname'] . " 
                 </td>
           </tr>";
                }
            }
            ?>

    <tr>
        <td><i class="icon-user"></i></td>
        <td>
            Invités
        </td>
    </tr>
    <?php
    foreach ($event['User'] as $key => $users) {

        if ($users['EventsUser']['type_id'] == "3") {
            echo "<tr>
                 <td></td>
                 <td>" . $users['firstname'] . " 
                 </td>
           </tr>";
        }
    }
    ?>
</table>
    <br />
    <?php
        echo $this->Html->link("Retourner à la liste des événements", array('action' => 'index'),
              array('class' => 'btn btn-info','escape'=>false));
    ?>
</div>

