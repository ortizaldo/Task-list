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
                    ->orderBy('created_at', 'desc')
                    ->get();
    }
    public function tasksCurrent($user)
    {
        return Task::where('user_id', $user)
                    ->where('end_tasks', 0)
                    ->where('duration_task', '>=', '00:00:00')
                    ->orderBy('created_at', 'desc')
                    ->get();
    }
    public function tasksToDo($user, $task)
    {
        return Task::where('user_id', $user)
                    ->where('id', $task)
                    ->where('end_tasks', 0)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }
  
    public function endTasksForUser($user)
    {
        return Task::where('user_id', $user)
                    ->where('end_tasks', 1)
                    ->where('fecha_inicio', date('Y-m-d'))
                    ->orderBy('fecha_fin', 'asc')
                    ->get();
    }
    public function searchTasks($userID,$task,$dateFrom,$dateTo)
    {
        if($task != "" && $dateFrom == "" && $dateTo == ""){
            return Task::where('name', 'LIKE', "%$task%")
                    ->where('user_id', $userID)
                    ->orderBy('fecha_fin', 'asc')
                    ->get(); 
        }elseif($task != "" && $dateFrom != "" && $dateTo != ""){
            return Task::where('name', 'LIKE', "%$task%")
                    ->where('user_id', $userID)
                    ->whereBetween('fecha_inicio', array($dateFrom, $dateTo))
                    ->orderBy('fecha_fin', 'asc')
                    ->get(); 
        }elseif($task == "" && $dateFrom != "" && $dateTo != ""){
            return Task::where('user_id', $userID)
                    ->whereBetween('fecha_inicio', array($dateFrom, $dateTo))
                    ->orderBy('fecha_fin', 'asc')
                    ->get(); 
        }else{
            return Task::where('end_tasks', 1)
                    ->where('user_id', $userID)
                    ->orderBy('created_at', 'desc')
                    ->get();
        }
    }
}