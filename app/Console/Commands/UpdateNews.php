<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Console\Commands\Services\UpdateNewsService;

class UpdateNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update news database from the Yandex News service';

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
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('Do you wish to update news database?')) {
            $this->info('Updating news database...');
            $service = new UpdateNewsService();
            $service->handle();
            $this->info('Update is successful completed.');
            return true;
        } else {
            $this->info('Operation canceled.');
        }

        return false;
    }
}
