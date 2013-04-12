<!-- File: /app/View/Events/index.ctp  (edit links added) -->

<div class='padding'><h1 class='title_event'><?php echo $event['Event']['title']; ?></h1>
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




</div>


<table class="event_view">

    <tr>
        <td>
    <?php
    if ($event['Event']['visibility'] == 0) {
        echo "<i class='icon-globe'></i></td><td>
              Public a Créé par : " . "jean valjeant</td>";
    } else {
        echo "<i class='icon-group'></i></td><td>
             Privé . Créé par : " . "jean valjeant</td>";
    }
    ?>

    </tr>

    <tr>
        <td><i class="icon-align-justify"></i></td>
        <td>
            <?php echo $event['Event']['desc']; ?>
        </td>
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


