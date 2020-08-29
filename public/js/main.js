let id;
let fname;
let lname;
let email;
let dob;
let phone;
let address;


$(document).ready(function () {
    // function openUploadPhoto() {
    //   $('.uploadPhoto').css('display', 'block');
    // }

    // $("#chat").scrollTop($("#chat")[0].scrollHeight);

    $('#day').hide();
    $("#EditProfileBtn").click(function () {
        validateUpdateProfile();
        UnmarkFields();
    })

    $("#saveAvailBtn").click(function () {
        $("#saveAvailBtn").css("display", "none");
    })
    $("input[name*='toggleON']").change(function () {
        $("#saveAvailBtn").css("display", "block");
    })

    $("#sendRequestBtn").click(function(){
      checkInputRequest();
    })

    $("#StartEditBtn").click(function () {
        $("#StartEditBtn").css("display", "none");
        $("#EditProfileBtn").css("display", "block");
        $("#userNamesEdit").css("display", "block");
        $("#userNames").css("display", "none");
        $(".form-control-plaintext").prop('readonly', false);
        $("#readProp").prop('readonly', true);
        $("#readPropSal").prop('readonly', true);
        $(".form-control-plaintext").css("border-bottom", "2px solid lightgrey");
        $("#readProp").css("border-bottom", "none");
        $("#readPropSal").css("border-bottom", "none");
    })
    $('#requestModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var product = button.data('btn'); // Extract info from data-* attributes
      var prId = button.data('id');
      var modal = $(this);
      var hrefpr = modal.find('.req').prop('action');
      modal.find('.head').text(product);
      modal.find('.req').attr('action', hrefpr + prId);
      modal.find('.modal-body input').val("0");
    })

    $("#timeSelector").change(function () {
        if ($(this).val() === 'Day') {
            //alert('day');
            $('#week').hide();
            $('#day').show();
        } else {
            //alert('week')
            $('#day').hide();
            $('#week').show();
        }
    })
});

function checkInputRequest(){
  var numberformat = /^[0-9]+$/;
  quantity = $("#quantitypr").val();
  if(!quantity.match(numberformat)){
    alert("Please enter a valid quantity");
    return false;
  }else if(parseInt(quantity) < 0){
    alert("Please enter a positive number");
    return false;
  }else{
    return true;
  }
}

function validateUpdateProfile() {
    id = $("#userIdDiv").attr("value");
    fname = $("#pr-fname").val();
    lname = $("#pr-lname").val();
    email = $("#pr-email").val();
    dob = $("#pr-dob").val();
    phone = $("#pr-phone").val();
    address = $("#pr-address").val();

    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var numberformat = /^[0-9]+$/;
    var date_regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
    if (fname == "" || lname == "") {
        alert("Name must be filled out");
        return false;
    } else if (email == "") {
        alert("Email must be added");
        return false;
    } else if (!email.match(mailformat)) {
        alert("Email must be in correct format.");
        return false;
    } else if (!(date_regex.test(dob)) || dob == "") {
        alert("Date of birth should be in correct format");
        return false;
    } else if (!phone.match(numberformat) && phone != "") {
        alert("Phone number must contain only digits.");
        return false;
    } else {
        if (confirm('Are you sure you want to update your profile?')) {
            UpdateUserProfile();
        } else {
            // Do nothing!
        }
    }
}

function UpdateUserProfile() {
    let updateUser = {
        id: id,
        first_name: fname,
        last_name: lname,
        email: email,
        date_of_birth: dob,
        phone: phone,
        address: address
    };

    var myJSON = JSON.stringify(updateUser);
    $.ajax({
        url: window.location.href,
        type: "POST",
        data: {
            updateUser: myJSON
        },
        success: function () {
            location.reload();
            alert("Update was successful!");
        }
    });
}

function UnmarkFields() {
    $("#StartEditBtn").css("display", "block");
    $("#EditProfileBtn").css("display", "none");
    $("#userNamesEdit").css("display", "none");
    $("#userNames").css("display", "block");
    $(".form-control-plaintext").prop('readonly', true);
    $(".form-control-plaintext").css("border-bottom", "none");
}

//Profile image
$imgIconCounter = 0;
$(document).ready(function () {
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $("#btnShowImgForm").click(function () {
        if ($imgIconCounter === 0) {
            $(".ImgForm").css("display", "block");
            $imgIconCounter++;
        } else {
            $(".ImgForm").css("display", "none");
            $imgIconCounter--;
        }
    })
    $("#saveImg").click(function () {
        $(".ImgForm").css("display", "none");
    })
})
