<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

/**
 * Creates an admin account, or grants admin access and resets the password of an existing user.
 *   php artisan admin:create
 *   php artisan admin:create --name="Admin" --email=admin@example.com   (password is always asked)
 */
class CreateAdmin extends Command
{
    protected $signature = 'admin:create {--name= : Full name} {--email= : Login email}';

    protected $description = 'Create an admin-panel user (or promote an existing user to admin)';

    public function handle(): int
    {
        $email = $this->option('email') ?: text('Email', required: true);
        $existing = User::where('email', $email)->first();
        $name = $this->option('name') ?: ($existing?->name ?? text('Name', required: true));
        $password = password('Password (min. 8 characters)', required: true);

        $validator = Validator::make(compact('name', 'email', 'password'), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = $existing ?? new User;
        $user->forceFill([
            'name' => $name,
            'email' => $email,
            'password' => $password,   // hashed by the model cast
            'is_admin' => true,
        ])->save();

        $this->info(($existing ? 'Updated' : 'Created')." admin account for {$email}. Log in at ".url('/admin/login'));

        return self::SUCCESS;
    }
}
