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
        return view('tasks.historyTasks', [
            'tasks' => $this->tasks->endTasksForUser($user),
        ]);
    }
    
    public function buscarTasks()
    {
        //echo 'algo '.$this->tasks->endTasksForUser($user);
        /*return view('tasks.historyTasks', [
            'tasks' => $this->tasks->endTasksForUser($user),
        ]);*/
        return view('tasks.buscarTasks');
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
        $task->date_end = date("Y-m-d H:i:s");
        $task->save();
        return redirect('/tasks');
    }
    
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
}
