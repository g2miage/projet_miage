<?php
$this->Html->script('http://maps.google.com/maps/api/js?sensor=true', false);

// si recherche alors localize passe a false et on met l'adresse du département dans address
// sinon, localize a true et address laissé vide
$localize = true;
$default_address = "france";
if(isset($search_dept) && !empty($search_dept)){
    $localize = false;
    $default_address = $search_dept;
}

$map_options = array(
    'width' => '600px',
    'height' => '550px',
    'style' => 'box-shadow: 0px 3px 5px #8F8F8F',
    'zoom' => 8,
    'type' => 'ROADMAP',
    'localize' => $localize,
    'address' => $default_address,
    'marker' => false
);

?>


<h1>Liste des prestataires</h1>

<?php 
echo $this->Form->create("User",array('action' => 'suppliers', 'div'=>false)); 
echo "<ul class='inline'>
        <li>".$this->Form->input('suptype_id', array('options'=>array($stype),'empty'=>'type de prestataire','div'=>false,'label' => ''))."</li>
        <li>".$this->Form->input('dept', array('options'=>array($depts),'empty'=>'département','div'=>false,'label' => ''))."</li>
        <li>".$this->Form->end( array('label' =>"Rechercher", 'class'=>'btn btn-primary btn_align', 'div'=>false))."</li>
</ul>";?>

<div class="row">
    <div class="span5">
        <?php
                    if(!isset($suppliers) || is_null($suppliers)){
                echo "<p class='alert alert-error'>Aucun prestataire ne correspond à votre recherche</p>";
            }else{ ?>
        <table  class="table table-striped table_index">
            <tr>
                <th>Prestataire</th>
                <th>Type</th>
            </tr>
            
        <?php 
            foreach ($suppliers as $supplier):  
          ?>
                
            <tr>
                <td >
                    <?php echo $this->Html->link($supplier['User']['scorpname'], array('action' => 'view', $supplier['User']['id'])); ?>
                </td>
                <td>
                      <?php echo $this->Html->link($supplier['Suptype']['stype'], array('action' => 'view', $supplier['User']['id'])); ?>
                </td>

            </tr>
        <?php endforeach;} ?>

        </table>
    </div>
    <div class="span2">
        <?php
            echo $this->GoogleMap->map($map_options);
            
            foreach ($suppliers as $supplier):
                echo $this->GoogleMap->addMarker("map_canvas", 1,$supplier['User']['address']." ".$supplier['User']['zip']." ".$supplier['User']['city'] ." ".$supplier['User']['country']);
            endforeach;
        ?>
    </div>
</div>
