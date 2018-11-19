<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubscriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("subscribers")->insert(
            [
                "first_name" => "Charles",
                "last_name" => "Oduk",
                "phone_number" => "+254722123456",
                "tech_events_id" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]
        );
    }
}
