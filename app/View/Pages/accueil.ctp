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
<body class="home">
    <?php
        // l'utilisateur n'est pas connecté
     if(AuthComponent::user('id')){
        echo $this->Session->Flash();
        echo $this->element('navbar_connect'); 

    }else{
        echo $this->Session->Flash(); 
        echo $this->element('navbar');
    }
    ?>

    <div class ="jumbotron masthead">
        <!--[if lt IE 8]>
                <div style="margin-top:100px" class="alert alert-block alert-error">
                                <h4>Les années 80 sont terminées !</h4>
                                <p>
                                        Votre navigateur est vieux et fatigué, et malheureusement vous ne pourrez pas profiter de toutes les fonctionnalités de notre site. 
                                        <br />
                                        Pourquoi ne pas choisir un <a href="http://www.browserchoice.eu/BrowserChoice/browserchoice_fr.htm" target="blank">navigateur plus récent</a> ?
                                </p>
                </div>
        <![endif]-->
        <div class ="container">
            <h1>MyEvents</h1>
            <p>Bienvenue sur le site Events</p>        
        </div>
    </div>
    <div class ="home container">

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
                            Présentation générale de MyEvent
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
                            Déscription du fonctionnement du site 
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
                           Présentation de l'espace Pro
                        </p>
                    </div>
                    <div class="span3">
                        <?php echo $this->Html->image('contact_accueil.png', array('alt' => 'contact','class'=>'img-rounded')); ?>
                        <h3>
                            <?php           
                                echo $this->Html->link('<i class="icon-globe"></i>  Contactez-nous', array('controller' => 'pages', 'action' => 'display', 'contact'),array('escape'=>false));
                            ?>
                        </h3>
                        <p>
                            Une question à nous soumettre ?
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

