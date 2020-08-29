<?php

class PagesController extends Controller
{

    public function __construct()
    {
        // Check if $_COOKIE is already set
        if( isset($_COOKIE['rememberu']))
        {
            $this->db = new Connection();
            $this->userModel = $this->model('User');
            // Decrypt cookie variable value
            $id = $this->decryptCookie($_COOKIE['rememberu']);
            // die($id);
            //Check if user still exists
            $sql = "select * from users where id=:id";
            //Prepare
            $this->db->query($sql);
            //Bind
            $this->db->bind(':id', $id);
            //Execute
            if($row = $this->db->single())
            {
                $dep = $this->userModel->getDepartment($row->department);
                createUserSession($row, $dep);
                $this->index();
            }
        }
		elseif (!isLoggedIn()) {
            redirect('users/login');
        }
    }

    public function index()
    {
        

        $data = [
            'title' => SITENAME,
        ];


        $this->view('pages/index', $data);
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

	// // Decrypt cookie
    public function decryptCookie( $ciphertext ) 
    {
		$cipher = "aes-256-cbc";
		
		list($encrypted_data, $iv,$key) = explode('::', base64_decode($ciphertext));
		return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
    }

    public function createUserSession($user, $dep)
    {
        
        $_SESSION['user_id'] = $user->id;
        // print_r($_SESSION); die();
        $_SESSION['user_role'] = $user->role;
        $_SESSION['name'] = $user->first_name;
        $_SESSION['department'] = $dep->name;
        redirect('pages');
    }
}