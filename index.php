<!--265628490406-p0lbebmt1qjs62tgkpiir0faanvh4s0j.apps.googleusercontent.com-->
<!--Tpy1k28Yl-aO9HWd3XcENzD3-->

<?php
    //defining

    require_once __DIR__.'/gplus-lib/vendor/autoload.php';
    const CLIENT_ID = "265628490406-p0lbebmt1qjs62tgkpiir0faanvh4s0j.apps.googleusercontent.com";
    const CLIENT_SECRET ="Tpy1k28Yl-aO9HWd3XcENzD3";
    const REDIRECT_URI = "http://localhost:8082/google-login/";


    session_start();
    //initial
    
    $client = new Google_Client();
    $client->setClientId(CLIENT_ID);
    $client->setClientSecret(CLIENT_SECRET);
    $client->setRedirectUri(REDIRECT_URI);
    $client->setScopes('email');

    $plus = new Google_Service_Plus($client);
    

    //actual process


    if(isset($_REQUEST['logout']))
    {
        session_unset();
    }

    if(isset($_GET['code']))
    {
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
        $redirect = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        header('Location:'.filter_var($redirect,FILTER_SANITIZE_URL));
    }

    if(isset($_SESSION['access_token']) && $_SESSION['access_token'])
    {
        $client->setAccessToken($_SESSION['access_token']);
        $me = $plus->people->get('me');

        $id = $me['id'];
        $name = $me['displayName'];
        $email = $me['emails'][0]['value'];
        $profile_image_url = $me['image']['url'];
        $profile_image_url = str_replace("50","1000",$profile_image_url);
    }
    else{
        $authUrl = $client->createAuthUrl();
    }
?>

<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

    <body>
    <div class="card">
     <?php

        if(isset($authUrl))
        {
            echo "<p class='title'>Get Google Plus Profile</p>";
            echo "<p><img id='pro_image' src='./img/user.png' alt='Profile Picture' style='width:50%'></p>";
            echo "<a class='loginBtn' href='".$authUrl."'><img src='gplus-lib/signin_button.png' height = '50px'/></a>";
                  
        }
        else{
            echo "<p class='title'>Google Plus Profile</p>";
            echo "<img id='pro_image' src='".$profile_image_url."' alt='Profile Picture' style='width:50%'>";
            echo "<p class='title'> Name : {$name} </p>";            
            echo "<p class='title' style='padding-bottom:30px'> Email : {$email} </p>";
        }

    ?>
    </div>
    </body>
</html>
