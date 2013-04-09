<h2>S'enregistrer</h2>
<?php
    echo $this->Form->create('User');
    echo $this->Form->input('username', array('label' => 'Login :'));
    echo $this->Form->input('mail', array('label' => 'Email :'));
    echo $this->Form->input('password', array('label' => 'Mot de passe :'));
    echo $this->Form->input('password_confirm', array('label' => 'Confirmation Mot de passe :', 'type' => 'password'));
    echo $this->Form->end("S'enregistrer");
?>