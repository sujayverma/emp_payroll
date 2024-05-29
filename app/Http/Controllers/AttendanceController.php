<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    //

    public function get_data()
    {
        $workdays = array();

        $type = CAL_GREGORIAN;
        $month = 3; // Month ID, 1 through to 12.
        $year = date('Y'); // Year in 4 digit 2009 format.
        $day_count = cal_days_in_month($type, $month, $year);

       
        for ($i = 1; $i <= $day_count; $i++) {

            $date = $year.'/'.$month.'/'.$i; //format date
            $get_name = date('l', strtotime($date)); //get week day
            $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
    
            
            $workdays[$i]['day'] = $day_name;
            $workdays[$i]['date'] = $i;
    
        }
       


        $users = User::with('attend')->get();
        return view('listing', $data=['users'=>$users, 'days'=>$workdays]);
    }
}
