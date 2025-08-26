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

    public function listCoursers()
    {
        return response()->json(
            $this->moodle->callMoodle('core_course_get_courses')
        );
    }

    public function users(Request $request)
    {
        return response()->json(
            $this->moodle->callMoodle('core_user_get_users_by_field', [
                'field' => $request->get('field', 'username'),
                'values[0]' => $request->get('value', '')
            ])
        );
    }

    // 4. Criar usuário
    public function createUser(Request $request)
    {
        $users = [[
            'username'  => $request->username,
            'password'  => $request->password,
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email
        ]];

        return response()->json(
            $this->moodle->callMoodle('core_user_create_users', ['users' => $users])
        );
    }

    // 5. Matricular usuário
    public function enroll(Request $request)
    {
        $enrolments = [[
            'roleid'   => 5,
            'userid'   => $request->userId,
            'courseid' => $request->courseId
        ]];

        return response()->json(
            $this->moodle->callMoodle('enrol_manual_enrol_users', ['enrolments' => $enrolments])
        );
    }

    // 6. Desmatricular usuário
    public function unenroll(Request $request)
    {
        $enrolments = [[
            'userid'   => $request->userId,
            'courseid' => $request->courseId
        ]];

        return response()->json(
            $this->moodle->callMoodle('enrol_manual_unenrol_users', ['enrolments' => $enrolments])
        );
    }

    // 7. Criar curso
    public function createCourse(Request $request)
    {
        $courses = [[
            'fullname'   => $request->fullname,
            'shortname'  => $request->shortname,
            'categoryid' => $request->get('categoryid', 1),
            'visible'    => $request->get('visible', 1)
        ]];

        return response()->json(
            $this->moodle->callMoodle('core_course_create_courses', ['courses' => $courses])
        );
    }
}
