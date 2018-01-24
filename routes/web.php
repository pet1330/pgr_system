<?php

//auth()->loginUsingId(App\Models\Admin::first()->id);

Route::middleware('guest')->get('login', 'SAMLController@login')->name('login');
Route::middleware('samlauth')->get('logout', 'SAMLController@logout')->name('logout');

Route::get('auth-status', function() {
    return auth()->check() ? "logged-in" : "logged-out";
});

Route::get('downtime-robot', function(){
    return "All Systems Operational";
});

Route::name('account-locked')->get('account-locked', function () {
    return "SORRY! YOUR ACCOUNT APPEARS TO HAVE BEEN LOCKED";
});

Route::middleware('samlauth')->namespace('Admin')->as('admin.')->group( function() {

    Route::get('/', function() { return redirect(auth()->user()->dashboard_url()); });

    Route::get('student/overdue', 'MilestoneController@overdue')->name('student.overdue');
    Route::get('student/amendments', 'MilestoneController@amendments')->name('student.amendments');
    Route::get('student/upcoming', 'MilestoneController@upcoming')->name('student.upcoming');
    Route::get('student/submitted', 'MilestoneController@recent')->name('student.submitted');

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

    Route::get('admin/downgrade', 
        'AdminController@downgrade')->name('admin.downgrade.index');
    Route::post('admin/{admin}/downgrade', 
        'AdminController@downgrade_store')->name('admin.downgrade.store');

    Route::get('student/{student}/record/{record}/supervisor/find',
        'SupervisorController@find')->name('supervisor.find');

    Route::post('student/{student}/record/{record}/supervisor/find',
        'SupervisorController@find_post')->name('supervisor.find');

    Route::get('student/{student}/record/{record}/supervisor/{staff}/create',
        'SupervisorController@create')->name('supervisor.create');

    Route::post('student/{student}/record/{record}/supervisor',
        'SupervisorController@store')->name('supervisor.store');

    Route::get('student/{student}/record/{record}/supervisor/confirm_id',
        'SupervisorController@confirm_id')->name('supervisor.confirm_id');

    Route::post('student/{student}/record/{record}/supervisor/confirm_id',
        'SupervisorController@confirm_post_id')->name('supervisor.confirm_id');

    Route::delete('student/{student}/record/{record}/supervisor/{staff}',
            'SupervisorController@destroy')->name('supervisor.destroy');

    Route::get('student/{student}/record/{record}/mass-assign',
        'TimelineTemplateController@create_mass_assignment')->name('student.record.mass-assignment');

    Route::post('student/{student}/record/{record}/mass-assign',
        'TimelineTemplateController@store_mass_assignment')->name('student.record.mass-assignment');

    Route::resource('student.record', 'StudentRecordController');

    Route::post('student/{student}/record/{record}/note',
        'StudentRecordController@note')->name('student.record.note');

    Route::post('student/{student}/record/{record}/milestone/{milestone}/upload',
        'MilestoneController@upload')->name('student.record.milestone.upload');

    Route::get('student/{student}/record/{record}/milestone/{milestone}/download/{file}',
        'MilestoneController@download')->name('student.record.milestone.media');

    Route::post('student/{student}/record/{record}/milestone/{milestone}/approve',
        'MilestoneController@approve')->name('student.record.milestone.approve');

    Route::resource('student.record.milestone', 'MilestoneController');

    Route::resource('admin', 'AdminController');
    
    Route::resource('student.absence', 'AbsenceController', ['except' => 'index' ]);
    
    Route::resource('student', 'StudentController');

    Route::resource('staff', 'StaffController');

    Route::prefix('settings')->as('settings.')->group(function ()
    {
        Route::get('timeline/{timeline}/restore',
                   'TimelineTemplateController@restore')->name('timeline.restore');

        Route::get('timeline/{timeline}/milestone/{milestone}/restore',
                   'MilestoneTemplateController@restore')->name('timeline.milestone.restore');

        Route::get('absence-type/{absence_type}/restore',
                   'AbsenceTypeController@restore')->name('absence-type.restore');

        Route::get('funding-type/{funding_type}/restore',
                   'FundingTypeController@restore')->name('funding-type.restore');

        Route::get('programme/{programme}/restore',
                   'ProgrammeController@restore')->name('programme.restore');

        Route::get('school/{school}/restore',
                   'SchoolController@restore')->name('school.restore');

        Route::get('college/{college}/restore',
                   'CollegeController@restore')->name('college.restore');

        Route::get('student-status/{student_status}/restore',
            'StudentStatusController@restore')->name('student-status.restore');

        Route::get('enrolment-status/{enrolment_status}/restore',
            'EnrolmentStatusController@restore')->name('enrolment-status.restore');

        Route::get('milestone-type/{milestone_type}/restore',
            'MilestoneTypeController@restore')->name('milestone-type.restore');

        $settings_resource = [ 'except' => [ 'create', 'show' ] ];
        
        Route::resource('timeline.milestone', 'MilestoneTemplateController', ['except' => 'index']);
        
        Route::resource('timeline', 'TimelineTemplateController');

        Route::resource('school', 'SchoolController', $settings_resource);
        
        Route::resource('college', 'CollegeController', $settings_resource);

        Route::resource('programme', 'ProgrammeController', $settings_resource);

        Route::resource('absence-type', 'AbsenceTypeController', $settings_resource);

        Route::resource('funding-type', 'FundingTypeController',  $settings_resource);

        Route::resource('milestone-type', 'MilestoneTypeController', $settings_resource);

        Route::resource('student-status', 'StudentStatusController', $settings_resource);

        Route::resource('enrolment-status', 'EnrolmentStatusController', $settings_resource);

        Route::resource('user-roles', 'UserRolesController');
        
        Route::resource('role-permissions', 'RolePermissionsController');
    });
});
