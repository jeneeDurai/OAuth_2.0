<?php
   
    session_start();
   
    if(isset($_GET["code"]))
    {  
        $token_and_expire = file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=420274985147315&redirect_uri=http://www.qbitive.com&client_secret=6611460b9c786d42082bc373e5d3e168&code=" . $_GET["code"]);
       
        parse_str($token_and_expire, $_token_and_expire_array);
       
       
        if(isset($_token_and_expire_array["access_token"]))
        {  
            $access_token = $_token_and_expire_array["access_token"];
            $_SESSION['fb_access_code'] = $access_token;
           
            header("Location: http://www.qbitive.com");
                }
        else
        {  
            echo "\n An error accoured!!!!! \n";
            exit;
        }
    }
    else
    {
        echo "\n An error accoured!!!!! \n";
    }
   
?>