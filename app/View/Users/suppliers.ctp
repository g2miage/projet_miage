<?php
echo $this->Html->script('geo');
$this->Html->script('http://maps.google.com/maps/api/js?sensor=true', false);

// si recherche alors localize passe a false et on met l'adresse du département dans address
// sinon, localize a true et address laissé vide
$localize = true;
$default_address = 'France';
if (!empty($search_dept)) {
    $localize = false;
    $default_address = $search_dept;
}

if ($localize) {
    $map_options = array(
        'width' => '600px',
        'height' => '550px',
        'style' => 'box-shadow: 0px 3px 5px #8F8F8F',
        'zoom' => 8,
        'type' => 'ROADMAP',
        'localize' => true,
        'marker' => false);
} else {
    $map_options = array(
        'width' => '600px',
        'height' => '550px',
        'style' => 'box-shadow: 0px 3px 5px #8F8F8F',
        'zoom' => 8,
        'type' => 'ROADMAP',
        'localize' => false,
        'address' => $default_address,
        'marker' => false);
}
?>

<h1>Liste des prestataires</h1>

<div id="maposition"></div>

<?php
echo $this->Form->create("User", array('action' => 'suppliers', 'div' => false));
echo "<ul class='inline'>
<li>" . $this->Form->input('suptype_id', array('options' => array($stype), 'empty' => 'type de prestataire', 'div' => false, 'label' => '')) . "</li>
<li>" . $this->Form->input('dept', array('options' => array($depts), 'empty' => 'département', 'div' => false, 'label' => '')) . "</li>
<li>" . $this->Form->end(array('label' => "Rechercher", 'class' => 'btn btn-primary btn_align', 'div' => false)) . "</li>
</ul>";
?>

<div class="row">
    <div class="span5">
        <?php
        if (!isset($suppliers) || is_null($suppliers)) {
            echo "<p class='alert alert-error'>Aucun prestataire ne correspond à votre recherche</p>";
        } else {
            ?>
            <table  class="table table-striped table_index">
                <tr>
                    <th>Prestataire</th>
                    <th>Type</th>
                    <?php
                    if (!empty($listevent)) {
                        ?>

                        <th>Ajouter à un événement</th>
                        <?php
                    }
                    ?>
                </tr>

                <?php
                $i = 0;
                $j = 0;
                foreach ($suppliers as $supplier):
                    $i++;
                    ?>

                    <tr>
                        <td >
                            <?php echo $this->Html->link($supplier['User']['scorpname'], array('action' => 'view', $supplier['User']['id'])); ?>
                        </td>
                        <td>
                            <?php echo $this->Html->link($supplier['Suptype']['stype'], array('action' => 'view', $supplier['User']['id'])); ?>
                        </td>
                        <?php
                        if (!empty($listevent)) {
                            ?>
                            <td>
                                
                                <?php
                                    if(isset($eventId)) {
                                        echo $this->Html->Link('Inviter',array('action' => 'addsupplier', 'controller' => 'eventsUsers',$eventId, $supplier['User']['id']),array('class'=> 'btn btn-primary'));
                                    } else {
                                ?>
                                <a href='#myModal<?= $i ?>' role='button' class='btn btn-primary' data-toggle='modal'>Inviter</a>
                                <div id="myModal<?= $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 id="myModalLabel">A quel événement souhaitez vous ajouter ce prestataire ? </h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                            echo '<h5>Coordonnées : </h5>';
                                            echo '<address>';
                                            echo $supplier['User']['scorpname'].'<br/>';
                                            echo $supplier['User']['address'].'<br/>';
                                            echo $supplier['User']['zip'].' '.$supplier['User']['city'].'<br/>';
                                            echo 'Tel : '.$supplier['User']['tel'].'<br/>';
                                            echo '</address>';
                                        ?>
                                        <div class="accordion" id="accordion<?= $i ?>">
                                            <!--table  class="table table-striped table_index">
                                                <tr>
                                                    <th>Evénements</th>
                                                    <th>Ajouter</th>
                                                </tr-->

                                            <?php
                                            foreach ($listevent as $event) {
                                                $j++;
                                                ?>

                                                <div class="accordion-group">
                                                    <div class="accordion-heading">
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?= $i ?>" href="#collapse<?= $j ?>">
                                                            <?= $event['Event']['title'] ?>
                                                        </a>
                                                    </div>
                                                    <div id="collapse<?= $j ?>" class="accordion-body collapse">
                                                        <div class="accordion-inner">
                                                            <?php
                                                            echo $this->Html->link('Aller à la fiche de l\'évènement', array('action' => 'view', 'controller' => 'events', $event['Event']['id'])).'<br/>';
                                                            foreach ($supplierevent as $supEvent) {
                                                                $trouve = false;
                                                                if ($supEvent['EventsUsers']['event_id'] == $event['Event']['id'] && $supEvent['EventsUsers']['user_id'] == $supplier['User']['id']) {
                                                                    $trouve = true;
                                                                    break;
                                                                }
                                                            }
                                                            if (!isset($trouve) || !$trouve) {
                                                                echo $this->Form->create(null, array('url' => array('controller' => 'eventsUsers', 'action' => 'addsupplier')));
                                                                echo $this->Form->checkbox('avertirTel').' Contact par téléphone<br/>';
                                                                echo $this->Form->checkbox('avertirMail').' Contact par mail<br/>';
                                                                echo $this->Form->label('message', 'Message (précisez votre demande au prestataire) :');
                                                                echo $this->Form->textarea('message', array('label' => 'Message (précisez votre demande au prestataire) :', 'rows' => '5', 'cols' => '15'));
                                                                echo $this->Form->hidden('event_id', array('value' => $event['Event']['id']));
                                                                echo $this->Form->hidden('user_id', array('value' => $supplier['User']['id']));
                                                                echo $this->Form->end(array('label' => 'Confirmer', 'class' => 'btn btn-primary'));
                                                            } else {
                                                                echo "Déjà ajouté";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>                   
                                                <?php
                                                /* */
                                            }
                                            ?>
                                        </div>

                                        <!--/table-->
                                    </div>
                                    <div class="modal-footer">
                                        <!--button class="btn" data-dismiss="modal" aria-hidden="true">Close</button-->
                                    </div>
                                </div>
                                    <?php } ?>
                            </td>
                            <?php
                        }
                        ?>

                    </tr>
                    <?php
                endforeach;
            }
            ?>

        </table>
    </div>
    <div class="span2">
        <?php
        echo $this->GoogleMap->map($map_options);
// s'il y a des suppliers, on affiche un marqueur pour chacun d'eux
        if (isset($suppliers)) {
            foreach ($suppliers as $supplier):
                $supp_addr = addslashes($supplier['User']['address'] . " " . $supplier['User']['zip'] . " " . $supplier['User']['city']);

                // définition du marqueur pour chaque supplier
                $marker_options = array(
                    'showWindow' => false,
                    'windowText' => "Hooe",
                    'markerTitle' => 'Title',
                    'markerIcon' => 'http://' . $_SERVER['SERVER_NAME'] . '/projet_miage/img/suptypes/' . $supplier['Suptype']['stype'] . '.png',
                    'markerShadow' => 'http://labs.google.com/ridefinder/images/mm_20_purpleshadow.png',
                );
                echo $this->GoogleMap->addMarker("map_canvas", 1, "$supp_addr", $marker_options);
            endforeach;
        }
        ?>
    </div>
</div>

