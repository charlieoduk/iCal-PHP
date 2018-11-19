<?php

use Illuminate\Database\Seeder;
use App\Models\TechEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TechEvents::class, 10)->create();
        $this->call("SubscriberTableSeeder");
    }
}
