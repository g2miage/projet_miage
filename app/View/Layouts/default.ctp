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
            <?php
            $this->session->flash('auth');
            echo $this->Session->flash();
            echo $this->fetch('content');
            ?>

            <hr />
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
