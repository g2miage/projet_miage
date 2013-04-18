<?php

$this->set('title_for_layout', 'Editer mon profil');
echo $this->HTML->Link('Modifier mon mot de passe', array('action' => 'editpassword'));
echo $this->Form->create('User');
echo $this->Form->Label('Sexe');
$options = array('M' => 'M', 'F' => 'F');
$attributes = array(
    'legend' => false
);
echo $this->Form->radio('sex', $options, $attributes);
echo $this->Form->input('firstname', array('label' => 'Prenom'));
echo $this->Form->input('lastname', array('label' => 'Nom'));
echo $this->Form->input('mail', array('label' => 'Email'));
echo $this->Form->input('tel', array('label' => 'Tel.'));
echo $this->Form->input('address', array('label' => 'Adresse'));
echo $this->Form->input('zip', array('label' => 'Code postal'));
echo $this->Form->input('city', array('label' => 'Ville'));
echo $this->Form->input('country', array('label' => 'Pays'));
echo $this->Form->hidden('formUser', array('value' => true));

if($this->data['User']['suptype_id']!=0){
echo $this->Form->input('suptype_id', array('options'=>array($stype),'label'=>'Type d\'activité'));

echo $this->Form->input('scorpname', array('label' => 'Raison sociale'));
echo $this->Form->input('ssiret', array('label' => 'Siret'));
echo $this->Form->input('sdesc', array('label' => 'Description'));
echo $this->Form->input('website', array('label' => 'Site web'));
}
else
{
echo $this->Form->input('role_id', array('label' => 'Prestataire', 'type' => 'checkbox','onclick'=>'WhenChecked()'));

echo "<div id='prestat' style='visibility: hidden' >";
echo $this->Form->input('scorpname', array('label' => 'Raison Sociale :'));
echo $this->Form->input('ssiret', array('label' => 'SIRET :'));
echo $this->Form->input('suptype_id', array('options'=>array($stype)));
echo $this->Form->input('sdesc', array('label' => 'Type d\'activité'));
echo "</div>";
}
echo $this->Form->end(array('label' => 'Modifier', 'class' => 'btn btn-primary', 'div' => false));