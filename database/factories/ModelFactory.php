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

use \App\Models\Admin;
use \App\Models\Student;
use \App\Models\Staff;
use \App\Models\Wizard;
use \App\Models\StudentRecord;
use \App\Models\School;
use \App\Models\EnrolmentStatus;
use \App\Models\StudentStatus;
use \App\Models\Program;
use \App\Models\FundingType;
use \App\Models\ModeOfStudy;

$factory->define(Student::class, function (Faker\Generator $faker) {

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->optional()->firstName,
        'university_email' => $faker->unique()->safeEmail,
        'university_id' => $faker->unique()->bothify('???########'),
        'user_type' => 'student',
    ];
});

$factory->define(Staff::class, function (Faker\Generator $faker) {

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->optional()->firstName,
        'university_email' => $faker->unique()->safeEmail,
        'university_id' => $faker->unique()->lastName,
        'user_type' => 'staff',
    ];
});

$factory->define(Admin::class, function (Faker\Generator $faker) {

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->optional()->firstName,
        'university_email' => $faker->unique()->safeEmail,
        'university_id' => $faker->unique()->lastName,
        'user_type' => 'admin',
    ];
});

$factory->define(Wizard::class, function (Faker\Generator $faker) {

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->optional()->firstName,
        'university_email' => $faker->unique()->safeEmail,
        'university_id' => $faker->unique()->lastName,
        'user_type' => 'wizard',
    ];
});

$factory->define(StudentRecord::class, function (Faker\Generator $faker) {

    return [
        'school' => School::inRandomOrder()->pluck('id')->first(),
        'enrolment_status' => EnrolmentStatus::inRandomOrder()->pluck('id')->first(),
        'student_status' => StudentStatus::inRandomOrder()->pluck('id')->first(),
        'programe_title' => $faker->sentence,
        'programme_type' => Program::inRandomOrder()->pluck('id')->first(),
        'funding_type' => FundingType::inRandomOrder()->pluck('id')->first(),
        'mode_of_study' => ModeOfStudy::inRandomOrder()->pluck('id')->first(),
        'tierFour' => $faker->boolean,
    ];
});
