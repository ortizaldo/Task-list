@if (count($tasks) > 0)
    <div id="panel-history" class="panel-body">
        <table class="table table-striped task-table">
            <thead>
              <th>Task</th>
              <th>Description</th>
              <th>Hora de Creacion</th>
              <th>Duracion</th>
           </thead>
           <tbody>
              @foreach ($tasks as $task)
                  <tr>
                      <td class="table-text"><div>{{ $task->name }}</div></td>
                      <td class="table-text"><div>{{ $task->descripcion }}</div></td>
                      <td class="table-text"><div>{{ $task->created_at }}</div></td>
                      <td class="table-text"><div>{{ $task->duration_task }}</div></td>
                  </tr>
              @endforeach
          </tbody>
        </table>
    </div>
@endif
