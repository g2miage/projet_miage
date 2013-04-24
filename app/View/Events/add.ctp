<div class='row'>
    <div class='span8 offset2 form2'>
        <h1 class='text-center text-info'>Création d'événement</h1>
        <hr />
        <div class="row">
            <div class="span6 offset1">
            <?php
                echo $this->Form->create('Event', array('type' => 'file'));
                echo $this->Form->input('title', array('label' => '','class'=>'span6','placeholder'=>'Titre'));
                echo $this->Form->input('eventtype_id', array('label' => '','class'=>'span6','empty'=>'Type d\'événement'));
                echo $this->Tinymce->input('Event.desc',array('label' => ''),null, 'basic2');

                echo "<hr /><div class='row'><div class='span4'>";
                echo $this->Form->input('startday', array('date', 'label' => '','class'=>'span4','placeholder'=>'Date de début'));
                echo "</div><div class='span2'>";
                echo $this->Form->input('starttime', array('label' => '','class'=>'span2','placeholder'=>'Heure de début'));
                echo "</div></div>";

                echo "<div class='row'><div class='span4'>";
                echo $this->Form->input('endday', array('label' => '','class'=>'span4','placeholder'=>'Date de fin'));
                echo "</div><div class='span2'>";
                echo $this->Form->input('endtime', array('label' => '','class'=>'span2','placeholder'=>'Heure de fin'));
                echo "</div></div><hr />";

                echo $this->Form->input('address', array('label' => '','class'=>'span6','placeholder'=>'Adresse'));
                
                echo "<div class='row'><div class='span2'>";
                echo $this->Form->input('zip', array('label' => '','class'=>'span2','placeholder'=>'Code Postal'));
                echo "</div><div class='span4'>";
                echo $this->Form->input('city', array('label' => '','class'=>'span4','placeholder'=>'Ville'));
                echo "</div></div><hr />";
                
                echo $this->Form->input('amount', array('label' => '','class'=>'span6','placeholder '=>'Prix d\'entrée'));
                echo $this->Form->input('role_id', array('label' => 'Evénement privé', 'type' => 'checkbox','id'=>'visibility'));
                echo "<hr /><h4 class='text-center text-info'>Ajout d'une image</h4>";
                echo $this->Form->input('picture', array('type' => 'file', 'label' => ''));
                echo '<hr />';
                echo "<div class='row'><div class='span2 offset2'>";
                    echo $this->Form->end(array('label'=>'Créer','class' => 'btn btn-large btn-block btn-success btn-primary'));
                echo "</div></div><hr />";
            ?>
            </div>
        </div>
    </div>
</div>

