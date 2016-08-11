@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-offset-2 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Busqueda de Tareas
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form id="formBuscarTareas" action="{{ url('/tasks/buscarTasks') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-md-3 control-label">Task</label>

                            <div class="col-md-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-name" class="col-md-3 control-label">Desde</label>
                            <div class="col-md-4">
                                <div class='input-group date' id='dateFrom'>
                                    <input name="dateFrom" type='text' class="form-control" value="" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-name" class="col-md-3 control-label">Hasta</label>
                            <div class="col-md-4">
                                <div class='input-group date' id='dateTo'>
                                    <input name="dateTo" type='text' class="form-control" value="" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-6">
                                <input name="userID" type='hidden' value="{{ Auth::user()->id }}" />
                                <button id="buscarTareas" type="button" class="btn btn-default">
                                    <i class="fa fa-search"></i>Buscar Tareas
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
                      <li role="presentation" class="active">
                        <a id="currentTasks" href="#!">
                            <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                            Task List
                        </a>
                      </li>
                    </ul>
                </div>
                <div id="resFormBusc">
                </div>
            </div>
        </div>
    </div>
@endsection