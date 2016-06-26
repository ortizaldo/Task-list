@if (count($tasks) > 0)
<div class="panel-body">
  <table class="table table-striped task-table">
    <thead>
      <th>Task</th>
      <th>Fecha de Inicio</th>
      <th>Hora de Creacion</th>
      <th>Duracion</th>
      <th>Tiempo</th>
   </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr data-id="{{ $task->id }}">
                <td class="table-text"><div data-name="name">{{ $task->name }}</div></td>
                <td class="table-text"><div data-name="fecha_inicio">{{ $task->fecha_inicio }}</div></td>
                <td class="table-text"><div data-name="created_at">{{ date_format($task->created_at, 'H:i:s') }}</div></td>
                <td class="table-text"><div data-name="duration_task">{{ $task->duration_task }}</div></td>
                <td>
                    <form id="update_tiempo-{{ $task->id }}" action="{{url('task/pausarTiempo/' . $task->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" id="update_task-{{$task->id}}" name="update_time" value=""></input>
                        <button type="button" class="btn btn-success parar" id="update_button-{{ $task->id }}">
                            <i class="fa fa-pause"></i>
                        </button>
                    </form>
                    
                </td>
                <td>
                    <button type="button" id="continuar{{ $task->id }}" class="btn btn-info continuar">
                        <i class="fa fa-history"></i>
                    </button>
                </td>
                <td>
                    <form action="{{url('task/' . $task->id)}}" method="POST" onsubmit="reinicio({{$task->id}})">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" id="duration_task-{{$task->id}}" name="duration_task" value=""></input>
                        <input type="hidden" id="end_tasks-{{$task->id}}" name="end_tasks" value="1"></input>
                        <button type="submit" class="btn btn-warning reinicio{{ $task->id }}" id="update-task-{{ $task->id }}" class="btn btn-info">
                            <i class="fa fa-stop"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endif
