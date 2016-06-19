@if (count($tasks) > 0)
<div class="panel-body">
  <table class="table table-striped task-table">
    <thead>
      <th>Task</th>
      <th>Hora de Creacion</th>
      <th>Duracion</th>
      <th>Tiempo</th>
   </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td class="table-text"><div>{{ $task->name }}</div></td>
                <td class="table-text"><div>{{ date_format($task->created_at, 'H:i:s') }}</div></td>
                <td class="table-text"><div>{{ $task->duration_task }}</div></td>
                <td class="table-text">
                  <div>
                      <div class="reloj" id="Horas-{{ $task->id }}">00</div>
                      <div class="reloj">:</div>
                      <div class="reloj" id="Minutos-{{ $task->id }}">00</div>
                      <div class="reloj">:</div>
                      <div class="reloj" id="Segundos-{{ $task->id }}">00</div>
                  </div>
                </td>
                <!-- Task Delete Button -->
                <td>
                    <button type="submit" id="inicio{{ $task->id }}" class="btn btn-primary" onclick="inicio({{ $task->id }});">
                        <i class="fa fa-play-circle"></i>
                    </button>
                </td>
                <td>
                    <button type="submit" id="parar{{ $task->id }}" class="btn btn-success" onclick="parar({{ $task->id }});">
                        <i class="fa fa-pause"></i>
                    </button>
                </td>
                <td>
                    <button type="button" id="continuar{{ $task->id }}" class="btn btn-info" onclick="inicio({{ $task->id }});">
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
                <td>
                    <form action="{{url('task/' . $task->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                            <i class="fa fa-btn fa-trash"></i>Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endif
