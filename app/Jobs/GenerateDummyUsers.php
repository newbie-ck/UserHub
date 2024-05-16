<?php

namespace App\Jobs;

use Faker\Factory;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GenerateDummyUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $count;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($count)
    {
        $this->count = $count;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {    
        for ($i = 0; $i < $this->count; $i++) {
            $faker = Factory::create();
            $username = $this->generateUniqueUsername();
            $email = $this->generateUniqueEmail();
            $phoneNumber = $this->generateUniquePhoneNumber();
            $isAdmin = (bool) random_int(0, 1); // Randomly assign true or false

            User::create([
                'username' => $username,
                'name' => $faker->name,
                'password' => bcrypt('123ABCd@@@'),
                'email' => $email,
                'phone_number' => $phoneNumber,
                'is_admin' => $isAdmin,
            ]);
        }
    
        return response()->json(['message' => 'Dummy user generation job dispatched successfully']);
    }

    protected function generateUniqueUsername()
    {
        $number = mt_rand(10000, 99999);
        $username = "dummyUser" . $number;

        while (User::where('username', $username)->exists()) {
            $number = mt_rand(10000, 99999);
            $username = "dummyUser" . $number;
        }

        return $username;
    }

    protected function generateUniqueEmail()
    {
        $faker = Factory::create();
        $email = $faker->email;

        while (User::where('email', $email)->exists()) {
            $email = $faker->email;
        }

        return $email;
    }

    protected function generateUniquePhoneNumber()
    {
        $phoneNumber = '601' . mt_rand(10000000, 99999999);

        while (User::where('phone_number', $phoneNumber)->exists()) {
            $phoneNumber = '601' . mt_rand(10000000, 99999999);
        }

        return $phoneNumber;
    }
}
