<?php 
    $this->set('title_for_layout','Editer mon profil');
    
    echo $this->Form->create('User');
        echo $this->Form->input('firstname',  array('label' => 'Prénom'));
        echo $this->Form->input('lastname',  array('label' => 'Nom'));
        echo $this->Form->input('password1',  array('label' => 'Mot passe','type' => 'password','required'=>'required','message'  => 'Obligatoire' ));
        echo $this->Form->input('password_confirm', array('label' => 'Confirmation Mot de passe :', 'type' => 'password'));
    echo $this->Form->end(array('label'=>'Modifier','class'=>'btn btn-primary', 'div'=>false));

?>