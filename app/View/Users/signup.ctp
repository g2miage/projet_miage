<h2>S'enregistrer</h2>
<?php echo $this->Form->create('User'); ?>
    <?php echo $this->Form->input('username',array('label'=>'Login :'));?>
    <?php echo $this->Form->input('mail',array('label'=>'Email :'));?>
    <?php echo $this->Form->input('password',array('label'=>'Mot de passe :'));?>
<?php echo $this->Form->end("S'enregistre"); ?>