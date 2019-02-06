<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Distributor;
use App\Jobs\SendEmailJob;
use App\Customs\Repository\DistributorRepository;

class RenewPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passwd:renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Random Password Generation';

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
     * ToDo
     * - Optimize update function
     * 
     * @return mixed
     */
    public function handle()
    {
        $this->info('Search distributor...');

        $distributors = DistributorRepository::renewPasswd();

        foreach ($distributors as $key => $value) {
            Distributor::where('_id', $value['_id'])
                ->update([
                    'password' => bcrypt($value['password'])
                ]);

            dispatch(new SendEmailJob($value));
        }

        $this->info('The passwords has been saved successfully...');
    }
}