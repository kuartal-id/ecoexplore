<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'ecoexplore:admin {email : Email of an existing account} {--revoke : Remove admin rights instead}';

    protected $description = 'Grant (or revoke) Ecoexplore admin access for an existing user';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('No user with that email. They must register or sign in with Kuartal ID first.');

            return self::FAILURE;
        }

        $user->forceFill(['is_admin' => ! $this->option('revoke')])->save();

        $this->info($this->option('revoke')
            ? "Admin access revoked for {$user->email}."
            : "{$user->email} is now an Ecoexplore admin.");

        return self::SUCCESS;
    }
}
