<?php

class ShiftsController extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->userModel = $this->model('User');
        $this->shiftModel = $this->model('Shift');
    }

    public function index()
    {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $shifts = $this->shiftModel->getShiftsByUserId($user->id);
        $all_shifts = [

            'Monday' => [
                'MORNING' => [
                    'working' => false,
                    'id' => 1,
                ],
                'AFTERNOON' => [
                    'working' => false,
                    'id' => 2,
                ],
                'EVENING' => [
                    'working' => false,
                    'id' => 3,
                ],
            ],
            'Tuesday' => [
                'MORNING' => [
                    'working' => false,
                    'id' => 4,
                ],
                'AFTERNOON' => [
                    'working' => false,
                    'id' => 5,
                ],
                'EVENING' => [
                    'working' => false,
                    'id' => 6,
                ],
            ],
            'Wednesday' => [
                'MORNING' => [
                    'working' => false,
                    'id' => 7,
                ],
                'AFTERNOON' => [
                    'working' => false,
                    'id' => 8,
                ],
                'EVENING' => [
                    'working' => false,
                    'id' => 9,
                ],
            ],
            'Thursday' => [
                'MORNING' => [
                    'working' => false,
                    'id' => 10,
                ],
                'AFTERNOON' => [
                    'working' => false,
                    'id' => 11,
                ],
                'EVENING' => [
                    'working' => false,
                    'id' => 12,
                ],
            ],
            'Friday' => [
                'MORNING' => [
                    'working' => false,
                    'id' => 13,
                ],
                'AFTERNOON' => [
                    'working' => false,
                    'id' => 14,
                ],
                'EVENING' => [
                    'working' => false,
                    'id' => 15,
                ],
            ],
            'Saturday' => [
                'MORNING' => [
                    'working' => false,
                    'id' => 16,
                ],
                'AFTERNOON' => [
                    'working' => false,
                    'id' => 17,
                ],
                'EVENING' => [
                    'working' => false,
                    'id' => 18,
                ],
            ],
        ];
        foreach ($shifts as $shift) {
            $day = $shift->weekday;
            $time = $shift->shift_time;
            $all_shifts["$day"]["$time"]['working'] = true;
        }

        $current_shift_id = $this->getCurrentShiftId();
        $current_shift_user = $_SESSION['user_id'];
        $current_shift = $this->shiftModel->getCurrentShift($current_shift_id, $current_shift_user);
        $hasStartedWork = '';
        if ($current_shift == null) {
            $hasStartedWork = false;
        } else {
            if ($current_shift->start_shift == null) {
                $hasStartedWork = false;
            } else {
                $hasStartedWork = true;
            }
        }
        $stats = $this->GetStatistics($user->id);
        $data = [
            'user' => $user,
            'shifts' => $all_shifts,
            'current_shift' => $current_shift,
            'working' => $hasStartedWork,
            'allShifts' => $stats['all'],
            'missed' => $stats['missed'],
            'late' => $stats['late'],
            'onTime' => $stats['onTime'],
            'forthcoming' => $stats['forthcoming'],
        ];

        $this->view('shifts/index', $data);
    }


    public function ShiftRequestExists($shift_id, $user_id)
    {
        $shifts = $this->shiftModel->getAllShiftRequests($user_id);
        foreach ($shifts as $shift) {
            if ($shift->shift_id == $shift_id) {
                return true;
            }
        }
        return false;
    }

    public function chill($id)
    {
        $user_id = $_SESSION['user_id'];
        if ($this->ShiftRequestExists($id, $user_id)) {
            flash('request_added', 'A request has already been sent.');
            redirect('shifts/index');
        } else {
            $this->shiftModel->Chill($id, $user_id);
            flash('request_added', 'Request sent.');
            redirect('shifts/index');
        }
    }

    public function work($id)
    {
        $user_id = $_SESSION['user_id'];
        if ($this->ShiftRequestExists($id, $user_id)) {
            flash('request_added', 'A request has already been sent.');
            redirect('shifts/index');
        } else {
            $this->shiftModel->Work($id, $user_id);
            flash('request_added', 'Request sent.');
            redirect('shifts/index');
        }
    }

    public function start($shift_id)
    {
        $user_id = $_SESSION['user_id'];
        if ($this->shiftModel->Start($shift_id, $user_id)) {
            flash('request_added', 'Shift Started!');
            redirect('shifts/index');
        } else {
            flash('request_added', 'Try Again!');
            redirect('shifts/index');
        }
    }

    public function stop($shift_id)
    {
        $user_id = $_SESSION['user_id'];
        if ($this->shiftModel->Stop($shift_id, $user_id)) {
            flash('request_added', 'Shift Ended!');
            redirect('shifts/index');
        } else {
            flash('request_added', 'Try Again!');
            redirect('shifts/index');
        }
    }

    public function getCurrentShiftId()
    {
        $morningShiftIds = [
            '0' => 1,
            '1' => 4,
            '2' => 7,
            '3' => 10,
            '4' => 13,
            '5' => 16,
        ];
        $day = date("w");
        $time = date("H:i");
        $morning_time = "8:50";
        $afternoon_time = "12:50";
        $evening_time = "16:50";
        $closing_time = "21:00";
        $morning = DateTime::createFromFormat('H:i', $morning_time)->format("H:i");
        $afternoon = DateTime::createFromFormat('H:i', $afternoon_time)->format("H:i");
        $evening = DateTime::createFromFormat('H:i', $evening_time)->format("H:i");
        $closing = DateTime::createFromFormat('H:i', $closing_time)->format("H:i");

        $index = $day - 1;
        if ($day = 0) {
            return 1;
        }
        if ($time > $morning && $time < $afternoon) {
            return $morningShiftIds[$index];
        }
        if ($time > $afternoon && $time < $evening) {
            return $morningShiftIds[$index] + 1;
        }
        if ($time > $evening && $time < $closing) {
            return $morningShiftIds[$index] + 2;
        } else {
            return $morningShiftIds[$index] + 3;
        }
    }

    public function GetStatistics($user_id)
    {
        $shifts = $this->shiftModel->getShiftsByUserId($user_id);
        $totalShifts = count($shifts);
        $missed = 0;
        $late = 0;
        $onTime = 0;
        $forthcoming = 0;
        $weekdays = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6];
        $day = date("w");
        $time = date("H:i");
        $morning_time = "9:10";
        $afternoon_time = "13:10";
        $evening_time = "17:10";
        $morning = DateTime::createFromFormat('H:i', $morning_time)->format("G:i");
        $afternoon = DateTime::createFromFormat('H:i', $afternoon_time)->format("G:i");
        $evening = DateTime::createFromFormat('H:i', $evening_time)->format("G:i");
        $morning_early = DateTime::createFromFormat('H:i', "8:50")->format("G:i");
        $afternoon_early = DateTime::createFromFormat('H:i', "12:50")->format("G:i");
        $evening_early = DateTime::createFromFormat('H:i', "16:50")->format("G:i");
        foreach ($shifts as $shift) {
            $curr_day = $weekdays[$shift->weekday];
            if ($shift->start_shift != null) {
                $started = DateTime::createFromFormat('Y-m-d H:i:s', $shift->start_shift)->format("G:i");
            }
            if ($day < $curr_day) {
                $forthcoming = $forthcoming + 1;
            } else if ($shift->start_shift == null) {
                $missed = $missed + 1;
            } else if ($shift->shift_time == "MORNING") {
                if ($started <= $morning_time && $started > $morning_early) {
                    $onTime = $onTime + 1;
                } else {
                    $late = $late + 1;
                }
            } else if ($shift->shift_time == "AFTERNOON") {
                if ($started < $afternoon_time && $started > $afternoon_early) {
                    $onTime = $onTime + 1;
                } else {
                    $late = $late + 1;
                }
            } else if ($shift->shift_time == "EVENING") {
                if ($started < $evening_time && $started > $evening_early) {
                    $onTime = $onTime + 1;
                } else {
                    $late = $late + 1;
                }
            }
        }
        $statistics = [
            'all' => $totalShifts,
            'missed' => $missed,
            'late' => $late,
            'onTime' => $onTime,
            'forthcoming' => $forthcoming,
        ];
        return $statistics;

    }
}
