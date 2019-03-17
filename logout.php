<?php

            $cookie_name = "logged_in";
            $cookie_value = "N";
            setcookie($cookie_name, $cookie_value, time() - 1 ); // delete
            header('Location: /PHP/betting/Upload/index.php') ;
?>