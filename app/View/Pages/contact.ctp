<div class="row">
    <div class="span4 offset4 signup">
        <h1 class='text-center text-info'>Nous contacter</h1>
        <?php echo $this->Form->create('Page'); ?>
            <div class="controls controls-row">
                <input id="Pagename" name="data[Page][name]" type="text" class="span4" placeholder="Nom" /> <br />
                <input id="Pageemail" name="data[Page][email]" type="email" class="span4" placeholder="Adresse mail" />
            </div>
            <div class="controls">
                <textarea id="Pagesdesc" name="data[Page][desc]" class="span4" placeholder="Message" rows="5"></textarea>
            </div>
            <hr />
            <div class="controls">
             <?php echo $this->Form->end(array('label'=>'Envoyer','class' => 'btn btn-large btn-block btn-success btn-primary')); ?>
             </div>
        </form>
    </div>
</div>
