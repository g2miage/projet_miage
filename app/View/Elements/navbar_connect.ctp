<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php echo $this->Html->link("<i class='icon-group'></i> MyEvents", array('controller' => 'pages', 'action' => 'display'), array('class' => 'brand', 'escape' => false)); ?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><?php echo $this->Html->link('<i class="icon-envelope"></i> Contact', array('controller' => 'pages', 'action' => 'display', 'contact'), array('escape' => false)); ?></li>
                    <li><?php echo $this->Html->link('<i class="icon-tasks"></i> Evénements', array('controller' => 'Events', 'action' => 'index'), array('escape' => false)); ?></li>
                    <li><?php echo $this->Html->link('<i class="icon-briefcase"></i> Prestataires', array('controller' => 'Users', 'action' => 'suppliers'), array('escape' => false)); ?></li>            
                </ul>
                <div class="pull-right">
                    <ul class="nav">
                        <li class="dropdown">
                            <?php echo $this->Html->link('<i class="icon-envelope blink"></i> <span class="badge badge-success">6</span> ', '#', array('data-toggle' => 'dropdown', 'class' => 'dropdown-toggle', 'escape' => false)); ?>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="http://google.com"><i class="icon-eye-open"></i> Voir mes messages</a>
                                </li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="http://google.com">Voir mes messages</a>
                                </li>
                            </ul>
                        </li>
                        <li><?php echo $this->Html->link(Inflector::humanize(AuthComponent::user('username')), array('controller' => 'Users', 'action' => 'profil'), array('escape' => false)); ?></li>
                    </ul>
                    <?php
                    echo $this->Html->link(
                            //$this->Html->tag('i', null, array('class' => 'icon-user'))
                            "<i class='icon-off'></i> Déconnexion", array('action' => 'logout', 'controller' => 'users'), array('class' => 'btn btn-danger pull-right', 'escape' => false)
                    );
                    ?>
                </div>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>


