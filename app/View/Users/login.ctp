<h2>S'identifier</h2>
<?php
    echo $this->Form->create('User');
    echo $this->Form->input('username',  array('label' => 'Login :'));
    echo $this->Form->input('password',  array('label' => 'Mot de passe :'));
    echo $this->Form->end(array('label'=>'Se connecter','class'=>'btn btn-primary', 'div'=>false));
?>