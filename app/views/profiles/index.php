<?php
include APPROOT . 'views/inc/header.php';
include APPROOT . 'views/inc/nav.php'; ?>
<!--<section style="height: 30px" class="purple mb-3">-->
    <h3 class="pl-5 pt-5 text-white lead justify-center myprofile">My Profile</h3>
<!--</section>-->

<container>
    <div class=" mt-4 border border-gray py-5 px-3 mx-auto
          bg-light rounded-lg shadow-lg w-75 mb-3">
        <div class="row">
            <div class="col-sm-3 border-right text-center">
                <div class="py-3">
                    <img class="rounded-circle" width="150px"
                    src="<?php echo URLROOT; ?> /public/img/<?php if(isset($_SESSION['profileImg'])) { echo $_SESSION['profileImg']; } else {?>profile_picture.jpg <?php }?>"
                         alt="">
                    <span class="uploadImg align-bottom">
                      <i class="fa fa-file-photo-o" style="font-size:24px;color:purple" id="btnShowImgForm" type="button"></i>
                    </span>
                    <form class="ImgForm mt-1" name="imgForm" id="imgForm" action="<?php echo URLROOT . '/profiles/updateProfileImg'; ?>" method="post" enctype="multipart/form-data">
                      <div class="custom-file"> <!-- mr-1 -->
                        <input type="hidden" name="MAX_FILE_SIZE" value="60000000">
                        <input type="file" class="custom-file-input" id="newImg" name="newImg">
                        <label class="custom-file-label fileName" for="newImg">Choose image</label>
                      </div>
                    <button type="submit" class="btn mt-1" id="saveImg">Update Profile Picture</button> <!-- in class: purple purple-hover -->
                    </form>
                </div>
                <div class="card" id="userNamesEdit">
                  <h5 class="card-header h5">Change Your Name</h5>
                  <div class="card-body">
                    <!-- <label for="firstname"><h5>First name</h5></label> -->
                     <input type="text" class="form-control-plaintext" name="firstname" id="pr-fname" value=<?php echo $data['user']->first_name;?>>
                    <!-- <label for="flastname"><h5>Last name</h5></label> -->
                     <input type="text" class="form-control-plaintext" name="lastname" id="pr-lname" value=<?php echo $data['user']->last_name;?>>
                  </div>
                </div>
                <div class="text-center" id="userIdDiv" value="<?php echo $data['user']->id; ?>">
                   <h4 class="display-4 pb-3" id="userNames">
                        <?php echo $data['user']->first_name . ' ' . $data['user']->last_name; ?>
                    </h4>
                  </div>
                  <div class="text-left pl-2 mb-4">
                    <h4 class="lead text-purple pb-3"><i class="fas fa-users pr-5"></i><?php echo $_SESSION['department']; ?></h4>
                    <h4 class="lead text-purple pb-3 "><i class="fas fa-user-tag pr-5"></i> <?php echo $data['user']->username; ?></h4>
                    <h4 class="lead"><a href="mailto:<?php echo $data['user']->email; ?>" class="a text-purple">
                      <i class="fas fa-envelope-open-text pr-5"></i>Email:</h4>
                      <h4 class="lead text-purple pb-3 "><?php echo $data['user']->email; ?></a></h4>

                </div>
            </div>
            <div class="col-sm-4 border-right">
              <h3 class="card-title fontlarge font-italic mb-5"><strong>Availability</strong></h3>
              <form class="" action="<?php echo URLROOT . '/profiles'; ?>" method="post">
              <?php $daysOfWeek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
              for ($i=0; $i < 6; $i++) { ?>

                <div class="card white shadow-sm p-0 mb-2 bg-white rounded">
                  <div class="card-image" style="background-image: url(https://htmlcolors.com/gradients-images/53-light-purple-gradient.jpg);">
                    <!-- Content -->
                    <div class="text-white d-flex h-100 mask purple-gradient-rgba p-2">
                      <div class="col-sm-8" ><h3 class="card-title"><?php echo $daysOfWeek[$i] ?></h3></div>
                      <div class="col-sm-4" ><input type="checkbox" <?php echo "id ='toggleON" . $i . " ' "; ?> name = "toggleON[]" <?php echo "value='" . $daysOfWeek[$i] . "'"; ?>
                         <?php $availbility = $data['availability']; if($availbility[$i] == '1'){  echo "checked ='1'"; }?>
                          data-toggle="toggle" data-style="ios" data-on="Yes" data-off="No"  data-offstyle="dark"></div>
                    </div>
                  </div>
                </div>
                <!-- Card -->
              <?php } ?>
              <button type="submit" class="btn purple purple-hover text-white float-right pr-5 pl-5" name= "saveAvailability" id="saveAvailBtn">Save</button>
              </form>
            </div>
            <div class="col-sm-5 d-flex flex-column text-wrap">
              <h3 class="card-title fontlarge font-italic mb-5"><strong>Personal information</strong></h3>
              <div class="card white shadow p-4 pr-2 bg-white rounded">
              <div class="form-group row mb-1 m-0">
                <label class="col-sm-3 col-form-label"><h4 class="fontlarge pb-2 text-right">Date of Birth:</h4></label>
                <div class="col-sm-6">
                  <input type="text" readonly class="form-control-plaintext fontlarge font-italic" id="pr-dob" value=<?php echo $data['user']->date_of_birth; ?>>
                </div>
              </div>
              <div class="form-group row mb-1 m-0">
                <label class="col-sm-3 col-form-label"><h4 class="fontlarge pb-2 text-right">Address:</h4></label>
                <div class="col">
                  <input type="text" readonly class="form-control-plaintext fontlarge font-italic" id="pr-address" value="<?php echo $data['user']->address; ?>">
                </div>
              </div>
              <div class="form-group row  mb-1 m-0">
                <label class="col-sm-3 col-form-label"><h4 class="fontlarge pb-2 text-right">Phone:</h4></label>
                <div class="col-sm-6">
                  <input type="text" readonly class="form-control-plaintext fontlarge font-italic" id="pr-phone" value=<?php echo $data['user']->phone; ?>>
                </div>
              </div>
              <div class="form-group row mb-1 m-0">
                <label class="col-sm-3 col-form-label"><h4 class="fontlarge pb-2 text-right">Email:</h4></label>
                <div class="col">
                  <input type="text" readonly class="form-control-plaintext fontlarge font-italic" id="pr-email" value=<?php echo $data['user']->email; ?>>
                </div>
              </div>
              <div class="form-group row mb-1 m-0">
                <label class="col-sm-3 col-form-label"><h4 class="fontlarge pb-2 text-right">Date of Start:</h4></label>
                <div class="col-sm-6">
                  <input type="text" readonly class="form-control-plaintext fontlarge font-italic" id="readProp" value=<?php echo $data['user']->date_of_start; ?>>
                </div>
              </div>
              <div class="form-group row mb-1 m-0">
                <label class="col-sm-3 col-form-label"><h4 class="fontlarge pb-2 text-right">Salary:</h4></label>
                <div class="col-sm-6">
                  <input type="text" readonly class="form-control-plaintext fontlarge font-italic" id="readPropSal" value=<?php echo $data['user']->salary; ?> $>
                </div>
              </div>
              <button type="button" class="btn purple purple-hover text-white" id="StartEditBtn">Edit Info</button>
              <button type="button" class="btn purple purple-hover text-white" id="EditProfileBtn">Edit Info</button>

                <!-- <a  href="<?php //echo URLROOT; ?>/profiles/edit" class="btn purple purple-hover text-white" id="EditProfileBtn">Edit Info</a> -->
            </div>
          </div>
        </div>


    </div>
</container>

<?php include APPROOT . 'views/inc/footer.php'; ?>
