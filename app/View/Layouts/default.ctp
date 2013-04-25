<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout." - MyEvents"; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        // Chargement des fichiers CSS
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('bootstrap-responsive');
        echo $this->Html->css('main');
        echo $this->Html->css('font-awesome');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        echo $this->Html->script('main');

        ?>
        
    </head>
    <body>

        <?php
        // l'utilisateur n'est pas connecté
        if (AuthComponent::user('id')) {
            echo $this->element('navbar_connect');
        } else {
            echo $this->element('navbar');
        }
        ?>

        <div class="container">
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
            <?php
            $this->Session->flash('auth');
            echo $this->Session->flash().'<br />';
            echo $this->fetch('content');
            ?>

            <footer>
                <p>&copy; G2 Miage 2013</p>
            </footer>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <?php
        echo $this->Html->script('vendor/bootstrap.min');
        echo $this->Html->script('jquery-ui-timepicker-addon');
        echo $this->Html->script('calendar');
        echo $this->Html->script('main');
        // Mise en cache des fichiers JS
        echo $this->Js->writeBuffer();
        ?>
    </body>
</html>
