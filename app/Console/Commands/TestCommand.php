<?php

namespace App\Console\Commands;

use App\Repositories\Category\CategoryRepository;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(CategoryRepository $categoryRepository)
    {
        $data = [1,2,3];
        foreach ($data as  $value) {
            $abc=$categoryRepository->testCommand();
            $results[]=$abc;
        }
        return $results;
    }
}
