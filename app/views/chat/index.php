<?php
include APPROOT . 'views/inc/header.php';
include APPROOT . 'views/inc/nav.php'; ?>
<input type="hidden" id="hdnSession" data-value="<?php echo($_SESSION['name'] . ' ' . $_SESSION['department']); ?>"/>
<!--<section style="height: 30px" class="purple mb-3">-->
<h3 class="pl-5 pt-4 text-white justify-center">Chat</h3>
<!--</section>-->

<container>
    <div class=" mx-auto
          bg-light rounded-lg shadow-lg w-75 mb-3">
        <div class="d-flex rounded-lg" style="min-height: 30rem;">
            <div class="d-flex flex-column purple-dark w-25 rounded" style="min-width: 14rem;">
                <h4 class="mx-auto text-white p-2 mt-2 border-bottom">Rooms</h4>
                <a href="#" class="d-block a h6 py-3 text-center text-white purple-hover">Main</a>
            </div>
            <div class="d-flex flex-column flex-grow-1 p-2 justify-content-between" id="chat">
                <div class="messages flex-grow-1 d-flex flex-column mt-3">
                    <div class="form-control messages_display d-flex flex-column flex-grow-1 chat" >
                        <?php foreach ($data['messages'] as $message) : ?>
                          <?php if($message->user_id == $_SESSION['user_id']){ ?>
                              <div class="bubble you d-flex justify-content-end mb-2">
                                <i class="mr-auto"><?php echo $message->added_at; ?></i>
                                <?php echo $message->message; ?>
                             </div>
                        <?php  }else{ ?>
                          <div class="bubble me d-flex justify-content-start mb-2">
                              <?php echo $message->message; ?> <br>
                              <i class="ml-auto"><?php echo $message->added_at; ?></i>
                          </div>
                      <?php    } ?>

                        <?php endforeach; ?>
                    </div>
                    <br/>
                </div>
                <div class="bar d-flex bg-light rounded-lg">
                    <input class="d-block w-75 form-control input_message" type="text" placeholder="Type a message">
                    <div class="form-group input_send_holder flex-grow-1 mx-2">
                        <input type="submit" value="Send" class="btn purple btn-block text-white input_send"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</container>

<script type="text/javascript">

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Add API Key & cluster here to make the connection
    var pusher = new Pusher('eb919bea65bec5f2e34d', {
        cluster: 'eu',
        encrypted: true
    });

    // Enter a unique channel you wish your users to be subscribed in.
    var channel = pusher.subscribe('chat_channel');

    // bind the server event to get the response data and append it to the message div
    channel.bind('my_event',
        function (data) {
            console.log(data);
            $('.messages_display').append('<div class="bubble you">' + data + '</div>');
            $('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn purple text-white btn-block input_send" />');
            //$('.messages_display').scrollTop($(".messages_display")[0].scrollHeight);
        });

    // check if the user is subscribed to the above channel
    channel.bind('pusher:subscription_succeeded', function (members) {
        console.log('successfully subscribed!');
    });

    // Send AJAX request to the PHP file on server
    function ajaxCall(ajax_url, ajax_data) {
        $.ajax({
            type: "POST",
            url: ajax_url,
            //dataType: "json",
            data: ajax_data,
            success: function (response) {
                console.log(response);
            },
            error: function (msg) {
            }
        });
    }

    // Trigger for the Enter key when clicked.
    $.fn.enterKey = function (fnc) {
        return this.each(function () {
            $(this).keypress(function (ev) {
                var keycode = (ev.keyCode ? ev.keyCode : ev.which);
                if (keycode == '13') {
                    fnc.call(this, ev);
                }
            });
        });
    }

    var sessionValue = $("#hdnSession").data('value');

    // Send the Message enter by User
    $('body').on('click', '.input_send', function (e) {
        e.preventDefault();

        var message = $('.input_message').val();
        var name = sessionValue;

        console.log(message);
        console.log(name);


        if (message !== '') {
            // Define ajax data
            var chat_message = {
                name: name,
                message: '<strong>' + name + '</strong>: ' + message
            }
            console.log(chat_message);
            // Send the message to the server passing File Url and chat person name & message
            ajaxCall('<?php echo URLROOT; ?>/chat/message', chat_message);

            // Clear the message input field
            $('.input_message').val('');
            // Show a loading image while sending
            // $('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary btn-block" disabled /> &nbsp;<img     src = "loading.gif" />');
        }
    });

    // Send the message when enter key is clicked
    $('.input_message').enterKey(function (e) {
        e.preventDefault();
        $('.input_send').click();
    });
</script>

<?php include APPROOT . 'views/inc/footer.php'; ?>
