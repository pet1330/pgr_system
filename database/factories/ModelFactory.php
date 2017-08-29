<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\Admin;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Wizard;
use App\Models\StudentRecord;
use App\Models\School;
use App\Models\EnrolmentStatus;
use App\Models\StudentStatus;
use App\Models\Programme;
use App\Models\FundingType;
use App\Models\ModeOfStudy;
use App\Models\Absence;
use App\Models\AbsenceType;
use Carbon\Carbon;
use App\Models\Milestone;
use App\Models\MilestoneType;
use App\Models\TimelineTemplate;
use App\Models\MilestoneTemplate;
use App\Models\Role;
use App\Models\Permission;

$factory->define(Student::class, function (Faker\Generator $faker) {
    $unid = $faker->unique()->bothify('???########');
    return [
        'first_name'           => $faker->firstName,
        'last_name'            => $faker->lastName,
        'university_email'     => $unid . "@students.lincoln.ac.uk",
        'university_id'        => $unid,
        'user_type'            => 'student',
    ];
});

$factory->define(Staff::class, function (Faker\Generator $faker) {
    $fName = $faker->firstName;
    $lName = $faker->unique()->lastName;

    return [
        'first_name'           => $fName,
        'last_name'            => $lName,
        'university_email'     => $fName[0] . $lName . "@lincoln.ac.uk",
        'university_id'        => $fName[0] . $lName,
        'user_type'            => 'staff',
    ];
});

$factory->define(Admin::class, function (Faker\Generator $faker) {
    $fName = $faker->firstName;
    $lName = $faker->unique()->lastName;
    return [
        'first_name'           => $fName,
        'last_name'            => $lName,
        'university_email'     => $fName[0] . $lName . "@lincoln.ac.uk",
        'university_id'        => $fName[0] . $lName,
        'user_type'            => 'admin',
    ];
});

$factory->define(Wizard::class, function (Faker\Generator $faker) {
    $fName = $faker->firstName;
    $lName = $faker->unique()->lastName;
    return [
        'first_name'           => $fName,
        'last_name'            => $lName,
        'university_email'     => $fName[0] . $lName . "@lincoln.ac.uk",
        'university_id'        => $fName[0] . $lName,
        'user_type'            => 'wizard',
    ];
});

$factory->define(StudentRecord::class, function (Faker\Generator $faker) {

    return [
        'school_id'            => School::inRandomOrder()->pluck('id')->first(),
        'enrolment_status_id'  => EnrolmentStatus::inRandomOrder()->pluck('id')->first(),
        'student_status_id'    => StudentStatus::inRandomOrder()->pluck('id')->first(),
        'enrolment_date'       => Carbon::instance($faker->dateTimeBetween('-3 years', 'now')),
        'programme_id'         => Programme::inRandomOrder()->pluck('id')->first(),
        'funding_type_id'      => FundingType::inRandomOrder()->pluck('id')->first(),
        'mode_of_study_id'     => ModeOfStudy::inRandomOrder()->pluck('id')->first(),
        'tierFour'             => $faker->boolean,
    ];
});


$factory->define(Absence::class, function (Faker\Generator $faker) {
    $start = Carbon::instance($faker->dateTimeBetween('-6 months', '6 months'));
    $end = $start->copy()->addDays($faker->numberBetween(2,30));
    $approval = $faker->optional()->boolean();

    return [
        'user_id'              => Student::inRandomOrder()->pluck('id')->first(),
        'absence_type_id'      => AbsenceType::inRandomOrder()->pluck('id')->first(),
        'from'                 => $start->format('Y-m-d H:i:s'),
        'to'                   => $end->format('Y-m-d H:i:s'),
        'duration'             => $start->diffInDays($end->copy()->addDays(1)),
        'approval_required'    => $faker->boolean(),
        'approval_granted'     => $approval,
        'approved_by'          => $approval ? Staff::inRandomOrder()->pluck('id')->first() : null,
        'approved_on'          => $approval ? $start->subDays($faker->numberBetween(2,30))->format('Y-m-d H:i:s') : null,
    ];
});

$factory->define(AbsenceType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'interuption' => $faker->boolean,
    ];
});

$factory->define(MilestoneType::class, function (Faker\Generator $faker) {
    return [
        'name'                 => $faker->name,
        'duration'             => $faker->numberBetween(1,12),
    ];
});

$factory->define(TimelineTemplate::class, function (Faker\Generator $faker) {
        $type = MilestoneType::inRandomOrder()->first();
    return [
        'name'                  => $faker->lastName,
    ];
});

$factory->define(MilestoneTemplate::class, function (Faker\Generator $faker) {
        $type = MilestoneType::inRandomOrder()->first();
        $timeline = TimelineTemplate::inRandomOrder()->first();
    return [
        'due'                  => $faker->numberBetween(1,12),
        'milestone_type_id'    => $type->id,
        'timeline_template_id'    => $timeline->id,
    ];
});

$factory->define(Milestone::class, function (Faker\Generator $faker) {
    $admin = factory(Admin::class)->create();
    $sr = StudentRecord::inRandomOrder()->first();
    $sub = $faker->optional()->dateTimeBetween($sr->enrolment_date, $sr->calculateEndDate());
    $due = $faker->dateTimeBetween($sr->enrolment_date, $sr->calculateEndDate());
    $type = MilestoneType::inRandomOrder()->first();

    return [
        'submitted_date'      => $sub,
        'duration'              => $faker->numberBetween(1,12),
        'duration_unit'         => 'Months',
        'name'                 => $sub ? $type->name : null,
        'due_date'              => $due,
        'non_interuptive_date'  => $due,
        'student_record_id'     => $sr->id,
        'milestone_type_id'     => $type->id,
        'created_by'            => $admin->id,
    ];
});

$factory->define(Role::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
    ];
});

$factory->define(Permission::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
    ];
});


// APPROVAL Model
// 'approval_required'    => $faker->boolean(),
        // 'approval_granted'     => $approval,
        // 'approved_by'          => $approval ? Staff::inRandomOrder()->pluck('id')->first() : null,
        // 'approved_on'          => $approval ? Carbon::now()->copy()->addMonths($faker->numberBetween(1,12))->format('Y-m-d H:i:s') : null,
