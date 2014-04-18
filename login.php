<?php include('settings.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="de">
    <head>
        <title><?php echo $page_title; ?></title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="content.css" />
        <link rel="stylesheet" type="text/css" href="wikistyle.css" />
        <link rel="stylesheet" type="text/css" href="loginbox.css" />
        <script type="text/javascript">
            <!--
            function sichtbarkeit(id1, id2) {
                id1_nav = id1 + '_nav';
                id2_nav = id2 + '_nav';
                document.getElementById(id1).style.display = "inline";
                document.getElementById(id2).style.display = "none";
                document.getElementById(id1_nav).className = "active";
                document.getElementById(id2_nav).className = "inactive";
            }
            -->
        </script>
    </head>
    <body>
        <div class="content">
            <div class="ubox">
                <ul>
                    <li><a id="t1_nav" href="#" onclick="sichtbarkeit('t1','t2'); return false" class="active">Gast</a></li>
                    <li><a id="t2_nav" href="#" onclick="sichtbarkeit('t2','t1'); return false" class="inactive">Admin</a></li>
                </ul>
            </div>
<?php
    if(isset($_SESSION['failure'])) {
        echo "<p class=\"failure\">Login war nicht ganz richtig. Versuchs nochmal.</p>";
        /** Passwort in sha1 anzeigen (z.B. um ein neues zu generieren  */
        //    echo "<p style=\"confirm\"><strong>SHA1 Passwort [{$_POST['password']}]: </strong>". sha1($_POST['password']) ."</p>";
       
    }
    if((isset($_GET['e']) && $_GET['e'] != 'new') || (isset($_GET['c']) && $_GET['c'] != 'new')) {
        echo "<p class=\"hint\">Zum Bearbeiten als Admin anmelden. Gästen wird grundsätzlich mißtraut.</p>";
    }
?>
            <div class="lbox">
                <div id="t1">
                    <form method="post" action="form.php?map=1">
                        <fieldset>
                            <table>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <input type="hidden" name="form_login_captcha" value="1" />
                                            <input class="button positive" type="submit" name="form_login" value="OK" />
                                        </td>
                                    </tr>
                                </tfoot>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left;">
                                        <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                                        <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false"><img src="securimage/images/refresh.gif" alt="Reload Image" /></a> <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Code
                                    </td>
                                    <td>
                                        <input type="text" name="captcha_code" size="10" maxlength="6" /><br />
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                </div>
                <div id="t2">
                    <form method="post" action="form.php?map=1<?php if($_GET['e']){ echo "&e={$_GET['e']}"; } elseif($_GET['c']) { echo "&c={$_GET['c']}"; }?>">
                        <fieldset>
                            <table>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <input class="button positive" type="submit" name="form_login" value="OK" />
                                        </td>
                                    </tr>
                                </tfoot>
                                <tr>
                                    <td><label for="user_name">User-Name</label></td>
                                    <td><input type="text" name="user_name" maxlenght="50" />
                                </tr>
                                <tr>
                                    <td><label for="password">Passwort</label></td>
                                    <td><input type="password" name="password" maxlenght="50" />
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="bbox">
                <p><a href="index.php" class="int">Karte</a></p>
            </div>
        </div>
    </body>
</html>
