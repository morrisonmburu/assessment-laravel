<?php

namespace App\Observers;

use App\Models\UserTask;
use App\Models\Status;
use Illuminate\Support\Facades\Log;

class UserTaskObserver
{
    public $afterCommit = true;
    /**
     * Handle the UserTask "created" event.
     */
    public function created(UserTask $userTask): void
    {
        //
    }

    /**
     * Handle the UserTask "updated" event.
     */
    public function updated(UserTask $userTask): void
    {
        // update status of main task if all subtasks are completed
        if ($userTask->status->name === 'Done') {
            $task = $userTask->task;
            $task->status()->associate(Status::where('name', 'Done')->first());
            $task->save();
            Log::info('Task ' . $task->name . ' is done');
        }
    }

    /**
     * Handle the UserTask "deleted" event.
     */
    public function deleted(UserTask $userTask): void
    {
        //
    }

    /**
     * Handle the UserTask "restored" event.
     */
    public function restored(UserTask $userTask): void
    {
        //
    }

    /**
     * Handle the UserTask "force deleted" event.
     */
    public function forceDeleted(UserTask $userTask): void
    {
        //
    }
}
