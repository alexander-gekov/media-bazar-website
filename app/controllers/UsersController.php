<?php

class UsersController extends Controller
{

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $this->view('user/login'); 
    }

    public function login()
    {

        //POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //Sanitize
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'username' => trim($_POST["username"]),
                'password' => trim($_POST["password"]),
                'username_err' => '',
                'password_err' => '',
                'r_username' => '',
            ];
            if (empty($data['username'])) {
                $data['username_err'] = "Please enter username.";
            }

            if (empty($data['password'])) {
                $data['password_err'] = "Please enter password.";
            }

            //Check for username
            if ($this->userModel->findUserByUsername($data['username'])) {
                //User found
            } else {
                $data['username_err'] = 'User not found';
            }

            if (empty($data['username_err']) && empty($data['password_err'])) {

                $loggedUser = $this->userModel->login($data['username'], $data['password']);
                
                //Check if password is correct
                if ($loggedUser) {
                    
                    //Check role
                    if(!($loggedUser->role === 'EMPLOYEE'))
                    {
                        $data['username_err'] = "Only employees are allowed";
                        $this->view('/users/login', $data);
                    } else { 
                        
                        //Remember me:
                        if(!(empty($_POST["defaultLoginFormRemember"])))
                        {
                            setcookie("rememberu", $this->encryptCookie($loggedUser->id), time() + (30 * 24 * 60 * 60 * 1000), '/');
                            // print_r($this->decryptCookie($_COOKIE['rememberu']));die();
                            //box is ticked -> working 
                            // setcookie("rememberu", $this->encryptCookie($loggedUser->id), time() + (30 * 24 * 60 * 60 * 1000)); //30 days
                            // echo $this->decryptCookie($_COOKIE['rememberu']);
                            // die();
                        }

                        $dep = $this->userModel->getDepartment($loggedUser->department);
                        createUserSession($loggedUser, $dep);
                        redirect('pages');
                        
                    }
                } else {
                    $data['password_err'] = 'Password incorrect';

                    $this->view('/users/login', $data);
                }
            } else {
                //Load form with errors
                $this->view('/users/login', $data);
            }
        } else {
            $data = ['username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => '',];

            //Load Form
            $this->view('/users/login', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        session_destroy();
        //Remove cookie remember me
        setcookie ("rememberu","", time() - (30 * 24 * 60 * 60 * 1000), '/' );
        redirect('users/login');
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
    
    //Encrypt cookie
    public function encryptCookie( $value ) 
    {
        $key = '01478'; //hex2bin(openssl_random_pseudo_bytes(4))
      
        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
    
        $ciphertext = openssl_encrypt($value, $cipher, $key, 0, $iv);
    
        return( base64_encode($ciphertext . '::' . $iv. '::' .$key) );
    }

    //Decrypt cookie
    public function decryptCookie( $ciphertext ) 
    {
		$cipher = "aes-256-cbc";
		
		list($encrypted_data, $iv,$key) = explode('::', base64_decode($ciphertext));
		return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
    }

    public function reset()
    {
//POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'new_password' => trim($_POST["new_password"]),
                'confirm_password' => trim($_POST["confirm_password"]),
                'password_err' => '',
                'confirm_password_err' => '',
            ];


            if (empty($data['new_password'])) {
                $data['new_password_err'] = "Please enter the new password.";
            } elseif (strlen($data['new_password']) < 6) {
                $data['new_password_err'] = "Password must have atleast 6 characters.";
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = "Please confirm the password.";
            } else {
                if (empty($data['new_password_err']) && ($data['new_password'] != $data['confirm_password'])) {
                    $data['confirm_password_err'] = "Password did not match.";
                }
            }

            if (empty($data['new_password_err']) && empty($data['confirm_password_err'])) {
                $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
                if ($this->userModel->reset($_SESSION['user_id'], $data['new_password'])) {
                    //Flash
                    flash('password_change_success', 'You successfully changed your password.');
                    //Redirect
                    redirect('users/reset');
                } else {
                    die('Something went wrong.');
                }
            } else {
                //Load view with errors
                $this->view('users/reset', $data);
            }
        } else {
            $data = [
                'new_password' => '',
                'confirm_password' => '',
                'new_password_err' => '',
                'confirm_password_err' => '',
            ];

            //Load Form
            $this->view('users/reset', $data);
        }

    }
}