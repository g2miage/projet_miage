<div class='row si'>
<div class='span4 offset4 signup'>
        <h1 class='text-center text-info'>Inscription</h1>
        <hr />
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label'=>'','placeholder' => 'Login','class'=>'span4'));
echo $this->Form->input('mail', array('label'=>'','placeholder' => 'Adresse mail','class'=>'span4'));
echo $this->Form->input('password', array('label'=>'','placeholder' => 'Mot de passe','class'=>'span4'));
echo $this->Form->input('password_confirm', array('label'=>'','placeholder' => 'Confirmation du mot de passe', 'type' => 'password','class'=>'span4'));
echo $this->Form->input('role_id', array('label' => 'Je suis un prestataire', 'type' => 'checkbox','id'=>'prestabox'));
?>

<div id='presta' style="display:none">
    <?php
    echo $this->Form->input('scorpname', array('label'=>'','placeholder' => 'Raison Sociale','class'=>'span4'));
    echo $this->Form->input('ssiret', array('label'=>'','placeholder' => 'n° Siret','class'=>'span4'));
    echo $this->Form->input('suptype_id', array('label' => '','options' => array($stype),'class'=>'span4','empty'=>'Quelle est votre activité ?'));
    echo $this->Tinymce->input('User.sdesc', array('label' => ''),null, 'basic');
    echo $this->Form->input('address', array('label'=>'','placeholder' => 'Adresse','class'=>'span4','rows'=>2));
    echo $this->Form->input('zip', array('label'=>'','placeholder' => 'Code postal','class'=>'span4'));
    echo $this->Form->input('city', array('label'=>'','placeholder' => 'Ville','class'=>'span4'));
    echo $this->Form->input('country', array('label'=>'','placeholder' => 'Pays','class'=>'span4'));
    ?>
</div>
<?php
    
    echo $this->Html->image('captcha.jpg',array('class'=>'img-rounded   '));
    echo $this->Form->input('captcha',array('label'=>'','placeholder' => 'Veuillez écrire le code','class'=>'span4'));
    echo "<hr />";
    echo $this->Form->end(array('label' => 'Créer mon compte !', 'class' => 'btn btn-large btn-success btn-block btn-primary'));
?>
        
    <p class="muted text-center">
        Vous avez déjà un compte ? 
        <?php echo $this->Html->link('Connectez-vous !',  array('controller'=>'Users','action'=>'login'));?>
    </p>
</div>
</div>