<?php

namespace App\Console\Commands;

use App\Models\Link;
use Illuminate\Console\Command;

class DeleteExpiredShortLink extends Command
{
        /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:expired-short-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all short links that have expired.';

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
        Link::deleteExpiredShortLinks();
        $this->info('Expired short links deleted successfully.');
    }
}
