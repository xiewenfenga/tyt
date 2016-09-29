<?php

namespace App\Console\Commands;

use App\Repositories\TaskRepository;
use Illuminate\Console\Command;

class task extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'census task is end';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $taskRepository)
    {
        parent::__construct();
        $this->taskRepository = $taskRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {;
        $where['end_time <'] = time();
        $tasks = $this->taskRepository->taskModel->alls(['id','status','end_time'],$where);
        if(!empty($tasks)) {
            foreach($tasks as $taskModel) {
                $taskModel->status = 2;
                $taskModel->save();
            }
        }
    }
}
