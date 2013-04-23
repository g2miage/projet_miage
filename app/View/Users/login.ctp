
<div class="row">
    <div class="span4 offset4 signup">
        <h1 class='text-center text-info'>Connexion</h1>
        <div class="alert alert-info">
            Pas encore inscrit?
            <?php echo $this->Html->link('Clic clic :)',  array('controller'=>'Users','action'=>'signup'));?>
        </div>
        <hr />
        <?php
            echo $this->Form->create('User');
            echo $this->Form->input('username',  array('label' => '','placeholder'=>'Login','class'=>'span4'));
            echo $this->Form->input('password',  array('label' => '','placeholder'=>'Mot de passe','class'=>'span4'));
            echo '<br />';
            echo $this->Form->end(array('label'=>'Continuer','class'=>'btn btn-large btn-success btn-block btn-primary', 'div'=>false));
        ?>
        <p class="muted text-center">
            J'ai perdu mon login/mot de passe !
            <?php echo $this->Html->link('C\'est par ici',  array('controller'=>'Users','action'=>'signup'));?>
        </p>
    </div>
</div>