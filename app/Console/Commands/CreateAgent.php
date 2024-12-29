<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAgent extends Command
{
    protected $signature = 'agent:create';

    protected $description = 'Create a new agent in the system';

    public function handle()
    {
        $name = $this->ask('Enter the agent\'s name');
        $email = $this->ask('Enter the agent\'s email address');
        $password = $this->secret('Enter the agent\'s password');

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Agent created successfully: '.$user->name);
    }
}
