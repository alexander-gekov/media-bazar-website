<?php

class ProfilesController extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $availability = $this->getAvailabilityArray();
        $data = [
            'user' => $user,
            'availability' => $availability,
            'Image_error' => ""
        ];

        if (isset($_POST['updateUser'])) {
          $this->UpdateProfile();
        }else if(isset($_POST['saveAvailability'])){
          $this->UpdateAvailability();

        }

        $this->view('profiles/index', $data);
    }

    public function UpdateProfile()
    {
      $user = utf8_encode($_POST['updateUser']); // encoding
      $data = json_decode($user);
      if( $this->userModel->updateUserProfile($data)){
        $userData = json_encode($data);
        echo $userData;
      }
    }

    //Update profile img
    public function updateProfileImg()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
          $img = $_FILES['newImg']['name'];
          if(!empty($img))
          {
            // $img = $_FILES['newImg']['name'];
            $imgSRC = $this->userModel->updateProfileImg($_SESSION['user_id'], $img);  
          }
          redirect('profiles/index.php');
        }
    }

    public function getAvailabilityArray()
    {
      $availabilityData = $this->userModel->getAvailability($_SESSION['user_id']);
      $availability = array($availabilityData->monday, $availabilityData->tuesday, $availabilityData->wednesday, $availabilityData->thursday, $availabilityData->friday, $availabilityData->saturday);
      return $availability;
    }

    public function UpdateAvailability()
    {
      $availabilityData = [
        'monday' => '0',
        'tuesday' => '0',
        'wednesday' => '0',
        'thursday' => '0',
        'friday' => '0',
        'saturday' => '0'
      ];
      foreach($_POST['toggleON'] as $selected) {
        switch ($selected) {
          case 'Monday':
          $availabilityData['monday'] = '1';
          break;
          case 'Tuesday':
          $availabilityData['tuesday'] = '1';
          break;
          case 'Wednesday':
          $availabilityData['wednesday'] = '1';
          break;
          case 'Thursday':
          $availabilityData['thursday'] = '1';
          break;
          case 'Friday':
          $availabilityData['friday'] = '1';
          break;
          case 'Saturday':
          $availabilityData['saturday'] = '1';
          break;
        }
      }
      $this->userModel->updateAvailability($_SESSION['user_id'], $availabilityData);
      redirect('profiles');
    }

}
