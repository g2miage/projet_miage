<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
                
                // Chargement des fichiers CSS
		//echo $this->Html->css('cake.generic');
                echo $this->Html->css('bootstrap');
                echo $this->Html->css('bootstrap-responsive');
                echo $this->Html->css('main');
                echo $this->Html->css('font-awesome');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
    <body>

         <?php
            // l'utilisateur n'est pas connecté
         if(AuthComponent::user('id')){
            echo $this->Session->Flash();
            echo $this->element('navbar_connect'); 
            echo $this->Session->Flash();
            
        }
        else{
            echo $this->Session->Flash(); 
           echo $this->element('navbar');
        }
        ?>

<!-- Main hero unit for a primary marketing message or call to action -->
<div class ="jumbotron masthead">
    <div class ="container">
        <h1>Events</h1>
        <p>Bienvenue sur le site Events</p>        
    </div>
    </div>
    <div class ="container">
        <?php echo $this->Session->Flash(); ?>
        <div class="span9 offset1 centered well accueil-over">
       <?php if(!AuthComponent::user('id')){?>
            <h3>Créez et gérez facilement tous vos événements !</h3>
            <?php echo $this->Html->link('Inscription',  array('controller'=>'Users','action'=>'signup'), array('class'=>'btn btn-success btn-large'));
       

       }  
       else{?>
              <h3>Accède facilement aux événements !</h3>
           <?php echo $this->Html->link('Evénements',  array('controller'=>'Events','action'=>'Index'), array('class'=>'btn btn-success btn-large'));
       
       }
            
            ?>
        
        </div>
            <!-- Example row of columns -->
            <div class="accueil">
                
                <!--<h2 class="accueil-over centered well">Créez et gérez facilement tous vos événements !</h2>-->
                
                 <div class="row">
                    <div class="span3">
                        <?php echo $this->Html->image('qui_sommes_nous_accueil.png', array('alt' => 'qui_sommes_nous','class'=>'img-rounded')); ?>
                        <h3>
                            <?php           
                                echo $this->Html->link('<i class="icon-group"></i> Qui Sommes-nous?', array('controller' => 'pages', 'action' => 'display', 'qui_sommes_nous'),array('escape'=>false));
                            ?>
                        </h3>
                        <p>
                            Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum 
                        </p>
                    </div>
                    <div class="span3">
                        <?php echo $this->Html->image('fonctionnement_accueil.png', array('alt' => 'fonctionnement','class'=>'img-rounded')); ?>
                        <h3> 
                            <?php           
                                echo $this->Html->link('<i class="icon-magic"></i> Fonctionnement', array('controller' => 'pages', 'action' => 'display', 'fonctionnement'),array('escape'=>false));
                            ?>
                        </h3>
                        <p>
                            Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum 
                        </p>
                   </div>
                    <div class="span3">
                        <?php echo $this->Html->image('espace_pro_accueil.png', array('alt' => 'espace_pro','class'=>'img-rounded')); ?>
                        <h3>
                            <?php           
                                echo $this->Html->link('<i class="icon-glass"></i>  Espace Pro', array('controller' => 'pages', 'action' => 'display', 'espace_pro'),array('escape'=>false));
                            ?>
                        </h3>
                        <p>
                            Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum 
                        </p>
                    </div>
                    <div class="span3">
                        <?php echo $this->Html->image('qui_sommes_nous_accueil.png', array('alt' => 'dernier_truc','class'=>'img-rounded')); ?>
                        <h3>
                            <?php           
                                echo $this->Html->link('<i class="icon-globe"></i>  Un autre truc', array('controller' => 'pages', 'action' => 'display', 'espace_pro'),array('escape'=>false));
                            ?>
                        </h3>
                        <p>
                            Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum 
                        </p>
                    </div>

                </div>
            </div>
    
            <hr />
            <footer>
                <p>&copy; G2 Miage 2013</p>
            </footer>
        </div>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>');</script>
        <?php 
            echo $this->Html->script('vendor/bootstrap.min'); 
            echo $this->Html->script('main');
            
            // Mise en cache des fichiers JS
            echo $this->Js->writeBuffer();
        ?>
        
    </body>

</html>

