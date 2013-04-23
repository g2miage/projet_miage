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
    <!--<li><?php //echo $this->Form->input("searchEventTitle", array('label' => '', 'div'=>false,'data-provide' => 'typeahead','data-source'=> '','escape'=>false));       ?> </li>-->
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
                                <?php echo $this->Html->link($event['Event']['title'], array('action' => 'view', $event['Event']['id'])); ?>
                            </td>
                            <td class="actions">

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
                                <?php echo $this->Html->link($eventCreated['Event']['title'], array('action' => 'view', $eventCreated['Event']['id'])); ?>
                            </td>
                            <td class="actions">

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
                        ?>

                        <tr>
                            <td >
                                <?php echo $this->Html->link($eventParticpe['Event']['title'], array('action' => 'view', $eventParticpe['Event']['id'])); ?>
                            </td>
                            <td class="actions">

                            </td>

                        </tr>
                        <?php
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
                        ?>

                        <tr>
                            <td >
                                <?php echo $this->Html->link($eventInvite['Event']['title'], array('action' => 'view', $eventInvite['Event']['id'])); ?>
                            </td>
                            <td class="actions">

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





