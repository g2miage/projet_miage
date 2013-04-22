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
    <!--<li><?php //echo $this->Form->input("searchEventTitle", array('label' => '', 'div'=>false,'data-provide' => 'typeahead','data-source'=> '','escape'=>false));  ?> </li>-->
    <input name="data[Event][searchEventTitle]" id="searchEventTitle" type="text" data-provide="typeahead" data-source='<?php echo json_encode($titles); ?>'>
    <li><?php echo $this->Form->end(array('label' => "Rechercher", 'class' => 'btn btn-primary btn_align', 'div' => false)); ?></li>
    <li>
<?php echo $this->Html->link("Créer un événement", array('action' => 'add'), array('class' => 'btn btn-success   btn_align','div' => false)); ?>

</li>
</ul>

<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tous" data-toggle="tab">Tous mes événements</a></li>
    <li><a href="#organise" data-toggle="tab">Que j'organise</a></li>
    <li><a href="#participe" data-toggle="tab">Auxquels je participe</a></li>
    <li><a href="#participe" data-toggle="tab">Auxquels je suis invité</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tous">
        <table  class="table table-striped table_index">
            <tr>
                <th>Nom de l'événement</th>
                <th></th>
            </tr>
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
            <?php endforeach;
        }
        ?>
        </table>
    </div>
    <div class="tab-pane" id="organise">
      <p>Howdy, I'm in Section 2.</p>
    </div>
    <div class="tab-pane" id="participe">
      <p>plop</p>
    </div>
    <div class="tab-pane" id="invite">
      <p>invite</p>
    </div>
  </div>
</div>





