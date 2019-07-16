<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Question\Question;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risky:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simplify installation process';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->welcome();

        $this->createEnvFile();

        if (strlen(config('app.key')) === 0) {
            $this->call('key:generate');

            $this->line('~ Secret key properly generated.');
        }

        $credentials = $this->requestDatabaseCredentials();

        $this->updateEnvironmentFile($credentials);

        if ($this->confirm('Do you want to migrate the database?', false)) {
            $this->migrateDatabaseWithFreshCredentials($credentials);

            $this->line('~ Database successfully migrated.');

            $this->seedDatabase();

            $this->line('~ Roles and test user added successfully.');
        }

        if ($this->confirm('Do you want to seed the database with dummy data?', false)) {
            $this->line('~ This will take a few minutes...');

            $this->seedDatabaseWithDummyData();

            $this->line('~ Database successfully seeded.');
        }

        if ($this->confirm('Risky Picker only supports user registration by invitation.
                Would you like to add 3rd party email service', false)) {
            $credentials = $this->requestEmailCredentials();

            $this->updateEnvironmentFile($credentials);
        }

        if ($this->confirm('Do you want to integrate with slack? ', false)) {
            $this->requestSlackredentials();

            $this->updateEnvironmentFile($credentials);
        }

        $this->call('cache:clear');

        $this->goodbye();
    }

    /**
     * Update the .env file from an array of $key => $value pairs.
     *
     * @param  array $updatedValues
     * @return void
     */
    protected function updateEnvironmentFile($updatedValues)
    {
        $envFile = $this->laravel->environmentFilePath();

        foreach ($updatedValues as $key => $value) {
            file_put_contents($envFile, preg_replace(
                "/{$key}=(.*)/",
                "{$key}={$value}",
                file_get_contents($envFile)
            ));
        }
    }

    /**
     * Display the welcome message.
     */
    protected function welcome()
    {
        $this->info('>> Welcome to the Risky Picker installation process! <<');
    }

    /**
     * Display the completion message.
     */
    protected function goodbye()
    {
        $this->info('>> The installation process is complete. Enjoy your coffee! <<');
    }

    /**
     * Request the local database details from the user.
     *
     * @return array
     */
    protected function requestDatabaseCredentials()
    {
        return [
            'DB_DATABASE' => $this->ask('Database name'),
            'DB_PORT' => $this->ask('Database port', 3306),
            'DB_USERNAME' => $this->ask('Database user'),
            'DB_PASSWORD' => $this->askHiddenWithDefault('Database password (leave blank for no password)'),
        ];
    }

    /**
     * Request the local database details from the user.
     *
     * @return array
     */
    protected function requestEmailCredentials()
    {
        return [
            'MAIL_DRIVER' => $this->ask('Mail driver', 'smtp'),
            'MAIL_HOST' => $this->ask('Mail host', 'smtp.mailtrap.io'),
            'MAIL_PORT' => $this->ask('Mail port', 2525),
            'MAIL_USERNAME' => $this->ask('Mail username'),
            'MAIL_PASSWORD' => $this->askHiddenWithDefault('Mail password (leave blank for no password)'),
        ];
    }

    /**
     * Request a slack app webhook url to send notifications to
     * any required channels.
     *
     * @return array
     */
    protected function requestSlackredentials()
    {
        return [
            'LOG_SLACK_WEBHOOK_URL' => $this->ask('Slack Webhook Url'),
        ];
    }

    /**
     * Create the initial .env file.
     */
    protected function createEnvFile()
    {
        if (! file_exists('.env')) {
            copy('.env.example', '.env');

            $this->line('.env file successfully created');
        }
    }

    /**
     * Migrate the db with the new credentials.
     *
     * @param array $credentials
     * @return void
     */
    protected function migrateDatabaseWithFreshCredentials($credentials)
    {
        foreach ($credentials as $key => $value) {
            $configKey = strtolower(str_replace('DB_', '', $key));

            if ($configKey === 'password' && $value == 'null') {
                config(["database.connections.mysql.{$configKey}" => '']);

                continue;
            }

            config(["database.connections.mysql.{$configKey}" => $value]);
        }

        $this->call('migrate:fresh');
    }

    /**
     * Seed the database with roles and admin user
     *
     * @return void
     */
    public function seedDatabase()
    {
        $this->call('db:seed', [
            '--class' => 'RolesTableSeeder',
        ]);
        $this->call('db:seed', [
            '--class' => 'UsersTableSeeder',
        ]);
    }

    /**
     * Seed the database with dummy data
     *
     * @return void
     */
    public function seedDatabaseWithDummyData()
    {
        $this->call('db:seed', [
            '--class' => 'DummyDataSeeder',
        ]);
    }

    /**
     * Prompt the user for optional input but hide the answer from the console.
     *
     * @param  string  $question
     * @param  bool    $fallback
     * @return string
     */
    public function askHiddenWithDefault($question, $fallback = true)
    {
        $question = new Question($question, 'null');

        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }
}
