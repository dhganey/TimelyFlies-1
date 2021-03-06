<?php
    require_once 'header.php';

echo "<div class='notice'><h3>Please enter your details to sign up:</h3>";

$error = $user = $pass = $pass2 = "";
if (isset($_SESSION['user'])) {
    destroySession();
}

if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    $pass2 = sanitizeString($_POST['pass2']);
    if ($user == '' || $pass == '') {
        $error = "Not all fields were entered.<br/><br/>";
    } else
    {
        if (mysql_num_rows(queryMysql("SELECT * FROM users WHERE username='$user'")))
        {
            $error = "That username already exists<br/><br/>";
        }
        else
        {
            //new stuff
            if ($pass == $pass2)
            {
                $hashedpass = sha1($pass);
                queryMysql("INSERT INTO users VALUES('$user', '$hashedpass', 0)");
                if (!mkdir("$user")) {
                    echo "User directory creation failed.<br/>";
                }
                die("<h4>Account created.</h4>Please log in.<br/><br/>");
            }
            else
            {
                $error = "The passwords do not match <br/><br/>";
            }
        }
    }
}

echo <<<_END
<form method='post' action='signup.php'>$error
<span class='fieldname'>Username</span>
<input type='text' maxlength='16' name='user' value='$user'
    onBlur='checkUser(this)'/><span id='info'></span><br/>
<span class='fieldname'>Password</span>
<input type='password' maxlength='16' name='pass' id='pass'
    value='$pass' onBlur='checkPasswords()'/><span id='passwordinfo'></span><br/>
<span class='fieldname'>Confirm Password</span>
<input type='password' maxlength='16' name='pass2' id='pass2'
    value='$pass2' onBlur='checkPasswords()'/><br/><br/>
_END;
?>

<span class='fieldname'>&nbsp;</span>
<input type='submit' value='Sign up'/>
</form></div><br/></body></html>
