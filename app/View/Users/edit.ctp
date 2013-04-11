<?php 
    $this->set('title_for_layout','Editer mon profil');
        echo $this->HTML->Link('Modifier mon mot de passe',  array('action'=>'editpassword'));  
        echo $this->Form->create('User',array('class' => 'form-horizontal'));
        echo $this->Form->Label('Sexe');
        $options = array('M' => 'M','F' => 'F');
        $attributes = array(
            'legend' => false
            );
        echo $this->Form->radio('sex', $options, $attributes);
        echo $this->Form->input('firstname',  array('label' => 'Prenom'));
        echo $this->Form->input('lastname',  array('label' => 'Nom'));   
        echo $this->Form->input('mail',  array('label' => 'Email'));   
        echo $this->Form->input('tel',  array('label' => 'Tel.'));   
        echo $this->Form->input('address',  array('label' => 'Adresse'));   
        echo $this->Form->input('zip',  array('label' => 'Code postal'));   
        echo $this->Form->input('city',  array('label' => 'Ville'));   
        echo $this->Form->input('country',  array('label' => 'Pays'));  
        echo $this->Form->end(array('label'=>'Modifier','class'=>'btn btn-primary', 'div'=>false  ));
        
?>