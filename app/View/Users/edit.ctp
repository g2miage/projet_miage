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
echo $this->Form->hidden('formUser', array('value' => true));
echo $this->Form->hidden('role_id');

if ($this->data['User']['suptype_id'] != 0) {
    echo $this->Form->input('address', array('label' => 'Adresse'));
    echo $this->Form->input('zip', array('label' => 'Code postal'));
    echo $this->Form->input('city', array('label' => 'Ville'));
    echo $this->Form->input('country', array('label' => 'Pays'));
    echo $this->Form->input('suptype_id', array('options' => array($stype), 'label' => 'Type d\'activité'));

    echo $this->Form->input('scorpname', array('label' => 'Raison sociale'));
    echo $this->Form->input('ssiret', array('label' => 'Siret'));
    echo $this->Tinymce->input('User.sdesc', array('label' => 'Description'),null, 'basic');
    echo $this->Form->input('website', array('label' => 'Site web'));
} else {
    echo $this->Form->input('address1', array('label' => 'Adresse', 'value' => $this->data['User']['address']));
    echo $this->Form->input('zip1', array('label' => 'Code postal'));
    echo $this->Form->input('city1', array('label' => 'Ville'));
    echo $this->Form->input('country1', array('label' => 'Pays'));
}

echo $this->Form->end(array('label' => 'Modifier', 'class' => 'btn btn-primary', 'div' => false));