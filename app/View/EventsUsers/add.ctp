<h1>Création d'événement</h1>
<?php

echo $this->Form->create('EventsUser');
echo $this->Form->input('Event.title', array('label' => 'Titre'));
echo $this->Form->input('Event.desc', array('label' => 'Description','rows' => '3'));
echo $this->Form->input('Event.start', array('date', 'label' => 'Date de début'));
echo $this->Form->input('Event.end', array('label' => 'Date de fin'));
echo $this->Form->input('Event.address', array('label' => 'Adresse'));
echo $this->Form->input('Event.zip', array('label' => 'Code postal'));
echo $this->Form->input('Event.city', array('label' => 'Ville'));
echo $this->Form->input('Event.amount', array('label' => 'Prix d\'entrée'));
echo $this->Form->input('EventsUser.pot', array('label' => 'Pot'));
echo 'Cochez si l\'événement est privé : '.$this->Form->checkbox('Event.visibility').'</br></br>';
echo $this->Form->button('Event.Reset', array('type'=>'reset'));


echo $this->Form->end('Enregistrer');

?>