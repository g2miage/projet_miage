
<div class='padding'><h1><?php echo $supplier['User']['scorpname'];?></h1>
</div>
<div class="container">

    <!-- Example row of columns -->
    <h2><?php echo $supplier['User']['firstname'].' '.$supplier['User']['lastname'] ?> </h2>
    <h5><?php echo 'Activité : '.$supplier['Suptype']['stype'] ; ?></h5>
<?php
     if(file_exists($supplier['User']['picture'])) {
        $url = substr($supplier['User']['picture'], 4);
        echo $this->Html->image($url, array('alt' => 'fonctionnement','class'=>'img-rounded')).'<br />'; 
     }  else {
        echo $this->Html->image('user/defaultUser.png', array('alt' => 'fonctionnement','class'=>'img-rounded')).'<br />'; 
     }
?>
<h4>Description :</h4>
    <?=$supplier['User']['sdesc']?>
<br /><br />
<h4>Adresse du prestataire :</h4>
<address>
    <?='<strong>'.$supplier['User']['scorpname'].'</strong><br/>'?>
    <?=$supplier['User']['address'].'<br />'?>
    <?=$supplier['User']['zip']?>
    <?=$supplier['User']['city'].'<br />'?>
    <?=$supplier['User']['country'].'<br /><br />'?>
</address>
<?php echo $this->Html->link("Retourner à la liste des prestataires", array('action' => 'suppliers'), array('class' => 'btn btn-info', 'escape' => false));?>
</div>