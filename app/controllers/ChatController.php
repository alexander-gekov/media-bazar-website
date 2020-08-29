<?php

require_once  ROOT . '/vendor/autoload.php';

class ChatController extends Controller
{

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->requestModel = $this->model('Request');
        $this->chatModel = $this->model('Chat');
    }

    public function index()
    {
        $departments = $this->requestModel->getDepartments();
        $messages = $this->chatModel->getPreviousMessages();

        $data = [
            'departments' => $departments,
            'messages' => $messages
        ];
        $this->view('chat/index', $data);
    }

    public function message()
    {
// Change the following with your app details:

// Create your own pusher account @ https://app.pusher.com


        $options = array(

            'cluster' => 'eu',

            'encrypted' => true

        );

        $pusher = new Pusher\Pusher(

            'eb919bea65bec5f2e34d',

            'b26342ac729300156cb7',

            '1015343',

            $options

        );


// Check the receive message

        if (isset($_POST['message']) && !empty($_POST['message'])) {

            $data = $_POST['message'];


// Return the received message

            if ($pusher->trigger('chat_channel', 'my_event', $data)) {

                $this->chatModel->saveMessage($data);
                echo 'success';

            } else {

                echo 'error';

            }

        }

    }
}
