<?php

use Illuminate\Database\Seeder;
use App\Models\College;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $example_colleges = [
            'College of Arts',
            'College of Science',
            'College of Social Science'];

        foreach ($example_colleges as $college)
        {
            College::create( [ 'name' => $college ] );
        }
    }
}
