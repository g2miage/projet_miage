<?php

    $this->set('title_for_layout', 'Changer le mot de passe');

    echo $this->Form->create('User');
    echo $this->Form->input('password1', array('label' => 'Mot de passe actuel', 'type' => 'password', 'required' => 'required', 'message' => 'Obligatoire'));

    echo $this->Form->input('password', array('label' => 'Mot de passe', 'type' => 'password', 'required' => 'required', 'message' => 'Obligatoire'));
    echo $this->Form->input('password_confirm', array('label' => 'Confirmation Mot de passe :', 'type' => 'password', 'required' => 'required'));
    echo $this->Form->end(array('label' => 'Modifier', 'class' => 'btn btn-primary', 'div' => false));
?>