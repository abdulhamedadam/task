<?php
use Carbon\Carbon;
/**********************************************/
function load_renter_data($data)
{
    $data['all_data'] = $data;
    return view('dashbord.admin.load_v.client_data',$data);
}
/********************************************/
function CalculateAge($dateOfBirth)
{
    if ($dateOfBirth) {
        $dateOfBirth = Carbon::parse($dateOfBirth);
        return $dateOfBirth->age;
    }

    return null;
}
