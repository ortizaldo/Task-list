<?php

namespace App\Repositories;

use App\User;
use App\Task;

class TaskRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Task::where('user_id', $user->id)
                    ->where('end_tasks', 0)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
  
    public function endTasksForUser($user)
    {
        return Task::where('user_id', $user)
                    ->where('end_tasks', 1)
                    ->orderBy('date_end', 'asc')
                    ->get();
    }
}