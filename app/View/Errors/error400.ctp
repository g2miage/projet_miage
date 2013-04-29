<div class='row'>
    <div class='span8 offset2 form2'>
                <?php if ($error instanceof ForbiddenException) { ?>
                    <h1 class='text-center text-warning'><b>Vous n'êtes pas connecté <span class='muted'>:(</span></b></h1>
                    <hr />
                    <div class="text-center">
                        <!--<div class="span6 offset1 ">-->
                            <h4>Vous devez être connecté pour accèder à cette page !</h4>
                            <br />
                                <h5>Vous avez déjà un compte ?</h5>
                                <?php echo $this->Html->link('Je me connecte !',  array('controller'=>'Users','action'=>'login'),array('class'=>'btn btn-info'));?>
                                <br />
                                <br />
                                <h5>Pas encore de compte ?</h5>
                                <?php echo $this->Html->link('Je crée mon compte !',  array('controller'=>'Users','action'=>'signup'),array('class'=>'btn btn-success'));?>
                <?php } else { ?>
                    <h1 class='text-center text-error'><b>Page non trouvée <span class='muted'>:(</span></b></h1>
                    <hr />
                    <div class="text-center">
                        <!--<div class="span6 offset1 ">-->
                            <h4>La page que vous recherchez n'existe pas !</h4>
                            <br />
                            <?php echo $this->Html->link('Retourner à l\'accueil',  '/',array('class'=>'btn btn-info'));?>
                <?php } ?>
                    
                        <!--</div>-->
                    </div>
    </div>
</div>