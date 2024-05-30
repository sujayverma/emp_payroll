<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        User::factory(10)->create();
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
