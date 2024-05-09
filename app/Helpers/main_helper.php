<?php


use App\Interfaces\BasicRepositoryInterface;
use App\Models\Groubs;
use App\Models\Maindata;
use App\Models\Notifications;
use App\Models\TripDays;
use App\Models\Trips;
use App\Models\Admin\GeneralSetting;
use App\Traits\ImageProcessing;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

if (!function_exists('getMainData')) {

    function getMainData()
    {
        $mdata = Maindata::select('*')->first();
        return optional($mdata);
    }
}

if (!function_exists('formatDateForDisplay')) {
    function formatDateForDisplay($dateTimeStr)
    {
        $dateTime = new DateTime($dateTimeStr);

        $formattedDate = $dateTime->format('d M Y');
        $formattedTime = $dateTime->format('g:ia');
        $formattedTime = strtolower($formattedTime);

        return $formattedDate . ' at ' . $formattedTime;
    }
}
if (!function_exists('formatDateDayDisplay')) {


    function formatDateDayDisplay($dateTimeStr)
    {
        $dateTime = new DateTime($dateTimeStr);

        $formattedDate = $dateTime->format('d M Y');

        return $formattedDate;
    }
}


if (!function_exists('getFirstLetters')) {
    function getFirstLetters($inputString)
    {
        $words = explode(' ', $inputString);
        $firstLetters = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $firstLetters .= strtoupper($word[0]);  // Get the first letter and convert to uppercase
            }
        }

        return $firstLetters;
    }


}

if (!function_exists('GetTripDayField')) {
    function GetTripDayField($inputId, $related_with, $select_main, $seledted_related)
    {
        $queryResult = \App\Models\TripDays::where('id', $inputId)->with($related_with)->get()->toArray();

        if (!empty($queryResult)) {
            $result = $queryResult[0];
            if (!empty($select_main)) {
                return $result[$select_main];
            }
            if (!empty($seledted_related)) {
                return $result[$related_with][$seledted_related];
            }
        }
        return null;
    }
}


if (!function_exists('GetTripDayData')) {
    function GetTripDayData($inputId, $relation = [])
    {
        return $data = \App\Models\TripDays::where('id', $inputId)->with($relation)->get()->toArray();
    }
}

if (!function_exists('GetTripInvitationData')) {
    function GetTripInvitationData($inputId, $relation = [])
    {
        return $data = \App\Models\InvitationTrip::where('id', $inputId)->with($relation)->get()->toArray();
    }
}
function delete_trip($id)
{
    $delete_data = Trips::with('triprequests', 'trips_member', 'trippoint', 'tripdays', 'invitations')->find($id);
    $delete_data->trips_member()->delete();
    $delete_data->triprequests()->delete();
    $delete_data->trippoint()->delete();
    $delete_data->tripdays()->delete();
    $delete_data->invitations()->delete();
    $delete_data->delete();
    return $delete_data;
}

function delete_group($id)
{
    $delete_data = Groubs::with('groubs_member', 'requests')->find($id);
    $delete_data->groubs_member()->delete();
    $delete_data->requests()->delete();
    $delete_data->delete();

    $filePath = $delete_data->image;
    if ($filePath) {
        if (is_file(Storage::disk('images')->path($filePath))) {
            if (file_exists(Storage::disk('images')->path($filePath))) {
                unlink(Storage::disk('images')->path($filePath));
            }
        }
    }
}


if (!function_exists('GetData')) {
    function GetData($models, $inputId, $relation = [])
    {
        return $data = $models::where('id', $inputId)->with($relation)->get()->toArray();
    }
}
/*-----------------------abdulhamedzghloul----------------------------*/
if (!function_exists('menu_sub_active')) {
    function menu_sub_active(array $routes_names)
    {
        $currentRoute = Route::currentRouteName();
        if (in_array(explode('.', $currentRoute)[1], $routes_names)) {
            echo 'show';
        }
    }
}
/*---------------------------------------------------*/
if (!function_exists('menu_link_active')) {
    function menu_link_active($route_name)
    {
        $currentUrl = url()->current();
        if (strpos($currentUrl, $route_name) !== false) {
            echo 'active';
        }
    }
}

/*----------------------------------------------*/
if (!function_exists('test')) {
    function test($data)
    {
        $startTime = microtime(true);
        echo '<pre>';
        print_r($data);
        die();
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        echo "Execution Time: $executionTime seconds";
    }
}
/*----------------------------------------------*/
if (!function_exists('createRepository')) {
     function createRepository(BasicRepositoryInterface $basicRepository, $model)
    {
        $repository = clone $basicRepository;
        $repository->set_model($model);
        return $repository;
    }
}
/*----------------------------------------------*/
if (!function_exists('validate')) {
    function validate($translations, $request)
    {
        $data = [
            'error_string' => [],
            'inputerror' => [],
            'status' => true,
        ];

        foreach ($translations as $fieldName => $conditions) {

            // Extract table and field from the unique rule
            $translateinput=trim(explode('|', $conditions)[0]);
            $parts = explode(':', $conditions);
            $uniqueRule = explode(',', $parts[1]);
            $table = trim($uniqueRule[0]);
            $field = trim( $uniqueRule[1]);
            //test($translateinput);

            if (empty($request[$fieldName])) {
                $data['inputerror'][] = $fieldName;
                $data['error_string'][] = trans($translateinput) . ' ' . trans('settings.required');
                $data['status'] = false;
            } else {
                // Check uniqueness
                $value = $request[$fieldName];
                $exists = DB::table($table)->where($field, $value)->exists();
                  //test($field);

                if ($exists) {
                    $data['inputerror'][] = $fieldName;
                    $data['error_string'][] = trans($translateinput) . ' ' . trans('settings.unique');
                    $data['status'] = false;
                }
            }
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }

        return $data;
    }
}

/***************************************************************/
if (!function_exists('translate')) {
    function translate($word = '')
    {
        // Get the current language from the session or global setting
        $setLang = app()->getLocale();
        $lang=[
            'ar'=>'arabic',
            'en'=>'english',
        ];
        // Default to 'english' if no language is set
        $setLang = $lang[$setLang] ?: 'english';

        // Query the languages table to find the translation
        $translation = DB::table('languages')->where('word', $word)->first();

        if ($translation) {
            // Check if the translation for the selected language exists
            if (isset($translation->{$setLang}) && $translation->{$setLang} !== '') {
                return $translation->{$setLang};
            } else {
                // Return the English translation if the selected language is not available
                return $translation->english;
            }
        } else {
            // If the word is not found in the languages table, insert it with a default English translation
            $arrayData = [
                'word' => $word,
                'english' => ucwords(str_replace('_', ' ', $word)),
            ];

            DB::table('languages')->insert($arrayData);

            return ucwords(str_replace('_', ' ', $word));
        }
    }


    /************************************************/
    if (!function_exists('formatFileSize')) {
        function formatFileSize($destination)
        {
            $bytes = filesize($destination);
            if ($bytes >= 1073741824) {
                return number_format($bytes / 1073741824, 2) . ' GB';
            } elseif ($bytes >= 1048576) {
                return number_format($bytes / 1048576, 2) . ' MB';
            } elseif ($bytes >= 1024) {
                return number_format($bytes / 1024, 2) . ' KB';
            } elseif ($bytes > 1) {
                return $bytes . ' bytes';
            } elseif ($bytes == 1) {
                return $bytes . ' byte';
            } else {
                return '0 bytes';
            }
        }
    }

    /**************************************************/
    function Diff_Days($start_date, $end_date) {
        $startDate = Carbon::parse($start_date);
        $endDate = Carbon::parse($end_date);

        $diffInDays = $endDate->diffInDays($startDate);

        if ($diffInDays > 0) {
            return '<span style="font-weight:normal;font-size: 12px;width: 100px;" class="badge bg-success"> المدة ' . $diffInDays . ' يوم </span>';
        } else {

            return '--';
        }
    }
    /***************************************************/
    if (!function_exists('diffDaysNew')) {
        function diffDaysNew($start_date, $end_date)
        {
            $startTimeStamp = strtotime($start_date);
            $endTimeStamp = strtotime($end_date);
            $timeDiff = ($endTimeStamp - $startTimeStamp);
            $numberDays = $timeDiff / 86400;  // 86400 seconds in one day
            $numberDays = ($numberDays);

            $diff = ($endTimeStamp - $startTimeStamp) / 86400;

            if ($diff >= 0) {
                return 100;
            } elseif ($diff == -1) {
                return 75;
            } elseif ($diff == -2) {
                return 50;
            } elseif ($diff == -3) {
                return 25;
            } else {
                return 0;
            }
        }
    }

    /**************************************************/
    function count_task($date = null, $wared_emp_id = null, $action_ended = null, $sader_emp_id = null, $need_comment = null, $all_from_to = null, $end_takeem = null)
    {
        $query = \DB::table('tbl_tasks');

        if (!empty($all_from_to)) {
            $query->where(function ($query) use ($all_from_to) {
                $query->where('from_user_id', '=', $all_from_to)
                    ->orWhere('to_user_id', '=', $all_from_to);
            });
        }

        if (!empty($date)) {
            $today = Carbon::now()->toDateString();
            $user_id = auth()->user()->id;

            $query->where('action_ended', '!=', 'done')
                ->where('deadline_date', '<', $today);

            if (auth('admin')->user()->role_id_fk != 1) {
                $query->where(function ($query) use ($user_id) {
                    $query->where('to_user_id', $user_id)
                        ->orWhere('from_user_id', $user_id);
                });
            }
        }

        if (!empty($need_comment)) {
            $query->where('current_to_user_id', '=', $need_comment)
                ->where('comment_seen', '=', 0);
        }

        if (!empty($wared_emp_id)) {
            $query->where('to_user_id', '=', $wared_emp_id);
        }

        if (!empty($sader_emp_id)) {
            $query->where('from_user_id', '=', $sader_emp_id);
        }

        if (!empty($action_ended)) {
            $query->where('action_ended', '=', $action_ended);
        }

        if (!empty($end_takeem)) {
            $query->where('end_takeem', '=', $end_takeem);
        }

        $count = $query->count();

        return $count;
    }

}

/******************************************************/
 function count_case_setting($type=null)
{
    $query = \DB::table('tbl_cases_settings');
    if (!empty($type)) {
        $query->where('ttype', '=', $type);
    }
    $count = $query->count();

    return $count;

}
/*****************************************************/
function count_general_setting($type=null)
{
    $query = \DB::table('general_settings');
    if (!empty($type)) {
        $query->where('ttype', '=', $type);
    }
    $count = $query->count();

    return $count;
}

/*****************************************************/
function count_archive_setting($type=null)
{
    $query = \DB::table('tbl_archive_settings');
    if (!empty($type)) {
        $query->where('ttype', '=', $type);
    }
    $count = $query->count();

    return $count;
}

/*****************************************************/
function count_hr_setting($type=null)
{
    $query = \DB::table('hr_general_settings');
    if (!empty($type)) {
        $query->where('ttype', '=', $type);
    }
    $count = $query->count();

    return $count;
}
/****************************************************/
function get_emp_name($emp_id=null)
{
    $query = \DB::table('employees');
    if (!empty($emp_id)) {
        $query->where('id', '=', $emp_id);
    }
    $data = $query->first();
    return $data ? $data->employee : null;
}
/*****************************************************/
function data_count($table)
{
    $query = \DB::table($table);
    $count = $query->count();

    return $count;
}
/***************************************************/
function save_archive_file($file,$request)
{
    $data['archive_id']=$request->archive_id;
    $data['folder_code']=$request->folder_code;
    $data['file_name']=$request->file_name;
    $data['file']=$file;
    $data['publisher']=auth('admin')->user()->id;
    $data['publisher_n']=auth('admin')->user()->name;

    return $data;

}

/*************************************************/
function read_file($disk,$file)
{
   // $case_file=$this->CasesFilesRepository->getById($file_id);
    $file_path = Storage::disk($disk)->path($file);
    $fileContent = Storage::get($file_path);
    return response()->file($file_path);
}
/*************************************************/
function get_currency()
{
    $currencyValue = Maindata::first()->currency;
    $title = GeneralSetting::where('id', $currencyValue)->value('title'); // Assuming 'title' is the column name in general_settings

    return $title;
}

/*********************************************/
function get_all_fees($client_id = null)
{
    $query = DB::table('tbl_clients_cases')
        ->select(DB::raw('SUM(fees) as total_fees'));

    if ($client_id !== null) {
        $query->where('client_id_fk', $client_id);
    }

    $result = $query->first();

    return $result->total_fees ?? 0;
}
/*********************************************/
function get_all_paid($client_id = null)
{
    $query = DB::table('tbl_case_payments')
        ->select(DB::raw('SUM(paid_value) as total_paid'));

    if ($client_id !== null) {
        $query->where('client_id_fk', $client_id);
    }

    $result = $query->first();

    return $result->total_paid ?? 0;
}

/*********************************************/
function get_all_paid_by_case($case_id = null)
{
    $query = DB::table('tbl_case_payments')
        ->select(DB::raw('SUM(paid_value) as total_paid'));

    if ($case_id !== null) {
        $query->where('case_id_fk', $case_id);
    }

    $result = $query->first();

    return $result->total_paid ?? 0;
}
/*******************************************/
//إجمال الأموال المتحصل عليها هذا اليوم
if (!function_exists('get_today_payments_sum(')) {
    function get_today_payments_sum(){

        $currentDay = Carbon::now()->format('d');

        return DB::table('tbl_case_payments')
            ->whereDay('paid_date', $currentDay)
            ->sum('paid_value');
    }
}

//اليوم الحالى هو
if (!function_exists('current_day')) {
    function current_day()
    {
        $currentDayName = Carbon::now()->dayName;
        return $currentDayName;
    }
}


//إجمال الأموال المتحصل عليها هذا الشهر
if (!function_exists('get_monthly_payments_sum')) {
    function get_monthly_payments_sum()
    {

        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        return DB::table('tbl_case_payments')
            ->whereYear('paid_date', $currentYear)
            ->whereMonth('paid_date', $currentMonth)
            ->sum('paid_value');
    }
}

//الشهر الحالى هو
if (!function_exists('current_month')) {
    function current_month()
    {
        $currentMonthName = Carbon::now()->monthName;
        return $currentMonthName;
    }
}






//إجمال الأموال المتحصل عليها هذا العام
if (!function_exists('get_yearly_payments_sum')) {
    function get_yearly_payments_sum()
    {

        $currentYear = Carbon::now()->format('Y');

        return DB::table('tbl_case_payments')
            ->whereYear('paid_date', $currentYear)
            ->sum('paid_value');
    }
}

//العام الحالى هو
if (!function_exists('current_year')) {
    function current_year()
    {
        $currenYearName = Carbon::now()->format('Y');
        return $currenYearName;
    }
}


//إجمال الأموال المتحصل عليها منذ بداية العمل
if (!function_exists('get_all_payments_sum')) {
    function get_all_payments_sum()
    {
        return DB::table('tbl_case_payments')
            ->sum('paid_value');
    }
}


//بداية أول عملية دفع تمت فى البرنامج

if (!function_exists('get_oldest_payment_date')) {
    function get_oldest_payment_date()
    {
        return DB::table('tbl_case_payments')
            ->whereNotNull('paid_date')
            ->orderBy('paid_date', 'asc')
            ->value('paid_date');
    }
}


/***********************************************************************/
if (!function_exists('getMonthName')) {

    function getMonthName($monthNumber) {
        $setLang = app()->getLocale();
        // Set default locale to en_US
        $locale = 'en_US.UTF-8';
        $monthNames = [
            'en' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'ar' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر']
        ];

        // Change locale if set to Arabic
        if ($setLang == 'ar') {
            $locale = 'ar_SA.utf8';
            return $monthNames[$setLang][$monthNumber - 1];
        }

        setlocale(LC_TIME, $locale);

        return strftime('%B', mktime(0, 0, 0, $monthNumber, 1));
    }
}











