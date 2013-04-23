<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php echo $this->Html->link("<i class='icon-group'></i> MyEvents", array('controller' => 'pages', 'action' => 'display'), array('class'=>'brand','escape'=>false)); ?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><?php echo $this->Html->link('<i class="icon-envelope"></i> Contact', array('controller' => 'pages', 'action' => 'display','contact'),array('escape'=>false)); ?></li>
                    <li><?php echo $this->Html->link('<i class="icon-tasks"></i> Evénements', array('controller' => 'events', 'action' => 'index'),array('escape'=>false)); ?></li>
                    <li><?php echo $this->Html->link('Prestataires', array('controller' => 'Users', 'action' => 'suppliers')); ?></li>            
                </ul>
                <div class="pull-right">
                    <ul class="nav">
                        <li><?php echo $this->Html->link(AuthComponent::user('username'), array('controller' => 'users', 'action' => 'profil')); ?></li>
                    </ul>
                    <?php 
                        echo $this->Html->link(
                            //$this->Html->tag('i', null, array('class' => 'icon-user'))
                            "<i class='icon-off'></i> Déconnexion",
                            array('action'=>'logout','controller'=>'users'), 
                            array('class'=>'btn btn-danger pull-right','escape'=>false)
                        ); 
                    ?>
                </div>
                
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>