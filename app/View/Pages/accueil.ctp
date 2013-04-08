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

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
    <body>

        <?php
            // l'utilisateur n'est pas connecté
            echo $this->element('navbar'); 
        ?>

<!-- Main hero unit for a primary marketing message or call to action -->
<div class ="jumbotron masthead">
    <div class ="container">
        <h1>Events</h1>
        <p>Bienvenue sur le site Events</p>        
    </div>
    </div>
    <div class ="container">
            <!-- Example row of columns -->
            <div class="row">
                <div class="span4">
                    <h2>Qui sommes-nous?</h2>
                    <p>Salut les gars !</p>
                    <p><?php echo $this->Html->link('View details', '#', array('class'=>'btn')); ?></p>
                </div>
                <div class="span4">
                    <h2>Comment ça marche</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><?php echo $this->Html->link('View details', '#', array('class'=>'btn')); ?></p>
               </div>
                <div class="span4">
                    <h2>Pour les professionnels...</h2>
                    <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                    <p><?php echo $this->Html->link('View details', '#', array('class'=>'btn')); ?></p>
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

            