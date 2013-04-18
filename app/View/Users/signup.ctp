
<h2>S'enregistrer</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'Login :'));
echo $this->Form->input('mail', array('label' => 'Email :'));
echo $this->Form->input('password', array('label' => 'Mot de passe :'));
echo $this->Form->input('password_confirm', array('label' => 'Confirmation Mot de passe :', 'type' => 'password'));
echo $this->Form->input('role_id', array('label' => 'Prestataire', 'type' => 'checkbox', 'onclick' => 'WhenChecked()'));
?>

<div id='prestat' style="display: none" >
    <?php
    echo $this->Form->input('scorpname', array('label' => 'Raison Sociale :'));
    echo $this->Form->input('ssiret', array('label' => 'SIRET :'));
    echo $this->Form->input('suptype_id', array('options' => array($stype)));
//echo $this->Form->input('sdesc', array('label' => 'Type d\'activité'));

    echo $this->Form->input('sdesc', array('label' => 'Type d\'activité'));
    echo $this->Form->input('address', array('label' => 'Adresse'));
    echo $this->Form->input('zip', array('label' => 'Code postal'));
    echo $this->Form->input('city', array('label' => 'Ville'));
    echo $this->Form->input('country', array('label' => 'Pays'));
    ?>
</div>
<?php

    echo $this->Html->image('captcha.jpg', array('style' => 'padding: 0.5%;'));
    echo $this->Form->input('captcha');
    echo $this->Form->end(array('label' => 'Enregistrer', 'class' => 'btn btn-primary'));
?>