<?php
include APPROOT . 'views/inc/header.php';
include APPROOT . 'views/inc/nav.php'; ?>
<!--<section style="height: 30px" class="purple mb-3">-->
<!--    <div>-->
<div>

    <h3 class="pl-5 pt-4 text-white justify-center"><i class="far fa-calendar-alt"></i> Shifts</h3>
    <select name="time" id="timeSelector" class="form-control form-control-sm float-right mr-2" style="width:20%">
        <option value="Week">Week</option>
        <option value="Day">Day</option>
    </select>
</div>


<!--    </div>-->
<!--</section>-->

<container id="shifts">
    <div class="mt-2 border border-gray px-5 py-3 mt-20 ml-2 mr-2
          rounded-lg shadow-lg bg-light mb-3">
        <div class="row">
            <?php flash('request_added'); ?>
        </div>
        <div class="current-shift border border-gray py-4 px-5 mx-auto
          rounded-lg bg-white mb-4">
            <div>
                <div class="d-flex flex-column text-center">
                    <h4>Current Shift</h4>
                    <?php if (!empty($data["current_shift"])) : ?>
                        <p>Shift Id: <?php echo $data["current_shift"]->shift_id; ?></p>
                        <p>Shift Time: <?php echo $data["current_shift"]->shift_time; ?></p>
                        <p>Shift Date: <?php echo $data["current_shift"]->weekday; ?></p>
                        <p>Started at: <?php if (empty($data["current_shift"]->start_shift)) {
                                echo 'Not Started Yet';
                            } else {
                                echo $data["current_shift"]->start_shift;
                            } ?></p>
                        <p>Finished at: <?php if (empty($data["current_shift"]->end_shift)) {
                                echo 'Not Ended Yet';
                            } else {
                                echo $data["current_shift"]->end_shift;
                            } ?></p>
                    <?php endif; ?>
                    <?php if (!empty($data["current_shift"]->end_shift)) : ?>
                        Shift has ended!
                    <?php endif; ?>
                </div>
                <div class="d-flex flex-column">
                    <?php if (empty($data["current_shift"]->start_shift) && !empty($data["current_shift"])) : ?>
                        <form action="<?php echo URLROOT; ?>/shifts/start/<?php echo $data['current_shift']->shift_id; ?>"
                              method="post">
                            <button class="btn purple purple-hover mb-3 text-white w-100">
                                Start
                            </button>
                        </form>
                    <?php endif; ?>
                    <?php if (!empty($data["current_shift"]->start_shift) && empty($data["current_shift"]->end_shift)) : ?>
                        <form action="<?php echo URLROOT; ?>/shifts/stop/<?php echo $data['current_shift']->shift_id; ?>"
                              method="post">
                            <button class="btn purple purple-hover text-white w-100">
                                Stop
                            </button>
                        </form>
                    <?php endif; ?>
                    <?php if (empty($data["current_shift"])) : ?>
                        <div class="alert alert-dark mx-auto" role="alert">
                            You are not assigned to this shift.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div id="week">
            <div class="row d-flex">
                <?php $daysOfWeek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
                for ($i = 0; $i < 6; $i++) : ?>
                    <div class="col-sm-2 border bg-white text-center rounded-lg py-3 mb-2">
                        <strong><?php echo $daysOfWeek[$i]; ?></strong>
                        <?php $timeOfShifts = array("MORNING", "AFTERNOON", "EVENING");
                        for ($j = 0; $j < 3; $j++) : ?>
                            <hr>
                            <?php echo ucfirst(strtolower($timeOfShifts[$j]));
                            if ($data["shifts"]["$daysOfWeek[$i]"]["$timeOfShifts[$j]"]['working']): ?>
                                ✅
                                <a id="chill<?php echo $data["shifts"]["$daysOfWeek[$i]"]["$timeOfShifts[$j]"]['id'] ?>"
                                   href="<?php echo URLROOT; ?>/shifts/chill/<?php echo $data["shifts"]["$daysOfWeek[$i]"]["$timeOfShifts[$j]"]['id'] ?>"
                                   class="btn btn-light chill">Chill</a>
                            <?php else: ?>
                                ❌
                                <a id="work<?php echo $data["shifts"]["$daysOfWeek[$i]"]["$timeOfShifts[$j]"]['id'] ?>"
                                   href="<?php echo URLROOT; ?>/shifts/work/<?php echo $data["shifts"]["$daysOfWeek[$i]"]["$timeOfShifts[$j]"]['id'] ?>"
                                   class="btn btn-light work">Work</a>
                            <?php endif;
                        endfor; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
        <div id="day">
            <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

                <!--Controls-->
                <div class="mx-auto p-2" style="width: 50px;">
                    <div class="controls-top d-block mx-auto">
                        <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i
                                    class="fas fa-chevron-left"></i></a>
                        <a class="btn-floating" href="#multi-item-example" data-slide="next"><i
                                    class="fas fa-chevron-right"></i></a>
                    </div>
                </div>

                <!--/.Controls-->

                <!--               // Indicators-->
                <div>
                    <ol class="carousel-indicators">
                        <li data-target="#multi-item-example" data-slide-to="0" class="active bg-dark"></li>
                        <li data-target="#multi-item-example" data-slide-to="1" class="bg-dark"></li>
                        <li data-target="#multi-item-example" data-slide-to="2" class="bg-dark"></li>
                        <li data-target="#multi-item-example" data-slide-to="3" class="bg-dark"></li>
                        <li data-target="#multi-item-example" data-slide-to="4" class="bg-dark"></li>
                        <li data-target="#multi-item-example" data-slide-to="5" class="bg-dark"></li>
                    </ol>
                </div>

                <!--                //.Indicators-->

                <!--Slides-->
                <div class="carousel-inner" role="listbox">

                    <?php $daysOfWeek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"); ?>
                    <!--First slide-->
                    <div class="carousel-item active">

                        <div class="col-lg-4 offset-lg-4 col-sm-12 offset-sm-0 align-self-center border bg-white text-center rounded-lg py-3 mb-2">
                            <strong><?php echo $daysOfWeek[0]; ?></strong>
                            <?php $timeOfShifts = array("MORNING", "AFTERNOON", "EVENING");
                            for ($j = 0; $j < 3; $j++) : ?>
                                <hr>
                                <?php echo ucfirst(strtolower($timeOfShifts[$j]));
                                if ($data["shifts"]["$daysOfWeek[0]"]["$timeOfShifts[$j]"]['working']): ?>
                                    ✅
                                    <a id="chill<?php echo $data["shifts"]["$daysOfWeek[0]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/chill/<?php echo $data["shifts"]["$daysOfWeek[0]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light chill">Chill</a>
                                <?php else: ?>
                                    ❌
                                    <a id="work<?php echo $data["shifts"]["$daysOfWeek[0]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/work/<?php echo $data["shifts"]["$daysOfWeek[0]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light work">Work</a>
                                <?php endif;
                            endfor; ?>
                        </div>

                    </div>
                    <!--/.First slide-->

                    <!--Second slide-->
                    <div class="carousel-item">

                        <div class="col-lg-4 offset-lg-4 col-sm-12 offset-sm-0 align-self-center border bg-white text-center rounded-lg py-3 mb-2">
                            <strong><?php echo $daysOfWeek[1]; ?></strong>
                            <?php $timeOfShifts = array("MORNING", "AFTERNOON", "EVENING");
                            for ($j = 0; $j < 3; $j++) : ?>
                                <hr>
                                <?php echo ucfirst(strtolower($timeOfShifts[$j]));
                                if ($data["shifts"]["$daysOfWeek[1]"]["$timeOfShifts[$j]"]['working']): ?>
                                    ✅
                                    <a id="chill<?php echo $data["shifts"]["$daysOfWeek[1]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/chill/<?php echo $data["shifts"]["$daysOfWeek[1]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light chill">Chill</a>
                                <?php else: ?>
                                    ❌
                                    <a id="work<?php echo $data["shifts"]["$daysOfWeek[1]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/work/<?php echo $data["shifts"]["$daysOfWeek[1]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light work">Work</a>
                                <?php endif;
                            endfor; ?>
                        </div>

                    </div>
                    <!--Third slide-->
                    <div class="carousel-item">

                        <div class="col-lg-4 offset-lg-4 col-sm-12 offset-sm-0 align-self-center border bg-white text-center rounded-lg py-3 mb-2">
                            <strong><?php echo $daysOfWeek[2]; ?></strong>
                            <?php $timeOfShifts = array("MORNING", "AFTERNOON", "EVENING");
                            for ($j = 0; $j < 3; $j++) : ?>
                                <hr>
                                <?php echo ucfirst(strtolower($timeOfShifts[$j]));
                                if ($data["shifts"]["$daysOfWeek[2]"]["$timeOfShifts[$j]"]['working']): ?>
                                    ✅
                                    <a id="chill<?php echo $data["shifts"]["$daysOfWeek[2]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/chill/<?php echo $data["shifts"]["$daysOfWeek[2]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light chill">Chill</a>
                                <?php else: ?>
                                    ❌
                                    <a id="work<?php echo $data["shifts"]["$daysOfWeek[2]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/work/<?php echo $data["shifts"]["$daysOfWeek[2]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light work">Work</a>
                                <?php endif;
                            endfor; ?>
                        </div>

                    </div>
                    <!--Forth slide-->
                    <div class="carousel-item">

                        <div class="col-lg-4 offset-lg-4 col-sm-12 offset-sm-0 align-self-center border bg-white text-center rounded-lg py-3 mb-2">
                            <strong><?php echo $daysOfWeek[3]; ?></strong>
                            <?php $timeOfShifts = array("MORNING", "AFTERNOON", "EVENING");
                            for ($j = 0; $j < 3; $j++) : ?>
                                <hr>
                                <?php echo ucfirst(strtolower($timeOfShifts[$j]));
                                if ($data["shifts"]["$daysOfWeek[3]"]["$timeOfShifts[$j]"]['working']): ?>
                                    ✅
                                    <a id="chill<?php echo $data["shifts"]["$daysOfWeek[3]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/chill/<?php echo $data["shifts"]["$daysOfWeek[3]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light chill">Chill</a>
                                <?php else: ?>
                                    ❌
                                    <a id="work<?php echo $data["shifts"]["$daysOfWeek[3]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/work/<?php echo $data["shifts"]["$daysOfWeek[3]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light work">Work</a>
                                <?php endif;
                            endfor; ?>
                        </div>

                    </div>
                    <!--Fifth slide-->
                    <div class="carousel-item">

                        <div class="col-lg-4 offset-lg-4 col-sm-12 offset-sm-0 align-self-center border bg-white text-center rounded-lg py-3 mb-2">
                            <strong><?php echo $daysOfWeek[4]; ?></strong>
                            <?php $timeOfShifts = array("MORNING", "AFTERNOON", "EVENING");
                            for ($j = 0; $j < 3; $j++) : ?>
                                <hr>
                                <?php echo ucfirst(strtolower($timeOfShifts[$j]));
                                if ($data["shifts"]["$daysOfWeek[4]"]["$timeOfShifts[$j]"]['working']): ?>
                                    ✅
                                    <a id="chill<?php echo $data["shifts"]["$daysOfWeek[4]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/chill/<?php echo $data["shifts"]["$daysOfWeek[4]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light chill">Chill</a>
                                <?php else: ?>
                                    ❌
                                    <a id="work<?php echo $data["shifts"]["$daysOfWeek[4]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/work/<?php echo $data["shifts"]["$daysOfWeek[4]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light work">Work</a>
                                <?php endif;
                            endfor; ?>
                        </div>

                    </div>
                    <!--Sixth slide-->
                    <div class="carousel-item">

                        <div class="col-lg-4 offset-lg-4 col-sm-12 offset-sm-0 align-self-center border bg-white text-center rounded-lg py-3 mb-2">
                            <strong><?php echo $daysOfWeek[5]; ?></strong>
                            <?php $timeOfShifts = array("MORNING", "AFTERNOON", "EVENING");
                            for ($j = 0; $j < 3; $j++) : ?>
                                <hr>
                                <?php echo ucfirst(strtolower($timeOfShifts[$j]));
                                if ($data["shifts"]["$daysOfWeek[5]"]["$timeOfShifts[$j]"]['working']): ?>
                                    ✅
                                    <a id="chill<?php echo $data["shifts"]["$daysOfWeek[5]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/chill/<?php echo $data["shifts"]["$daysOfWeek[5]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light chill">Chill</a>
                                <?php else: ?>
                                    ❌
                                    <a id="work<?php echo $data["shifts"]["$daysOfWeek[5]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       href="<?php echo URLROOT; ?>/shifts/work/<?php echo $data["shifts"]["$daysOfWeek[5]"]["$timeOfShifts[$j]"]['id'] ?>"
                                       class="btn btn-light work">Work</a>
                                <?php endif;
                            endfor; ?>
                        </div>

                    </div>

                    <!--/.Second slide-->


                </div>
                <!--/.Slides-->

            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">

          <!-- Button trigger modal -->
          <button type="button" class="btn purple purple-hover text-white pr-4 pl-4" data-toggle="modal" data-target="#exampleModalCenter">
            Statistics
          </button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Weekly Statistics</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table table-sm table-light">
                    <thead>
                      <tr>
                        <th scope="col">All shifts</th>
                        <th scope="col"><?php echo $data["allShifts"]; ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">On time</th>
                        <td class="bg-success"><?php echo $data["onTime"]; ?> </td>
                      </tr>
                      <tr>
                        <th scope="row">Late</th>
                        <td class="bg-warning"><?php echo $data["late"]; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Missed</th>
                        <td class="bg-danger"><?php echo $data["missed"]; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Forthcoming</th>
                        <td class="bg-info"><?php echo $data["forthcoming"]; ?> </td>
                      </tr>
                    </tbody>
                  </table>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--    <div class="row d-flex justify-content-center pt-4">-->
        <!--        <a href="-->
        <?php //echo URLROOT; ?><!--/shifts/edit" class="btn purple purple-hover text-white">Request Change</a>-->
        <!--    </div>-->
    </div>
</container>

<?php include APPROOT . 'views/inc/footer.php'; ?>
