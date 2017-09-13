<?php

auth()->loginUsingId(601);
// auth()->loginUsingId(App\Models\Student::pluck('id')->first());

Route::get('demo', function (){
    // auth()->logout();
    // auth()->loginUsingId(App\Models\Admin::pluck('id')->first());
    // auth()->loginUsingId(App\Models\Admin::whereId(604)->pluck('id')->first());
    // auth()->loginUsingId(App\Models\Admin::find(602)->first()->id);
    // auth()->loginUsingId(App\Models\Staff::pluck('id')->first());
    auth()->loginUsingId(App\Models\Student::pluck('id')->first());
    return redirect('/');
});

Route::any('error', function(){
    dd(Request::all());
});

Route::get('login', 'SAMLController@login');
Route::get('logout', 'SAMLController@logout');

Route::middleware('samlauth')->get('/', function() {
    return redirect(auth()->user()->dashboard_url());
});

Route::name('account-locked')->get('account-locked', function () {
    return "SORRY! YOUR ACCOUNT APPEARS TO HAVE BEEN LOCKED";
});

Route::middleware('samlauth')
    ->namespace('Admin')
    ->as('admin.')
    ->prefix('a')
    ->group( function() {
    // =======================================================================
    // ======================== Admin Specific Routes ========================
    // =======================================================================

    Route::get('student/overdue', 'MilestoneController@overdue')->name('student.overdue');
    Route::get('student/upcoming', 'MilestoneController@upcoming')->name('student.upcoming');
    Route::get('student/submitted', 'MilestoneController@submitted')->name('student.submitted');

    Route::get('student/find', 'StudentController@find')->name('student.find');
    Route::post('student/find', 'StudentController@find_post')->name('student.find');
    
    Route::get('student/confirm', 'StudentController@confirm_user')->name('student.confirm');
    Route::post('student/confirm', 'StudentController@confirm_post_user')->name('student.confirm');

    Route::get('student/confirm_id', 'StudentController@confirm_id')->name('student.confirm_id');
    Route::post('student/confirm_id', 'StudentController@confirm_post_id')->name('student.confirm_id');

    Route::get('staff/find', 'StaffController@find')->name('staff.find');
    Route::post('staff/find', 'StaffController@find_post')->name('staff.find');
    
    Route::get('staff/confirm', 'StaffController@confirm_user')->name('staff.confirm');
    Route::post('staff/confirm', 'StaffController@confirm_post_user')->name('staff.confirm');

    Route::get('staff/confirm_id', 'StaffController@confirm_id')->name('staff.confirm_id');
    Route::post('staff/confirm_id', 'StaffController@confirm_post_id')->name('staff.confirm_id');

    Route::get('staff/upgrade', 'StaffController@upgrade')->name('staff.upgrade.index');
    Route::post('staff/{staff}/upgrade', 'StaffController@upgrade_store')->name('staff.upgrade.store');

    Route::resource('student.record.supervisor', 'SupervisorController',
        [ 'only' => ['create', 'store', 'destroy'] ]);

    Route::resource('student.record', 'StudentRecordController');

    Route::post('student/{student}/record/{record}/milestone/{milestone}/upload',
        'MilestoneController@upload')->name('student.record.milestone.upload');

    Route::post('student/{student}/record/{record}/milestone/{milestone}/approve',
        'MilestoneController@approve')->name('student.record.milestone.approve');

    Route::resource('student.record.milestone', 'MilestoneController');

    Route::resource('admin', 'AdminController');
    
    Route::resource('student.absence', 'AbsenceController');
    
    Route::resource('student', 'StudentController');

    Route::resource('staff', 'StaffController');

    Route::prefix('settings')->as('settings.')->group(function ()
    {
        Route::get('timeline/{timeline}/restore',
                   'TimelineTemplateController@restore')
            ->name('timeline.restore');

        Route::get('absence-type/{absence_type}/restore',
                   'AbsenceTypeController@restore')
            ->name('absence-type.restore');

        Route::get('funding-type/{funding_type}/restore',
                   'FundingTypeController@restore')
            ->name('funding-type.restore');

        Route::get('programme/{programme}/restore',
                   'ProgrammeController@restore')
            ->name('programme.restore');

        Route::get('school/{school}/restore',
                   'SchoolController@restore')
            ->name('school.restore');

        Route::get('college/{college}/restore',
                   'CollegeController@restore')
            ->name('college.restore');

        Route::get('mode-of-study/{mode_of_study}/restore',
                   'ModeOfStudyController@restore')
            ->name('mode-of-study.restore');

        Route::get('student-status/{student_status}/restore',
                   'StudentStatusController@restore')
            ->name('student-status.restore');

        Route::get('enrolment-status/{enrolment_status}/restore',
                   'EnrolmentStatusController@restore')
            ->name('enrolment-status.restore');

        Route::get('milestone-type/{milestone_type}/restore',
                   'MilestoneTypeController@restore')
            ->name('milestone-type.restore');

        $settings_resource = [ 'except' => [ 'create', 'show' ] ];
        
        Route::resource('timeline.milestone', 'MilestoneTemplateController', ['except' => 'index']);
        
        Route::resource('timeline', 'TimelineTemplateController');

        Route::resource('school', 'SchoolController', $settings_resource);
        
        Route::resource('college', 'CollegeController', $settings_resource);

        Route::resource('programme', 'ProgrammeController', $settings_resource);

        Route::resource('absence-type', 'AbsenceTypeController', $settings_resource);

        Route::resource('funding-type', 'FundingTypeController',  $settings_resource);

        Route::resource('mode-of-study', 'ModeOfStudyController', $settings_resource);

        Route::resource('milestone-type', 'MilestoneTypeController', $settings_resource);

        Route::resource('student-status', 'StudentStatusController', $settings_resource);

        Route::resource('enrolment-status', 'EnrolmentStatusController', $settings_resource);

        Route::resource('user-roles', 'UserRolesController');
        
        Route::resource('role-permissions', 'RolePermissionsController');
    });
});




            // Route::resource('timeline-template', 'TimelineTemplateController', $settings_resource);

            // Route::('timeline-template', 'TimelineTemplateController', $settings_resource);
            // Route::resource('staff-training-type', 'StaffTrainingTypeController', $settings_resource);
    // }

    // if ( auth()->user()->can('isStaff') ) {  // @TODO: replace with Roles and Permissions
    //     // =======================================================================
    //     // ======================== Staff Specific Routes ========================
    //     // =======================================================================
    //     Route::get('profile', 'StaffController@ownProfile')->name('profile');
    //     Route::get('/', 'StaffController@dashboard');
        
    // }

    // if ( auth()->user()->can('isStudent') ) {  // @TODO: replace with Roles and Permissions
    //     // =======================================================================
    //     // ======================= Student Specific Routes =======================
    //     // =======================================================================
    //     Route::get('profile', 'StudentController@ownProfile')->name('profile');
    //     Route::get('/', 'StudentController@dashboard');
    // }


    // =======================================================================
    // =================== Guest Routes (Not Authenticated) ==================
    // =======================================================================


// Route::post('report-bug', function () {

//     $message =  Request::input('message');
//     $ip = Request::ip();
//     $user = auth()->user()->university_id ?? "unknown";
//     $page = Request::input('location');
//     return collect(['response' => 'Thank you, the message has been logged and will be checked soon',
//             'ip' => $ip
//         ])->toJson();]
// })->name('bug-report');


// ===============================================================================
// ===================================  Notes  ===================================
// ===============================================================================

        // Route::get('/welcome', function () {
        //     return view('welcome');
        // });

    // // Admin Specific Routes
    //     Route::get('/', function () {
    //         return view('admin.students');
    //     });

    //     Route::resource('absencetype', 'AbsenceTypeController', ['except' => ['create', 'show']]);

    //     Route::name('student.index')->get('students', function () {
    //         $students = App\Models\Student::inRandomOrder()->take(20)->get();
    //         return view('admin.students', compact('students'));
    //     });

    //     Route::name('staff.index')->get('staff/{staff}', function (App\Models\Staff $staff) {
    //        dd($staff);
