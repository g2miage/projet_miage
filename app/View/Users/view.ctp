<?php
$this->Html->script('http://maps.google.com/maps/api/js?sensor=true', false);
$full_address = $supplier['User']['address'] . " " . $supplier['User']['zip'] . " " . $supplier['User']['city'];

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
    'markerIcon' => 'http://' . $_SERVER['SERVER_NAME'] . '/projet_miage/img/suptypes/' . $supplier['Suptype']['stype'] . '.png',
    'markerShadow' => 'http://google-maps-icons.googlecode.com/files/shadow.png',
    'infoWindow' => true,
    'windowText' => "<b>" . $supplier['User']['scorpname'] . "</b><br /><p>$full_address</p>"
);
?>

<div class="well">
    <h1><?php echo $supplier['User']['scorpname']; ?> <small><?= $supplier['Suptype']['stype']; ?></small></h1>

    <div class="row">
        <div class="span6">
            <?php
            if (file_exists($supplier['User']['picture'])) {
                $url = substr($supplier['User']['picture'], 4);
                echo "<tr><td></td><td>" . $this->Html->image($url, array('alt' => 'fonctionnement', 'class' => 'img-event img-rounded')) . '</td></tr>';
            } else {

                echo "<tr><td></td><td>" . $this->Html->image('user/defaultUser.png', array('alt' => 'fonctionnement', 'class' => 'img-event img-rounded')) . '</td></tr>';
            }
            ?>
        </div>
        <div class="span4 offset1">
            <table class="event_view">
                <tr>
                    <td>

                        <address>
                            <?= '<strong>' . $supplier['User']['scorpname'] . '</strong><br/>' ?>
                            <?php 
                            if ($supplier['User']['tel'] != ""){
                            echo 'Tel : '.$supplier['User']['tel'] . '<br />';
                            }
                            ?>
                            <?= $supplier['User']['address'] . '<br />' ?>
                            <?= $supplier['User']['zip'] ?>
                            <?= $supplier['User']['city'] . '<br />' ?>
                            <?= $supplier['User']['country'] . '<br /><br />' ?>
                        </address>
                    </td>

                </tr>
            </table>
        </div>
    </div>
</div>



<h2><?php echo $supplier['User']['firstname'] . ' ' . $supplier['User']['lastname'] ?> </h2>

<br />
<div class="span6">
    <?php
    if (isset($noteMoyenne)) {
        echo 'Note : ' . $noteMoyenne . '  ';
        for ($i = 1; $i <= round($noteMoyenne); $i++) {
            echo '<i class="icon-star"></i></td>';
        }
    }
    ?>
</div>
<div class="span3 offset1">
<?php
if ($canRate) {


    echo $this->Form->create('Supplierratings', array('action' => 'rate', 'controller' => 'supplierratings',
        'inputDefaults' => array(
            'fieldset' => false,
            'legend' => false
    )));
    echo $this->Form->hidden('supplier_id', array('value' => $supplier['User']['id']));
    echo $this->Form->hidden('scorpname', array('value' => $supplier['User']['scorpname']));
    echo "<fieldset class='rating'>";
    $options = array(
        5 => '5',
        4 => '4',
        3 => '3',
        2 => '2',
        1 => '1'
    );

    if (isset($note)) {
        echo $this->Form->input('rating', array('type' => 'radio', 'options' => $options, 'value' => $note, 'onclick' => 'this.form.submit()', 'div' => false));
    } else {
        echo $this->Form->input('rating', array('type' => 'radio', 'options' => $options, 'onclick' => 'this.form.submit()', 'div' => false));
    }
    echo '</fieldset>';
    echo $this->Form->end();
}
?>
</div>
<div class="row">
    <div class="span6">
        <h4>Description</h4>
<?= "<p class='text-justify'>" . nl2br($supplier['User']['sdesc']) . "</p>"; ?>
    </div>
    <div class="span5 offset1">
        <?= $this->GoogleMap->map($map_options); ?>
        <br />

    </div>
</div>
    <hr />
<?php echo $this->Html->link("Retourner à la liste des prestataires", array('action' => 'suppliers'), array('class' => 'btn btn-info', 'escape' => false)); ?>
