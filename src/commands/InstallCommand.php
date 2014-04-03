<?php

namespace Efusionsoft\Mis\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Sentry;

class InstallCommand extends Command 
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mis:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mis install command';

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
     * @return void
     */
    public function fire()
    {
        $this->info('## Mis Install ##');

        // publish sentry config
        $this->call('config:publish', array('package' => 'cartalyst/sentry' ) );

        // publish syntara config
        $this->call('config:publish', array('package' => 'efusionsoft\mis' ) );

        // publish syntara assets
        $this->call('asset:publish', array('package' => 'efusionsoft\mis' ) );

        // run migrations
        $this->call('migrate', array('--env' => $this->option('env'), '--package' => 'cartalyst/sentry' ) );
        $this->call('migrate', array('--env' => $this->option('env'), '--package' => 'efusionsoft\mis' ) );

        // create admin group
        try
        {
            $this->info('Creating "Admin" group...');
            $group = Sentry::getGroupProvider()->create(array(
                'name'        => 'Admin',
                'permissions' => array(
                    'superuser' => 1
                ),
            ));

            $this->info('"Admin" group created with success');
        }
        catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
        {
            $this->info('"Admin" group already exists');
        }
    }
}