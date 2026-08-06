<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-token {name=AntigravityClient : Token identification name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Sanctum API token for external publishing tools (Antigravity, OpenCode, Codex CLI)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::first();

        if (!$user) {
            $user = User::create([
                'name' => 'API Admin',
                'email' => 'admin@dailyaiworld.tech',
                'password' => bcrypt(str_random(16)),
            ]);
        }

        $tokenName = $this->argument('name');
        $token = $user->createToken($tokenName)->plainTextToken;

        $this->info("========================================");
        $this->info("SANCTUM API TOKEN CREATED SUCCESSFULLY");
        $this->info("========================================");
        $this->line("Token Name: <comment>{$tokenName}</comment>");
        $this->line("Bearer Token: <fg=green;bg=black>{$token}</fg=green;bg=black>");
        $this->info("========================================");
        $this->comment("Use this token in external clients via Header:");
        $this->comment("Authorization: Bearer {$token}");
    }
}
