<!-- File: /app/View/Events/index.ctp  (edit links added) -->
<h1>Liste des événements</h1>

<?php
if (isset($events)) {
    foreach ($events as $event):
        $titles[] = $event['Event']['title'];
    endforeach;
}
else {
    $titles[] = "";
}
echo $this->Form->create("Event", array('action' => 'index', 'div' => false));
?>
<ul class="inline">
    <!--<li><?php //echo $this->Form->input("searchEventTitle", array('label' => '', 'div'=>false,'data-provide' => 'typeahead','data-source'=> '','escape'=>false));                    ?> </li>-->
    <input name="data[Event][searchEventTitle]" id="searchEventTitle" type="text" data-provide="typeahead" data-source='<?php echo json_encode($titles); ?>'>
    <li><?php echo $this->Form->end(array('label' => "Rechercher", 'class' => 'btn btn-primary btn_align', 'div' => false)); ?></li>
    <li>
        <?php echo $this->Html->link("Créer un événement", array('action' => 'add'), array('class' => 'btn btn-success   btn_align', 'div' => false)); ?>

    </li>
</ul>

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tous" data-toggle="tab">Tous mes événements</a></li>
        <li><a href="#organise" data-toggle="tab">Que j'organise</a></li>
        <li><a href="#participe" data-toggle="tab">Auxquels je participe</a></li>
        <li><a href="#invite" data-toggle="tab">Auxquels je suis invité</a></li>
        <li><a href="#public" data-toggle="tab">Evenements publics</a></li>
        <li><a href="#passe" data-toggle="tab">Evenements passés</a></li>
        <?php if($userSuptypeId[$current_user] == "4"){ ?>
        <li><a href="#prestataire" data-toggle="tab">Prestations pour ces évenements</a></li>
        <?php } ?>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tous">
            <table  class="table table-striped table_index">
                <?php
                if (isset($events)) {
                    foreach ($events as $event):
                        ?>
                        <tr>
                            <td >
                                <?php
                                $dateFin = date_create_from_format('d/m/Y H:i', $event['Event']['endday'] . ' ' . $event['Event']['endtime']);
                                $dateFin = $dateFin->format('d/m/Y H:i');
                                if ($dateFin > date('d/m/Y H:m')) {
                                    echo $this->Html->link($event['Event']['title'], array('action' => 'view', $event['Event']['id']));
                                } else {

                                    echo $this->Html->link($event['Event']['title'], array('action' => 'view', $event['Event']['id']), array('class' => 'text-error'));
                                }
                                ?>

                            </td>
                            <td>
                                <?php
                                $publicBool = TRUE;
                                foreach ($event['EventsUsers'] as $evUser):
                                    if ($evUser['user_id'] == $current_user) {
                                        echo $userType[$evUser['type_id']];
                                        $publicBool = FALSE;
                                    }
                                endforeach;
                                if ($publicBool == true) {
                                    echo "Evenement public";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $event['Event']['startday'];
                                ?>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                }
                ?>
            </table>
        </div>
        <div class="tab-pane" id="organise">
            <table  class="table table-striped table_index">
                <?php
                if (isset($events)) {
                    $eventsCreated = array();
                    foreach ($events as $event):
                        foreach ($event['EventsUsers'] as $evUser):
                            if ($evUser['user_id'] == $current_user) {
                                if ($evUser['type_id'] == 1 || $evUser['type_id'] == 2) {
                                    array_push($eventsCreated, $event);
                                }
                            }
                        endforeach;
                    endforeach;
                    foreach ($eventsCreated as $eventCreated):
                        ?>

                        <tr>
                            <td >
                                <?php
                                $dateFin = date_create_from_format('d/m/Y H:i', $eventCreated['Event']['endday'] . ' ' . $eventCreated['Event']['endtime']);
                                $dateFin = $dateFin->format('d/m/Y H:i');
                                if ($dateFin > date('d/m/Y H:m')) {
                                    echo $this->Html->link($eventCreated['Event']['title'], array('action' => 'view', $eventCreated['Event']['id']));
                                } else {

                                    echo $this->Html->link($eventCreated['Event']['title'], array('action' => 'view', $eventCreated['Event']['id']), array('class' => 'text-error'));
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $event['Event']['startday'];
                                ?>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                }
                ?>
            </table>
        </div>
        <div class="tab-pane" id="participe">
            <table  class="table table-striped table_index">
                <?php
                if (isset($events)) {
                    $eventsParticpe = array();
                    foreach ($events as $event):
                        foreach ($event['EventsUsers'] as $evUser):
                            if ($evUser['user_id'] == $current_user) {
                                if ($evUser['type_id'] == 5) {
                                    array_push($eventsParticpe, $event);
                                }
                            }
                        endforeach;
                    endforeach;
                    foreach ($eventsParticpe as $eventParticpe):
                        $dateFin = date_create_from_format('d/m/Y H:i', $eventParticpe['Event']['endday'] . ' ' . $eventParticpe['Event']['endtime']);
                        $dateFin = $dateFin->format('d/m/Y H:i');
                        if ($dateFin > date('d/m/Y H:m')) {
                            echo '<tr><td>';
                            echo $this->Html->link($eventParticpe['Event']['title'], array('action' => 'view', $eventParticpe['Event']['id']));
                            echo '</td>';
                            echo '<td>';
                            echo $eventParticpe['Event']['startday'];
                            echo '</td></tr>';
                        }

                    endforeach;
                }
                ?>
            </table>
        </div>
        <div class="tab-pane" id="invite">
            <table  class="table table-striped table_index">
                <?php
                if (isset($events)) {
                    $eventsInvite = array();
                    foreach ($events as $event):
                        foreach ($event['EventsUsers'] as $evUser):
                            if ($evUser['user_id'] == $current_user) {
                                if ($evUser['type_id'] == 3) {
                                    array_push($eventsInvite, $event);
                                }
                            }
                        endforeach;
                    endforeach;
                    foreach ($eventsInvite as $eventInvite):
                        $dateFin = date_create_from_format('d/m/Y H:i', $eventInvite['Event']['endday'] . ' ' . $eventInvite['Event']['endtime']);
                        $dateFin = $dateFin->format('d/m/Y H:i');
                        if ($dateFin > date('d/m/Y H:m')) {
                            echo '<tr><td>';
                            echo $this->Html->link($eventInvite['Event']['title'], array('action' => 'view', $eventInvite['Event']['id']));
                            echo '</td>';
                            echo '<td>';
                            echo $eventInvite['Event']['startday'];
                            echo '</td></tr>';
                        }
                    endforeach;
                }
                ?>
            </table>
        </div>
        <div class="tab-pane" id="public">
            <table  class="table table-striped table_index">
                <?php
                if (isset($events)) {
                    foreach ($events as $event):
                        ?>
                        <?php
                        $dateFin = date_create_from_format('d/m/Y H:i', $event['Event']['endday'] . ' ' . $event['Event']['endtime']);
                        $dateFin = $dateFin->format('d/m/Y H:i');
                        if ($dateFin < date('d/m/Y H:m') || $event['Event']['visibility'] == TRUE) {
                            echo '<tr><td>';
                            echo $this->Html->link($event['Event']['title'], array('action' => 'view', $event['Event']['id']));
                            echo '</td>';
                            echo '<td>';
                            echo $event['Event']['startday'];
                            echo '</td></tr>';
                        }
                    endforeach;
                }
                ?>
            </table>
        </div>
        <div class="tab-pane" id="passe">
            <table  class="table table-striped table_index">
                <?php
                if (isset($events)) {
                    foreach ($events as $event):
                        $dateFin = date_create_from_format('d/m/Y H:i', $event['Event']['endday'] . ' ' . $event['Event']['endtime']);
                        $dateFin = $dateFin->format('d/m/Y H:i');
                        if ($dateFin < date('d/m/Y H:m')) {
                            echo '<tr><td>';
                            echo $this->Html->link($event['Event']['title'], array('action' => 'view', $event['Event']['id']));
                            echo '</td>';
                            echo '<td>';
                            echo $event['Event']['startday'];
                            echo '</td></tr>';
                        }
                    endforeach;
                }
                ?>
            </table>
        </div>
             <div class="tab-pane" id="prestataire">
            <table  class="table table-striped table_index">
                <?php
                if (isset($events)) {
                    $eventsPresta = array();
                    foreach ($events as $event):
                        foreach ($event['EventsUsers'] as $evUser):
                            if ($evUser['user_id'] == $current_user) {
                                if ($evUser['type_id'] == 4) {
                                    array_push($eventsPresta, $event);
                                }
                            }
                        endforeach;
                    endforeach;
        foreach ($eventsPresta as $eventPresta):
                        ?>

                        <tr>
                            <td >
                                <?php
                                $dateFin = date_create_from_format('d/m/Y H:i', $eventPresta['Event']['endday'] . ' ' . $eventPresta['Event']['endtime']);
                                $dateFin = $dateFin->format('d/m/Y H:i');
                                if ($dateFin > date('d/m/Y H:m')) {
                                    echo $this->Html->link($eventPresta['Event']['title'], array('action' => 'view', $eventPresta['Event']['id']));
                                } else {

                                    echo $this->Html->link($eventPresta['Event']['title'], array('action' => 'view', $eventPresta['Event']['id']), array('class' => 'text-error'));
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $eventPresta['Event']['startday'];
                                ?>
                            </td>
                        </tr>
<?php
                    endforeach;
                }
                ?>
            </table>
        </div>
    </div>
</div>





