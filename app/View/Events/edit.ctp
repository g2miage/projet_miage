<div class='row'>
    <div class='span8 offset2 form2'>
        <h1 class='text-center text-info'>Modifier l'événement</h1>
        <hr />
        <div class="row">
            <div class="span6 offset1">
                <?php
                echo $this->Form->create('Event', array('type' => 'file'));
                echo $this->Form->input('title', array('label' => '','class'=>'span6','placeholder'=>'Titre'));
                echo $this->Tinymce->input('Event.desc', array('label' => '','rows'=>'20'),null, 'basic2');
                echo "<br />";
                echo "<div class='row'><div class='span4'>";
                echo $this->Form->input('startday', array('date', 'label' => 'Début','class'=>'span4','placeholder'=>'Date de début'));
                echo "</div><div class='span2'>";
                echo $this->Form->input('starttime', array('label' => '<br />','class'=>'span2','placeholder'=>'Heure de début'));
                echo "</div></div>";

                echo "<div class='row'><div class='span4'>";
                echo $this->Form->input('endday', array('label' => 'Fin','class'=>'span4','placeholder'=>'Date de fin'));
                echo "</div><div class='span2'>";
                echo $this->Form->input('endtime', array('label' => '<br />','class'=>'span2','placeholder'=>'Heure de fin'));
                echo "</div></div><hr />";
                
                echo $this->Form->input('address', array('label' => 'Où ?','class'=>'span6','placeholder'=>'Adresse'));
                
                echo "<div class='row'><div class='span2'>";
                echo $this->Form->input('zip', array('label' => '','class'=>'span2','placeholder'=>'Code Postal'));
                echo "</div><div class='span4'>";
                echo $this->Form->input('city', array('label' => '','class'=>'span4','placeholder'=>'Ville'));
                echo "</div></div><hr />";
                
                echo $this->Form->input('amount', array('class'=>'span6','label'=>'Prix d\'entrée'));
                
                echo $this->Form->input('role_id', array('label' => 'Evénement privé', 'type' => 'checkbox','id'=>'visibility'));
                echo '<br /><br />';
                if (!empty($this->data['Event']['picture'])) {
                    echo "<hr /><h4 class='text-center text-info'>Modifier l 'image</h4><br />";
                    echo $this->Html->image($this->data['Event']['picture'], array('alt' => ':/', 'height' => '150px', 'width' => '200px'));
                    echo "<div class='text-center'>";
                    echo $this->Html->link('<i class="icon-remove"> Suprimer l\'image</i>', array('action' => 'deleteimg', $this->data['Event']['id']), array('escape' => false));
                    echo "</div><br />";
                    echo $this->Form->input('picture', array('type' => 'file', 'label' => ''));
                    echo '<br /><br />';
                } else {
                    echo "<hr /><h4 class='text-center text-info'>Ajout d'une image</h4>";
                    echo $this->Form->input('picture', array('type' => 'file', 'label' => ''));
                    echo '<br /><br />';
                }
                echo $this->Form->input('id', array('type' => 'hidden'));
                echo '<hr />';
                echo "<div class='row'><div class='span2 offset2'>";
                echo $this->Form->end(array('label' => 'Modifier', 'class' => 'btn btn-large btn-block btn-success btn-primary', 'div' => false));
                echo "</div></div><hr />";
                ?>           
            </div>
        </div>
    </div>
</div>
    <?php
    echo $this->Html->link("Retourner à la liste des événements", array('action' => 'index'), array('class' => '', 'escape' => false));
    ?>

