<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GeneratePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:generate {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a hashed password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $password = $this->argument('password');

        $hashedPassword = Hash::make($password);

        $this->info('Hashed password: ' . $hashedPassword);

        return 0;
    }
}
