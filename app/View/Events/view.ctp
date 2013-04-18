<!-- File: /app/View/Events/index.ctp  (edit links added) -->
<?php
$this->Html->script('http://maps.google.com/maps/api/js?sensor=true', false);
$full_address = $event['address'] . " " . $event['zip'] . " " . $event['city'];

$map_options = array(
    'id' => 'map_canvas',
    'class' => 'event_map',
    'width' => '450px',
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
        <h1 class='title_event'><?php echo $event['title']; ?></h1>
        <?php
        $boolOrganisateur = 0;
        foreach ($organisateurs as $organisateur) {
            if ($organisateur['User']['id'] == $current_user) {
                $boolOrganisateur = 1;
            }
        }

        if ($current_user == $createur['id'] || $boolOrganisateur == 1) {
            echo $this->Html->link("Modifier l'événement", array('action' => 'edit', $event['id']), array('class' => 'btn btn-info pull-right'));
            echo $this->Html->link("Inviter un ami ", array('action' => 'addorganisateur', $event['id']), array('class' => 'btn btn-info pull-right'));
        } else {
            $btnInscription = 0;
            foreach ($invites as $invite) {
                if ($current_user == $invite['User']['id']) {
                    echo $this->Html->link("S'inscrire", array('action' => 'participate', $event['id']), array('class' => 'btn btn-success pull-right'));
                    $btnInscription = 1;
                }
            }
            $btnParticipant = 0;
            foreach ($participants as $participant) {
                if ($current_user == $participant['User']['id']) {
                    echo $this->Html->link("Se désinscrire", array('action' => 'refuse', $event['id']), array('class' => 'btn btn-warning pull-right'));
                    $btnParticipant = 1;
                }
            }


            if ($event['visibility'] == 0 && $btnInscription == 0 && $btnParticipant == 0) {
                echo $this->Html->link("S'inscrire", array('action' => 'participate', $event['id']), array('class' => 'btn btn-large btn-success pull-right'));
            }
        }
        ?>      
    </div>


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
        if (!empty($event['picture'])) {
            echo "<tr><td></td><td>" . $this->Html->image($event['picture'], array('alt' => ':/')) . "</td></tr>";
        }
        ?>

        <tr>
            <td><i class="icon-align-justify"></i></td>
            <td>
                <div class="row">
                    <div class="span7">
                        <?php echo nl2br($event['desc']); ?>
                    </div>
                    <div class="span2">
                        <?php
                        echo $this->GoogleMap->map($map_options);
                        ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <table class="event_view">
        <h3><i class="icon-user"></i> Organisateurs</h3>
        <ul>
            <?php
            foreach ($organisateurs as $organisateur) {
                echo "<li>" . $organisateur['User']['username'] . "</li>";
            }
            ?>
        </ul>

        <h3><i class="icon-user"></i> Invités</h3>
        <ul>
            <?php
            foreach ($invites as $invite) {
                echo "<li>" . $invite['User']['username'] . "</li>";
            }
            ?>
        </ul>
        <h3><i class="icon-user"></i> Participants</h3>
        <ul>
            <?php
            foreach ($participants as $participant) {
                echo "<li>" . $participant['User']['username'] . "</li>";
            }
            ?>
        </ul>
    </table>
    <br />
    <br />

    <?php
    if ($current_user == $createur['id'] || $boolOrganisateur == 1) {
// Erwann et Paul upload fichier ---------------------------------------------

        echo $this->html->link('Fichier template', '/csv/template.csv', array('class' => 'btn'));

// Création du formulaire d'upload d'invités
        echo $this->form->create('Event', array('type' => 'file', 'url' => 'addfile/'.$event['id']));
        echo $this->form->input('', array('type' => 'file'));
        echo $this->form->end('Sauvegarder le fichier');
    }
    ?>

    <br />
    <?php
    echo $this->Html->link("Retourner à la liste des événements", array('action' => 'index'), array('class' => 'btn btn-info', 'escape' => false));
    ?>
</div>