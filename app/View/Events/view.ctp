<!-- File: /app/View/Events/index.ctp  (edit links added) -->
<?php
$this->Html->script('http://maps.google.com/maps/api/js?sensor=true', false);
$full_address = $event['address'] . " " . $event['zip'] . " " . $event['city'];

$map_options = array(
    'id' => 'map_canvas',
    'class' => 'event_map',
    'width' => 'inherit',
    'height' => '400px',
    'style' => 'box-shadow: 0px 3px 5px #8F8F8F',
    'zoom' => 10,
    'type' => 'ROADMAP',
    'custom' => null,
    'localize' => false,
    'address' => $full_address,
    'marker' => true,
    'markerTitle' => 'This is my position',
    'markerIcon' => 'http://google-maps-icons.googlecode.com/files/home.png',
    'markerShadow' => 'http://google-maps-icons.googlecode.com/files/shadow.png',
    'infoWindow' => true,
    'windowText' => "<b>" . $event['title'] . "</b><br /><p>$full_address</p>"
);
?>
<div class="event">
    <div class='padding'>
        <div class='well'>
            <div class="row">
                <div class="span6">
                    <?php
                    if (!empty($event['picture'])) {
                        echo "<tr><td></td><td>" . $this->Html->image($event['picture'], array('alt' => ':/', 'class' => 'img-event img-rounded')) . "</td></tr>";
                    }
                    ?>
                </div>
                <div class="span4 offset1">
                    <table class="event_view">
                        <tr>
                            <td>
                                <?php
                                echo "<i class='icon-globe'></i></td><td>
                                <p>" . $typename . "</p>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if ($event['visibility'] == 0) {
                                    echo "<i class='icon-globe'></i></td><td>
                                <p>Public . Créé par : " . $createur['username'] . "</p>";
                                } else {
                                    echo "<i class='icon-group'></i></td><td>
                                <p>Privé . Créé par : " . $createur['username'] . "</p>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="icon-time"></i></td>
                            <td>
                                <?php
                                if ($event['startday'] == $event['endday']) {
                                    echo "
                                Le <b>" . $event['startday'] . "</b> 
                                de <b><span class='text-success'>" . $event['starttime'] . "</span></b> 
                                à <b><span class='text-error'>" . $event['endtime'] . "</span></b></p>";
                                } else {
                                    echo " Commence le <b>" . $event['startday'] . "</b> 
                                à partir de <b><span class='text-success'>" . $event['starttime'] . "</span></b> 
                                et se termine le <b>" . $event['endday'] . "</b> le 
                                à <b><span class='text-error'>" . $event['endtime'] . "</span></b>.</p>";
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        if ($noteMoyenne != 0) {
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    for ($i = 1; $i <= round($noteMoyenne); $i++) {
                                        echo '<i class="icon-star"></i>';
                                    }
                                    echo '</td>';
                                    echo ' <td>Note de l\'événement : ' . $noteMoyenne . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                    </table>
                </div>
            </div>
        </div>
        <br />
        <h1 class='title_event'><?php echo $event['title']; ?></h1>



        <?php
        $boolOrganisateur = 0;
        $boolEstPasse = 0;
        $dateFin = date_create_from_format('d/m/Y H:i', $event['endday'] . ' ' . $event['endtime']);
        $nowDate = date_create_from_format('d/m/Y H:i', date('d/m/Y H:m'));
        if ($dateFin < $nowDate) {
            $boolEstPasse = 1;
        }
        foreach ($organisateurs as $organisateur) {
            if ($organisateur['User']['id'] == $current_user) {
                $boolOrganisateur = 1;
            }
        }

        $boolPrestataire = 0;
        foreach ($prestataires as $prestataire) {
            if ($prestataire['User']['id'] == $current_user) {
                $boolPrestataire = 1;
            }
        }

        if ($current_user == $createur['id'] || $boolOrganisateur == 1 && $boolEstPasse == 0) {
            echo $this->Html->link("Modifier l'événement", array('action' => 'edit', $event['id']), array('class' => 'btn btn-info pull-right'));
            echo $this->Html->link("Ajouter un prestataire", array('controller' => 'Users', 'action' => 'suppliers', $event['id']), array('class' => 'btn btn-info pull-right'));
            echo $this->Html->link("Inviter un ami ", array('action' => 'addorganisateur', $event['id']), array('class' => 'btn btn-info pull-right'));
        } elseif ($boolPrestataire == 1) {
            echo $this->Html->link("Discuter avec les organisateurs", array('action' => 'index', $event['id'], 'controller' => 'Messages'), array('class' => 'btn btn-info pull-right'));
        } else {
            $btnInscription = 0;
            foreach ($invites as $invite) {
                if ($current_user == $invite['User']['id'] && $boolEstPasse == 0) {
                    echo $this->Html->link("S'inscrire", array('action' => 'participate', $event['id']), array('class' => 'btn btn-success pull-right'));
                    $btnInscription = 1;
                }
            }
            $btnParticipant = 0;
            foreach ($participants as $participant) {
                if ($current_user == $participant['User']['id'] && $boolEstPasse == 0) {
                    echo $this->Html->link("Se désinscrire", array('action' => 'refuse', $event['id']), array('class' => 'btn btn-warning pull-right'));
                    $btnParticipant = 1;
                } elseif ($current_user == $participant['User']['id'] && $boolEstPasse == 1) {
                    echo '<div class="pull-right">';
                    echo '  Noter l\'événement :</br> ';
                    echo $this->Form->create('EventsUser', array('action' => 'rateEvent', 'controller' => 'eventsUsers',
                        'inputDefaults' => array(
                            'fieldset' => false,
                            'legend' => false
                    )));
                    echo $this->Form->hidden('event_id', array('value' => $event['id']));
                    echo "<fieldset class='rating'>";
                    $options = array(
                        5 => '5',
                        4 => '4',
                        3 => '3',
                        2 => '2',
                        1 => '1'
                    );
                    echo $this->Form->input('rating', array('type' => 'radio', 'options' => $options, 'value' => $note, 'onclick' => 'this.form.submit()', 'div' => false));
                    echo '</fieldset>';
                    echo $this->Form->end();
                    echo '</div>';
                }
            }
            if ($event['visibility'] == 0 && $btnInscription == 0 && $btnParticipant == 0 && $boolEstPasse == 0) {
                echo $this->Html->link("S'inscrire", array('action' => 'participate', $event['id']), array('class' => 'btn btn-large btn-success pull-right'));
            }
        }
        ?>      
    </div>

    <div class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Description</a></li>
            <?php
            if ($boolPrestataire != 1) {
                echo '<li><a href="#tab2" data-toggle="tab">Organisateurs & Invités</a></li>';
                echo '<li><a href="#tab3" data-toggle="tab">Discussions</a></li>';
            }
            if ($current_user == $createur['id'] || $boolOrganisateur == 1) {
                echo '<li><a href="#tab4" data-toggle="tab">Prestataires</a></li>';
            }
            ?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <div class="row">
                    <div class="span6">
                        <?php echo nl2br($event['desc']); ?>
                    </div>
                    <div class="span5 offset1">
                        <?php
                        echo $this->GoogleMap->map($map_options);
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <h3><i class="icon-user"></i> Organisateurs</h3>

                <table  class="table table-striped table_index">
                    <?php foreach ($organisateurs as $organisateur): ?>
                        <tr>
                            <td>
                                <?php echo $organisateur['User']['username']; ?>
                            </td>
                            <?php if ($current_user == $createur['id'] || $boolOrganisateur == 1 && $boolEstPasse == 0) { ?>
                                <td class="actions">
                                    <?php echo $this->Html->link('<i class="icon-user"> Invité</i>', array('action' => 'inviter', $organisateur['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right')); ?>
                                </td>
                                <td class="actions">
                                    <?php echo $this->Html->link('<i class="icon-user"> Participant&nbsp;&nbsp;&nbsp;</i>', array('action' => 'participant', $organisateur['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right')); ?>
                                </td>
                                <td class="actions">
                                    <?php echo $this->Html->link('<i class="icon-user"> Supprimer</i>', array('action' => 'delete', 'controller' => 'eventsUsers', $organisateur['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right')); ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>

                </table>  

                <h3><i class="icon-user"></i> Invités</h3>
                <table  class="table table-striped table_index">

                    <?php foreach ($invites as $invite): ?>
                        <tr>
                            <td>
                                <?php echo $invite['User']['username']; ?>
                            </td>
                            <?php if ($current_user == $createur['id'] || $boolOrganisateur == 1 && $boolEstPasse == 0) { ?>
                                <td class="actions">
                                    <?php echo $this->Html->link('<i class="icon-user"> Participant</i>', array('action' => 'participant', $invite['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right')); ?>
                                </td>
                                <td class="actions">
                                    <?php echo $this->Html->link('<i class="icon-user"> Organisateur</i>', array('action' => 'organisateur', $invite['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right')); ?>
                                </td>
                                <td class="actions">
                                    <?php echo $this->Html->link('<i class="icon-user"> Supprimer</i>', array('action' => 'delete', 'controller' => 'eventsUsers', $invite['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right')); ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                </table>  

                <h3><i class="icon-user"></i> Participants</h3>
                <table  class="table table-striped table_index">

                    <?php foreach ($participants as $participant): ?>
                        <tr>
                            <td>
                                <?php echo $participant['User']['username']; ?>
                            </td>
                            <?php if ($current_user == $createur['id'] || $boolOrganisateur == 1 && $boolEstPasse == 0) { ?>
                                <td class="actions">
                                    <?php echo $this->Html->link('<i class="icon-user"> Invité</i>', array('action' => 'inviter', $participant['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right')); ?>
                                </td>
                                <td class="actions">
                                    <?php echo $this->Html->link('<i class="icon-user"> Organisateur</i>', array('action' => 'organisateur', $participant['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right')); ?>
                                </td>

                                <td class="actions">
                                    <?php echo $this->Html->link('<i class="icon-user"> Supprimer</i>', array('action' => 'delete', 'controller' => 'eventsUsers', $participant['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right'));
                                    ?>
                                </td>
                            <?php } ?>

                        </tr>
                    <?php endforeach; ?>
                </table>  

                <br />
                <br />
                <div>
                    <!-- Ajout d'user pas csv -->    
                    <?php
                    if ($current_user == $createur['id'] || $boolOrganisateur == 1 && $boolEstPasse == 0) {
                        ?>
                        <h4>Ajouter des invités</h4>
                        <p> Vous pouvez aussi ajouter plusieurs invités en même temps à partir d'un fichier, voici la démarche à suivre :</p>
                        <ol>
                            <li>Télécharger le fichier modèle (en appuyant sur le bouton fichier template)</li>
                            <li>Remplissez-le en suivant le modèle</li>
                            <li>Uploader le fichier que vous avez rempli grâce au formulaire ci-dessous</li>
                            <li>Sauvegardez le fichier</li>
                        </ol>
                        <p>Si tout s'est bien passé, vous avez maintenant ajouté vos invités qui devraient apparaître ci-dessus \o/.</p>
                        <?php
                        echo $this->html->link('Fichier template', '/csv/template.csv', array('class' => 'btn'));

                        // Création du formulaire d'upload d'invités
                        echo $this->form->create('Event', array('type' => 'file', 'url' => 'addfile/' . $event['id']));
                        echo $this->form->input('', array('type' => 'file'));
                        echo $this->form->end('Sauvegarder le fichier');
                    }
                    ?>
                </div>
            </div>

            <div class="tab-pane" id="tab3">
                <?php
                if (!empty($messages) && $boolPrestataire != 1) {
                    foreach ($messages as $message) {
                        echo '<table class="table">';
                        echo $message['Message']['date'] . '  ' . $message['User']['username'];
                        echo '<tr class="success"><td>' . $message['Message']['message'] . '</td>';
                        if ($message['Message']['user_id'] == $current_user) {
                            echo '<td>';
                            echo $this->Html->link('<i class="icon-trash"></i>', array('action' => 'delete', 'controller' => 'messages', $message['Message']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right'));
                            echo '</td>';
                        }
                        echo '</tr>';
                        echo '</table>';
                    }
                } else {
                    echo 'Il n\'y a pas de messages pour le moment.';
                }
                // Création du formulaire de contact presta

                echo $this->Form->create('Message', array('action' => 'addMessageEvent', 'controller' => 'messages', 'div' => false));
                echo $this->Tinymce->input('Message.message', array('label' => ''), null, 'basic');
                echo $this->Form->input('Message.eventId', array('type' => 'hidden', 'value' => $event['id']));
                echo $this->Form->end(array('label' => 'Envoyer', 'class' => 'btn btn-primary'));
                ?>
            </div>

            <div class="tab-pane" id="tab4">

                <table  class="table table-striped table_index">
                    <?php foreach ($prestataires as $prestataire): ?>
                        <tr>
                            <td>
                                <?= $this->html->link($prestataire['User']['username'], array('action' => 'view', 'controller' => 'users', $prestataire['User']['id'])) ?>
                            </td>
                            <?php
                            if ($current_user == $createur['id'] || $boolOrganisateur == 1 && $boolEstPasse == 0) {
                                ?>
                                <td>
                                    <?= $this->html->link('<i class="icon-align-justify"> Voir la discussion</i>', array('action' => 'index', 'controller' => 'Messages', $event['id'], $prestataire['User']['id']), array('escape' => false, 'class' => 'pull-right')) ?>
                                </td>
                                <td>
                                    <?= $this->html->link('<i class="icon-trash"> Supprimer</i>', array('action' => 'delete', 'controller' => 'eventsUsers', $prestataire['User']['id'], $event['id']), array('escape' => false, 'class' => 'pull-right')) ?>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                    <?php endforeach; ?>

                </table>  

            </div>
        </div>
    </div>

    <br />
    <?php
    echo $this->Html->link("Retourner à la liste des événements", array('action' => 'index'), array('class' => 'btn btn-info', 'escape' => false));
    ?>
</div>