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

$factory->define(App\Models\Student::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'user_type' => 'student',
    ];
});

$factory->define(App\Models\Staff::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'user_type' => 'staff',
    ];
});

$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'user_type' => 'admin',
    ];
});

$factory->define(App\Models\Wizard::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'user_type' => 'wizard',
    ];
});

$factory->define(App\Models\StudentRecord::class, function (Faker\Generator $faker) {

    static $college_list = 
    [
        'College of Arts' => 
        [
            'School of Architecture & Design',
            'School of English & Journalism',
            'Lincoln School of Film & Media',
            'School of Fine & Performing Arts',
            'School of History & Heritage',
        ],

        'College of Science' =>
        [
            'School of Chemistry',
            'School of Computer Science',
            'School of Engineering',
            'School of Geography',
            'School of Life Sciences',
            'School of Mathematics and Physics',
            'School of Pharmacy',
        ],

        'College of Social Science' =>
        [
            'School of Education',
            'School of Health and Social Care ',
            'Lincoln Law School',
            'School of Psychology',
            'School of Social & Political Sciences',
            'School of Sport and Exercise Science',
            'International Business School',
        ],
    ];

    return [
        'student_id' => App\Models\Student::inRandomOrder()->first()->id,
        'college' => $college = $faker->randomElement( array_keys( $college_list ) ),
        'school' =>  $faker->randomElement( $college_list[$college] ),
        'enrolment_date' =>  Carbon\Carbon::now(),
        'student_status' => $faker->randomElement(['home', 'eu', 'international']),
        'programme' => $faker->randomElement(['phd', 'phd/mphil', 'msc']), 
        'enrolment_status' => $faker->randomElement(['not enrolled', 'enrolled', 'submitted', 'graduated']),
        'funding_type' => $faker->company,
        'mode_of_study' => $faker->randomElement(['full time', 'part time']),
    ];
});