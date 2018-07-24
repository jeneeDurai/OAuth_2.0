<?php
    session_start();
   
    if(isset($_GET["logout"]))
    {
        if($_GET["logout"] == "true")  
        {
            session_destroy();
            echo "You are logged out of this website";
            echo "<br><a href='index.php'>Click here to proceed to the sign in page</a>";
        }  
    }
    else if(isset($_SESSION["fb_access_code"]))
    {
        $user_information = file_get_contents("https://graph.facebook.com/me?access_token=" . $_SESSION["fb_access_code"] . "&fields=email,user_birthday");
        $user_information_array = json_decode($user_information, true);
       
        if(isset($user_information_array["email"]))
        {
            echo "Your email id is " . $user_information_array["email"] . " and you are logged in using facebook now !!!!";
            echo "<br><a href='check.php?logout=true'>Log Out</a>";
        }
        else
        {
            echo "Please login in using facebook";
            echo "<br><a href='index.php'>Click here to proceed to the sign in page</a>";  
        }
    }
    else
    {
        echo "Please login in using facebook";
        echo "<br><a href='index.php'>Click here to proceed to the sign in page</a>";
    }
?>