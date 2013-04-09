<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php echo $this->Html->link('Events',  array('controller' => 'pages', 'action' => 'display'), array('class'=>'brand')); ?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><?php echo $this->Html->link('About', '#about'); ?></li>
                    <li><?php echo $this->Html->link('Contact', array('controller' => 'pages', 'action' => 'display','contact')); ?></li>
                </ul>
               <form class="navbar-form pull-right" method="post" action="/projet_miage/Users/signup">
                    <input class="span2" name="data[Users/signup][username]" id="Users\/signupUsername" type="text" placeholder="Login">
                    <input class="span2" name="data[Users/signup][password]" id="Users\/signupPassword" type="password" placeholder="Mot de passe">
                    <button type="submit" class="btn">Connexion</button>
               </form> 
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>