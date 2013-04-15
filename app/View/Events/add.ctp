

<h1>Création d'événement</h1>
<?php
echo $this->Form->create('Event', array('type' => 'file'));
echo $this->Form->input('title', array('label' => 'Titre'));
//echo $this->Form->input('desc', array('label' => 'Description','rows' => '3'));
echo $this->Tinymce->input('Event.desc',array('label' => 'Description'),'','simple'); 
    
echo $this->Form->input('startday', array('date', 'label' => 'Date de début'));
echo $this->Form->input('starttime', array('label' => 'Heure de début'));
echo $this->Form->input('endday', array('label' => 'Date de fin'));
echo $this->Form->input('endtime', array('label' => 'Heure de fin'));
echo $this->Form->input('address', array('label' => 'Adresse'));
echo $this->Form->input('zip', array('label' => 'Code postal'));
echo $this->Form->input('city', array('label' => 'Ville'));
echo $this->Form->input('amount', array('label' => 'Prix d\'entrée'));
echo 'Cochez si l\'événement est privé : '.$this->Form->checkbox('visibility');
echo $this->Form->input('picture', array('type' => 'file', 'label' => 'Image du profil (taille maximum 2Mo)'));
echo '<br /><br />';
echo $this->Form->button('Reset', array('type'=>'reset'));
echo $this->Form->end('Enregistrer');
?>

