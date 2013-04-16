<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title><?php echo $title_for_layout; ?></title>

    <?php echo $this->Html->css('email'); ?>
</head>
 


<!-- BODY -->
<table class="body-wrap">
    <tr>
        <td></td>
            <td class="container" bgcolor="#FFFFFF">
                <div class="content">
                    <table>
                        <tr>
                            <td>
                                <?php echo $this->fetch('content'); ?>
                                
                                <br/><br/>							
                                            <table align="left" class="column">
                                                <tr><h5 class="">Contact :</h5></tr>
                                                <tr><td>Tél. :</td><td> <strong>05.12.34.56.78</strong></td><br/>
                                                <tr><td>E-mail :</td><td><strong><a href="contact@events.com">contact@events.com</a></strong></td></tr>
                                            </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        <td></td>
    </tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
    <tr>
        <td></td>
        <td class="container">

            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td align="center">
                            <p>
                                <a href="#">Mentions Légales</a> |
                                <a href="#">Protection de la vie privée</a> |
                                <a href="#"><unsubscribe>Se désinscrire</unsubscribe></a>
                            </p>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table><!-- /FOOTER -->

</body>
</html>