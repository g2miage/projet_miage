<?php
    // récupére le nombre de messages non lus de l'user
    $nbMsg = $this->requestAction(array('controller' => 'App','action' => 'checkNbMsg'));
?>

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
                        <li>
                            <?php 
                            $tooltip_opts = array(
                                'title'=>'Voir mes messages',
                                'escape' => false
                            );
                            
                            if($nbMsg){
                                echo $this->Html->link("<i class='icon-envelope blink'></i> <span class='badge badge-success'>$nbMsg</span>", array('controller' => 'Users', 'action' => 'messages'), $tooltip_opts); 
                            }else{
                                echo $this->Html->link("<i class='icon-envelope'></i>", array('controller' => 'Users', 'action' => 'messages'), $tooltip_opts); 
                            }
                            ?>
                        </li>
                        <li><?php echo $this->Html->link(Inflector::humanize(AuthComponent::user('username')), array('controller' => 'Users', 'action' => 'profil'), array('escape' => false, 'title'=>'Mon Profil')); ?></li>
                    </ul>
                    <?php
                    echo $this->Html->link(
                            "<i class='icon-off'></i> Déconnexion", array('action' => 'logout', 'controller' => 'users'), array('class' => 'btn btn-danger pull-right','escape' => false)
                    );
                    ?>
                </div>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>


