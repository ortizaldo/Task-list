@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Task</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea name="descripcion" id="task-descripcion" class="form-control" rows="3" cols="2"></textarea>
                            </div>  
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <input type="hidden" id="task-end_tasks" name="end_tasks" value="0"></input>
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
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
                            <a id="currentTasks" href="#current" data-toggle='tab'>
                                <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                                Current Tasks
                            </a>
                        </li>
                        <li role="presentation">
                            <a id="historyTasks" class="historyTasks" href="#history" data-toggle='tab' data-id="{{ Auth::user()->id }}">
                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                History Tasks
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content clearfix">
                        <div class="tab-pane active" id="current">
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