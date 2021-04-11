<?php
/**
 * Command to generate and set application key in ,env file
 *
 * PHP version 7
 *
 * @author Okiemute Omuta <iamkheme@gmail.com>
 */
namespace App\Console\Commands;

use Illuminate\Console\Command;

class KeyGenerateCommand extends Command
{

    protected $signature   = 'key:generate
                             {--show : Display the key instead of modifying files}';
    protected $description = 'Generate an application key';

    protected $application_key;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->application_key = $this->generateRandomKey();

        if ($this->option('show')) {
            return $this->line("<comment>{$this->application_key}</comment>");
        }

        $this->setKeyInEnvironmentFile();

        $this->laravel['config']['app.key'] = $this->application_key;

        $this->info("Application key {$this->application_key} set successfully.");
    }

    /**
     * Set the environment key in the environment file
     * 
     * @return void
     */
    protected function setKeyInEnvironmentFile()
    {
        file_put_contents(
            $this->laravel->basePath('.env'),
            str_replace(
                "APP_KEY={$this->laravel['config']['app.key']}",
                "APP_KEY={$this->application_key}",
                file_get_contents($this->laravel->basePath('.env'))
            )
        );
    }

    /**
     * Generate a random key for the application
     *
     * @return string
     */
    protected function generateRandomKey()
    {
        return 'base64:' . base64_encode(random_bytes(
            $this->laravel['config']['app.cipher'] == 'AES-128-CBC' ? 16 : 32
        ));
    }
}
