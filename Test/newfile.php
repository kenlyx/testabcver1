<?php 

    if (isset($_SERVER) && isset($_SERVER['REMOTE_ADDR'])) { 

        printf("REMOTE_IP is %s", $_SERVER['REMOTE_ADDR']); 

    } else { 

        print('You are in php script mode'); 

    } 

?>
