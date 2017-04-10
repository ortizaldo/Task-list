@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Nueva Tarea
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Tarea</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Descripcion</label>
                            <div class="col-sm-6">
                                <textarea name="descripcion" id="task-descripcion" class="form-control" rows="3" cols="2"></textarea>
                            </div>  
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <input type="hidden" id="task-end_tasks" name="end_tasks" value="0"></input>
                                <input type="hidden" id="task-fecha_inicio" name="fecha_inicio" value=""></input>
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Agregar Tarea
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-offset-1 col-lg-10 col-md-11 col-sm-2 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-pills">
                        <li id="tabInProgress" role="presentation">
                            <a id="currentTasks" href="#current" data-toggle='tab' data-id="{{ Auth::user()->id }}">
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                Tareas en progreso
                            </a>
                        </li>
                        <li id="tabToDo" role="presentation" class="active">
                            <a id="tasksTodo" class="todoTasks" href="#ToDo" data-toggle='tab' data-id="{{ Auth::user()->id }}">
                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                Tareas por hacer
                            </a>
                        </li>
                        <li id="tabHistoryToDo" role="presentation">
                            <a id="historyTasks" class="historyTasks" href="#history" data-toggle='tab' data-id="{{ Auth::user()->id }}">
                                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                Tareas completadas
                            </a>
                        </li>
                        <li role="presentation">
                            <a data-id="{{ Auth::user()->id }}">
                                <div>
                                    <div class="reloj" ><i class="fa fa-clock-o" aria-hidden="true"></i> </div>
                                    <div class="reloj" id="Horas">00</div>
                                    <div class="reloj">:</div>
                                    <div class="reloj" id="Minutos">00</div>
                                    <div class="reloj">:</div>
                                    <div class="reloj" id="Segundos">00</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-pane">
                        <div class="tab-pane" id="current">
                            <div id="resTodoTasks">
                                
                            </div>
                        </div>  
                        <div class="tab-pane" id="ToDo">
                            @include('tasks.currentTasks')
                        </div>
                        <div class="tab-pane" id="history">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection