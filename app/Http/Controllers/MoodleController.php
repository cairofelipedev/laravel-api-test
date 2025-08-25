<?php

namespace App\Http\Controllers;

use App\Services\MoodleService;
use Illuminate\Http\Request;

class MoodleController extends Controller
{
    private $moodle;

    public function __construct(MoodleService $moodle)
    {
        $this->moodle = $moodle;
    }

    public function siteInfo()
    {
        return response()->json(
            $this->moodle->callMoodle('core_webservice_get_site_info')
        );
    }
}
