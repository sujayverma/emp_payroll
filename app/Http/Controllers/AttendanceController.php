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
        $day_arr = [];
       
        for ($i = 1; $i <= $day_count; $i++) {

            $date = $year.'/'.$month.'/'.$i; //format date
            $get_name = date('l', strtotime($date)); //get week day
            $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
    
            
            $workdays[$i]['day'] = $day_name;
            $workdays[$i]['date'] = $i;
            $day_arr[] = $i;
    
        }
       
        $final_array = [];
        // dd($day_arr);
        $users = $users = User::with(['attend' => function($query) {
            $query->orderBy('user_id', 'asc');
            $query->orderBy('attend_date', 'asc');
        }])->get();
        // dd($users); exit;
        foreach($users as $user)
        {
            // dd($user->attend); exit;
            $late = 0;
            $half_day= 0;
            $full_day = 0;
            $weekend = 0;
            
            

                foreach($user->attend as $attendance_details)
                {
                         
                        // echo $day['date'].'___'.date('j',strtotime($attendance_details->attend_date));
                        // dd( $attendance_details->attend_date); exit;
                        
                        if(in_array(date('j',strtotime($attendance_details->attend_date)),$day_arr))
                        {

                            $status = [];
                            // echo $day['date'].'___'.date('j',strtotime($attendance_details->attend_date)).'HHH<br>';
                            $time1 = strtotime($attendance_details->out_time);
                            $time2 = strtotime($attendance_details->in_time);
                            $difference = round(abs($time2 - $time1) / 3600,2);
                            
                            
                            $status['attend_date'] = $attendance_details->attend_date;
                            $status['in_time'] = $attendance_details->in_time;
                            $status['out_time'] = $attendance_details->out_time;
                            if('09.31'> date("h.i", strtotime($attendance_details->in_time)) || '17.00'< date("h.i", strtotime($attendance_details->out_time)))
                            {
                                $late++;
                                $status['cell_color'] = 'Blue'; 
                            }
                            else if('18.00'<date("h.i", strtotime($attendance_details->out_time)))
                            {
                                $status['cell_color'] = 'Blue';
                            }
                            elseif($difference == '4.00')
                            {
                                $half_day++;
                            }
                            else
                            {
                                $status['cell_color'] = '';
                            }
                                
                            $full_day++;
                            
                            // echo date("h.i", strtotime($attendance_details->in_time)); exit;
                        
                            if(!isset($final_array[$user->name][$attendance_details->attend_date]))
                            {
                                // echo $day['date'].'___'.date('j',strtotime($attendance_details->attend_date)).'pp<br>';
                                $final_array[$user->name][date('j',strtotime($attendance_details->attend_date))] = $status;
                            }
                               
                            
                        }
                       


                        // echo $late;
                        // $final_array[$user->name][$day['date']] = $status;
                  
                    
                }

                foreach($workdays as $day)
                {
                    if(!isset($final_array[$user->name][$day['date']]))
                    {
                        $status = [];
                        if($day['day']=='Sun' || $day['day']=='Sat')
                        {
                            $weekend++;
                            $status['cell_color'] = 'weekend';
                        }
                        else
                        {
                            $status['cell_color'] = 'Red';
                        }
                        $final_array[$user->name][$day['date']] = $status;
                        // sort($final_array[$user->name]);
                    }

                }
                
               
                
            // exit;
            $deduction = floor($late/4);
            $total = $full_day + $weekend + ($half_day*0.5) - $deduction;
            $final_array[$user->name]['full_day'] = $full_day;
            $final_array[$user->name]['half_day'] = $half_day;
            $final_array[$user->name]['weekend'] = $weekend;
            $final_array[$user->name]['deduction'] = $deduction;
            $final_array[$user->name]['total'] = $total;
            
        }

        
        echo '<pre>'.print_r($final_array,True).'</pre>'; exit;
        return view('listing', $data=['users'=>$users, 'days'=>$workdays, 'data' => $final_array]);
    }
}
