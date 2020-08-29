<?php

//Start session
session_start();

//Flash messages
function flash($name = '', $message = '', $class = 'flash-success p-2 purple mx-auto mb-2 rounded-lg')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }

    }
}

function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
        return true;
    }
    else{
        return false;
    }
}

function createUserSession($user, $dep)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_role'] = $user->role;
        $_SESSION['name'] = $user->first_name;
        $_SESSION['department'] = $dep->name;
        $_SESSION['profileImg'] = $user->img;
    }
