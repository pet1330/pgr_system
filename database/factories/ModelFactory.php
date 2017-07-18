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
use Carbon\Carbon;

$factory->define(Student::class, function (Faker\Generator $faker) {
    $unid = $faker->unique()->bothify('???########');
    return [
        'first_name'           => $faker->firstName,
        'last_name'            => $faker->lastName,
        'middle_name'          => $faker->optional()->firstName,
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
        'middle_name'          => $faker->optional()->firstName,
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
        'middle_name'          => $faker->optional()->firstName,
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
        'middle_name'          => $faker->optional()->firstName,
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
        'programme_title'      => $faker->sentence,
        'programme_type_id'    => Programme::inRandomOrder()->pluck('id')->first(),
        'funding_type_id'      => FundingType::inRandomOrder()->pluck('id')->first(),
        'mode_of_study_id'     => ModeOfStudy::inRandomOrder()->pluck('id')->first(),
        'tierFour'             => $faker->boolean,
    ];
});
