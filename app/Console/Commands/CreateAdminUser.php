<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

#[Signature('admin:create {email : The administrator email address}')]
#[Description('Create an administrator account for the CMS')]
class CreateAdminUser extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = strtolower(trim((string) $this->argument('email')));
        $validator = Validator::make(['email' => $email], ['email' => ['required', 'email', 'max:255']]);

        if ($validator->fails()) {
            $this->components->error('Enter a valid email address.');

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();
        $name = $user?->name ?? $this->ask('Administrator name');

        if (! is_string($name) || trim($name) === '') {
            $this->components->error('A name is required.');

            return self::FAILURE;
        }

        $attributes = ['name' => trim($name), 'is_admin' => true];

        if ($user === null) {
            $password = $this->secret('Choose an administrator password (12 characters minimum)');
            $confirmedPassword = $this->secret('Confirm the password');

            if (! is_string($password) || strlen($password) < 12 || $password !== $confirmedPassword) {
                $this->components->error('The password must be at least 12 characters and match its confirmation.');

                return self::FAILURE;
            }

            $attributes['password'] = Hash::make($password);
        }

        User::query()->updateOrCreate(['email' => $email], $attributes);
        $this->components->info($user === null ? 'Administrator account created.' : 'Administrator access enabled for the existing account.');

        return self::SUCCESS;
    }
}
