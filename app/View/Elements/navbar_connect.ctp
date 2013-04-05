<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php echo $this->Html->link('Events', '#', array('class'=>'brand')); ?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><?php echo $this->Html->link('Accueil', '#'); ?></li>
                    <li><?php echo $this->Html->link('About', '#about'); ?></li>
                    <li><?php echo $this->Html->link('Contact', '#contact'); ?></li>
                </ul>
                <div class="pull-right">
                    <ul class="nav">
                        <li>
                            <?php   
                                echo $this->Html->link(
                                    $this->Html->image("recettes/6.jpg", array("alt" => "Crêpes")),
                                    "/",
                                    array('escape' => false)
                                ); 
                            ?>
                        </li>
                        <li></i><?php echo $this->Html->link('Jean Valjean', ''); ?></li>
                    </ul>
                    <?php 
                        echo $this->Html->link(
                            $this->Html->tag('i', null, array('class' => 'icon-user')), 
                            '#', 
                            array('class'=>'btn btn-danger pull-right')
                        ); 
                    ?>
                </div>
                
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>