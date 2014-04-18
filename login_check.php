<?php
if(!defined('LOGIN_CHECK')) {
    define('LOGIN_CHECK', 1);

    include('db.php');
    include('securimage/securimage.php');

    function is_guest() {
        if($_SESSION['form'] == 1) {
            return true;
        }
        return false;
    }

    function is_admin() {
        if($_SESSION['form'] == 2) {
            return true;
        }
        return false;
    }

    function userInDb($user, $pass) {
        $link = connect_db();
        $user = db_escape_string($_POST['user_name']);
        $pass = sha1(db_escape_string(trim($_POST['password'])));

        $query = "SELECT COUNT(*) FROM users WHERE name = '$user' AND password = '$pass'";
        $res = db_query($query) or die(db_error());
        $ret = db_fetch_row($res);
        if($ret[0] > 0) {
            close_db($link);
            return true;
        }

        close_db($link);
        return false;
    }

    function login_check() {
        session_start();
        if (!isset($_SESSION['form']) && !isset($_POST['form_login'])) {
            return false;
        } elseif(isset($_POST['form_login'])) {
            if(isset($_POST['form_login_captcha'])) {
                /* use the captcha */
                $img = new Securimage();
                if($img->check($_POST['captcha_code']) == true) {
                    /* captcha was okay */
                    unset($_POST['form_login'], $_POST['user_name'], $_POST['password']);
                    if(isset($_SESSION['failure'])) {
                        unset($_SESSION['failure']);
                    }
                    $_SESSION['form'] = 1;
                    return true;

                } else {
                    /* captcha was not okay */
                    $_SESSION['failure'] = '1';
                    return false;
                }

            } else {
                /* normal user-login */
                if(userInDb($_POST['user_name'], $_POST['password'])) {
                    /* Login succesful */
                    if(isset($_SESSION['failure'])) {
                        unset($_SESSION['failure']);
                    }
                    unset($_POST['form_login'], $_POST['form_login_captcha'], $_POST['captcha_code']);
                    $_SESSION['form'] = 2;
                    return true;
                } else {
                    /* Login not succesful */
                    $_SESSION['failure'] = '1';
                    return false;
                }
            }
        } elseif(isset($_POST['form_logout'])) {
            unset($_SESSION);
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time()-42000, '/');
            }
            session_destroy();
                return false;
        }
        else {
            return true;
        }
    }
}
?>
