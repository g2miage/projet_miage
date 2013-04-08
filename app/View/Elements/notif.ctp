<div class="alert <?php echo isset($type)?'alert-error':'alert-success';?>" >
    <a href="#" class="close" onclick="$(this).parent().slideUp()">x</a>
    <p><?php echo $message; ?></p>
</div>