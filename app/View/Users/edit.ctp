<div class='row'>
    <div class='span8 offset2 form2'>
        <h1 class='text-center text-info'>Modification du profil</h1>
        <hr />
        <div class="row">
            <div class="span6 offset1">
                <?php
                    echo "<div class='row'><div class='span4 offset2'>";
                    echo $this->Html->Link('Modifier mon mot de passe', array('action' => 'editpassword'),array('class'=>'btn btn-warning'));
                    echo "</div></div>";
                    echo "<br />";
                    echo $this->Form->create('User');
                    
                    echo '<label class="radio inline">
                        <input type="radio" name="data[User][sex]" id="UserSexM" value="M"> Homme
                        </label>
                        <label class="radio inline">
                        <input type="radio" name="data[User][sex]" id="UserSexF" value="F"> Femme
                        </label>
                        <label class="radio inline">
                        <input type="radio" name="data[User][sex]" id="UserSexT" value="T"> Tondeuse à gazon
                        </label>
                        <br /><br />';
                    
                    // $options = array('M' => 'Homme', 'F' => 'Femme');
                    // $attributes = array('legend' => false);
                    // echo $this->Form->Label('Sexe');
                    //echo $this->Form->radio('sex', $options, $attributes);
                    echo "<div class='row'><div class='span3'>";
                    echo $this->Form->input('firstname', array('label' => '','class'=>'span3','placeholder'=>'Prénom'));
                    echo "</div><div class='span3'>";
                    echo $this->Form->input('lastname', array('label' => '','class'=>'span3','placeholder'=>'Nom'));
                    echo "</div></div>";
                    echo $this->Form->input('mail', array('label' => '','class'=>'span6','placeholder'=>'Adresse mail'));
                    echo $this->Form->input('tel', array('label' => '','class'=>'span6','placeholder'=>'N° de téléphone'));
                    echo $this->Form->hidden('formUser', array('value' => true));
                    echo $this->Form->hidden('role_id');

                    if ($this->data['User']['suptype_id'] != 0) {
                        echo $this->Form->input('address', array('label' => '','class'=>'span6','placeholder'=>'Adresse'));
                        echo "<div class='row'><div class='span2'>";
                        echo $this->Form->input('zip', array('label' => '','class'=>'span2','placeholder'=>'Code Postal'));
                        echo "</div><div class='span2'>";
                        echo $this->Form->input('city', array('label' => '','class'=>'span2','placeholder'=>'Ville'));
                        echo "</div><div class='span2'>";
                        echo $this->Form->input('country', array('label' => '','class'=>'span2','placeholder'=>'Pays'));
                        echo "</div></div>";
                        
                        echo $this->Form->input('suptype_id', array('options' => array($stype), 'class' => 'span6','label'=>''));

                        echo $this->Form->input('scorpname', array('label' => '','class'=>'span6','placeholder'=>'Raison Sociale'));
                        echo $this->Form->input('ssiret', array('label' => '','class'=>'span6','placeholder'=>'N° Siret'));
                        echo $this->Tinymce->input('User.sdesc', array('label' => ''),null, 'basic2');
                        echo "<br />";
                        echo $this->Form->input('website', array('label' => '','class'=>'span6','placeholder'=>'Site Web'));
                    }else{
                        echo $this->Form->input('address1', array('label' => '','class'=>'span6','placeholder'=>'Adresse'));
                        echo "<div class='row'><div class='span2'>";
                        echo $this->Form->input('zip1', array('label' => '','class'=>'span2','placeholder'=>'Code Postal'));
                        echo "</div><div class='span2'>";
                        echo $this->Form->input('city1', array('label' => '','class'=>'span2','placeholder'=>'Ville'));
                        echo "</div><div class='span2'>";
                        echo $this->Form->input('country1', array('label' => '','class'=>'span2','placeholder'=>'Pays'));
                        echo "</div></div>";
                    }
                    echo "<hr />";
                    
                    echo "<div class='row'><div class='span2 offset2'>";
                    echo $this->Form->end(array('label' => 'Enregistrer', 'class' => 'btn btn-large btn-block btn-success btn-primary', 'div' => false));
                    echo "</div></div>";
                ?>            
            </div>
        </div>
    </div>
</div>