<?php

namespace App\Http\Controllers;

use App\Task;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;
    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;
    }
    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }
  
    public function getTasks($user)
    {
        //echo 'algo '.$this->tasks->endTasksForUser($user);
        //dd($user);
        return view('tasks.historyTasks', [
            'tasks' => $this->tasks->endTasksForUser($user),
        ]);
    }
    public function getTasksCurrent($user)
    {
        //echo 'algo '.$this->tasks->endTasksForUser($user);
        //dd($user);
        return view('tasks.inProgressTasks', [
            'tasks' => $this->tasks->tasksCurrent($user),
        ]);
    }
    public function getTasksToDo($user, $task)
    {
        //echo 'algo '.$this->tasks->endTasksForUser($user);
        //dd($user);
        return view('tasks.inProgressTasks', [
            'tasks' => $this->tasks->tasksToDo($user, $task),
        ]);
    }
  
    public function buscarTasks()
    {
        return view('tasks.buscarTasks');
    }
    public function buscarTareas(Request $request)
    {
        // Create The Task...
        $task=$request->name;
        $dateFrom=$request->dateFrom;
        $dateTo=$request->dateTo;
        //dd($task." ".$dateFrom." ".$dateTo);
        return view('tasks.buscarTareas', [
            'tasks' => $this->tasks->searchTasks($task,$dateFrom,$dateTo),
        ]);
    }
  
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'descripcion' => 'required',
        ]);

        // Create The Task...
        $request->user()->tasks()->create([
            'name' => $request->name,
            'descripcion' => $request->descripcion,
            'end_tasks' => $request->end_tasks,
            'fecha_inicio' => $request->fecha_inicio,
        ]);
        return redirect('/tasks');
    }
    
    public function update(Request $request, Task $task)
    {
        // Update The Task...
        //return redirect('/tasks');
        $this->authorize('update', $task);
        $task::find($task->id);
        $task->duration_task = $request->duration_task;
        $task->end_tasks = $request->end_tasks;
        $task->fecha_fin = date("Y-m-d");
        $task->save();
        return redirect('/tasks');
    }
  
    public function updateTime(Request $request, Task $task)
    {
        // Update The Task...
        //return $task;
        //dd($request);
        
        $this->authorize('update', $task);
        $task::find($task->id);
        $task->duration_task = $request->update_time;
        $task->save();
        return $task;
        //return redirect('/tasks');
    }
    
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
}
