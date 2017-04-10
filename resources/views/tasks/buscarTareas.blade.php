@if (count($tasks) > 0)
<div class="panel-body" id="tasks-container">
  <table class="table table-striped task-table">
    <thead>
      <th>Task</th>
      <th>Descripcion</th>
      <th>Fecha de Inicio</th>
      <th>Hora de Creacion</th>
      <th>Duracion</th>
   </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr data-id="{{ $task->id }}">
                <td class="table-text"><div data-name="name">{{ $task->name }}</div></td>
                <td class="table-text"><div data-name="name">{{ $task->descripcion }}</div></td>
                <td class="table-text"><div data-name="fecha_inicio">{{ $task->fecha_inicio }}</div></td>
                <td class="table-text"><div data-name="created_at">{{ date_format($task->created_at, 'H:i:s') }}</div></td>
                <td class="table-text"><div data-name="duration_task">{{ $task->duration_task }}</div></td>
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
        {{ $tasks->links() }}
    </tbody>
    
  </table>
</div>
@endif