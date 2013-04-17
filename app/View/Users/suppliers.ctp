<?php
$this->Html->script('http://maps.google.com/maps/api/js?sensor=true', false);

// si recherche alors localize passe a false et on met l'adresse du département dans address
// sinon, localize a true et address laissé vide
$localize = true;
$default_address = 'France';
if(!empty($search_dept)){
    $localize = false;
    $default_address = $search_dept;
}
if($localize){
	$map_options = array(
		'width' => '600px',
		'height' => '550px',
		'style' => 'box-shadow: 0px 3px 5px #8F8F8F',
		'zoom' => 8,
		'type' => 'ROADMAP',
		'localize' => true,
		'marker' => false
	);
}else{
	$map_options = array(
		'width' => '600px',
		'height' => '550px',
		'style' => 'box-shadow: 0px 3px 5px #8F8F8F',
		'zoom' => 8,
		'type' => 'ROADMAP',
		'localize' => false,
		'address' => $default_address,
		'marker' => false
	);
}
$marker_options = array(
    'showWindow' => false,
    'windowText' => "Hooe",
    'markerTitle' => 'Title',
    'markerIcon' => 'http://labs.google.com/ridefinder/images/mm_20_purple.png',
    'markerShadow' => 'http://labs.google.com/ridefinder/images/mm_20_purpleshadow.png',
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
			// s'il y a des suppliers, on affiche un marqueur pour chacun d'eux
            if(isset($suppliers)){
				foreach ($suppliers as $supplier):
					$supp_addr = $supplier['User']['address']." ".$supplier['User']['zip']." ".$supplier['User']['city'];
					echo $this->GoogleMap->addMarker("map_canvas", 1,"$supp_addr",$marker_options);
				endforeach;
			}
        ?>
    </div>
</div>
