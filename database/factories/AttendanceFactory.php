<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attendance;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $working_days = $this->get_working_days();
        $in_time = rand(8,10).':'.rand(0,60);
        $out_time = rand(13,19).':'.rand(0,60);
        $user_id = $this->faker->randomElement(User::pluck('id')->toArray());
        static $usedDates = [];
        do {
            $date = date('Y-m-d',strtotime(date('Y').'-'.'3'.'-'.$working_days[rand(0,count($working_days)-1)]));
            $unique_key = $user_id . '-' . $date;
        } while (in_array($unique_key, $usedDates));

        $usedDates[] = $unique_key;
        $indate = date('Y-m-d',strtotime(date('Y').'-'.'3'.'-'.$working_days[rand(0,count($working_days)-1)])).' '.$in_time;
        $outdate = date('Y-m-d',strtotime(date('Y').'-'.'3'.'-'.$working_days[rand(0,count($working_days)-1)])).' '.$out_time;
        return [
            //
            'user_id' => $user_id,
            'attend_date' => $date,
            'in_time' => date('H:i',strtotime($indate)),
            'out_time' => date('H:i',strtotime($outdate)),
        ];
    }


    public function get_working_days(): array
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
    
            //if not a weekend add day to array
            if($day_name != 'Sun' &&  $day_name != 'Sat'){
                $workdays[] = $i;
            }
    
        }

        return $workdays;

    }
}
