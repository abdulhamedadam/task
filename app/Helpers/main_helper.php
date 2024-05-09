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

/***************************************************************/
if (!function_exists('translate')) {
    function translate($word = '')
    {
        // Get the current language from the session or global setting
        $setLang = app()->getLocale();
        $lang = [
            'ar' => 'arabic',
            'en' => 'english',
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























