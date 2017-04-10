<?php

namespace App\Http\Controllers;

use DB;
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
  
    public function buscarTasks(Request $request)
    {
        $tareas=$this->tasks->searchTasksAll();
        if ($request->ajax()) {  // If it's AJAX request, then:
            //dd($tareas);
            return view('tasks.buscarTareas', ['tasks' => $tareas])->render();  // render view and send it back as a raw HTML response
            /*return response()->json([
                'tasks' => $tareas,
            ]);*/
        }
        // If it is not AJAX request, then:
        return view('tasks.buscarTasks', ['tasks' => $tareas]);
    }
    public function buscarTareas(Request $request)
    {
        // Create The Task...
        $task=$request->name;
        $dateFrom=$request->dateFrom;
        $dateTo=$request->dateTo;
        $userID=$request->userID;
        //dd($request);
        $tareas=$this->tasks->searchTasks($userID,$task,$dateFrom,$dateTo);
        if ($request->ajax()){
            /*return response()->json(
                                     view('tasks.buscarTareas', [
                                             'tasks' => $tareas
                                          ])->render());*/
            return view('tasks.buscarTareas', [
                                             'tasks' => $tareas
                                          ]);
        }
        return view('tasks.buscarTareas', [
          'tasks' => $tareas,
        ]);
        
        /*return view('tasks.buscarTareas', [
            'tasks' => $tareas,
        ]);*/
    }
    
    public function ajaxPagination(Request $request)
      {
          // Create The Task...
          $task=$request->name;
          $dateFrom=$request->dateFrom;
          $dateTo=$request->dateTo;
          $userID=$request->userID;
          $tareas=$this->tasks->searchTasks($userID,$task,$dateFrom,$dateTo);
          dd($tareas);
          if ($request->ajax()){
              return $tareas;/*->json(/*
                                       view('tasks.presult', [
                                               'tasks' => $tareas
                                            ])->render());*/
              /*return view('tasks.presult', compact([
                                               'tasks' => $tareas
                                            ]));*/
          }
          return view('tasks.buscarTareas', [
            'tasks' => $tareas,
          ]);

          /*return view('tasks.buscarTareas', [
              'tasks' => $tareas,
          ]);*/
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
