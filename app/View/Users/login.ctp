<?php 
    echo $this->Form->create('User', array('action' => 'login'));
    echo $this->Form->inputs(array(
        'legend' => __('Login'),
        'nom_user',
        'mot_de_passe'
    ));
    echo $this->Form->end('Connexion');
?>