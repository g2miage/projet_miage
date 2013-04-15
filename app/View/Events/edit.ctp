
<h1>Modifier l'événement</h1>
<?php
echo $this->Form->create('Event');
echo $this->Form->input('title', array('label' => 'Titre'));
echo $this->Form->input('desc', array('label' => 'Description','rows' => '3'));
echo $this->Form->input('startday', array('date', 'label' => 'Date de début'));
echo $this->Form->input('starttime', array('label' => 'Heure de début'));
echo $this->Form->input('endday', array('label' => 'Date de fin'));
echo $this->Form->input('endtime', array('label' => 'Heure de fin'));
echo $this->Form->input('address', array('label' => 'Adresse'));
echo $this->Form->input('zip', array('label' => 'Code postal'));
echo $this->Form->input('city', array('label' => 'Ville'));
echo $this->Form->input('amount', array('label' => 'Prix d\'entrée'));
echo 'Cochez si l\'événement est privé : '.$this->Form->checkbox('visibility').'</br></br>';

echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Enregistrer');
?>