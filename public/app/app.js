var tiempo = {
    hora: 0,
    minuto: 0,
    segundo: 0
};
var tiempo_corriendo = null;
function cronometro (taskID) {
    tiempo_corriendo = setInterval(function(){
        // Segundos
        tiempo.segundo++;
        if(tiempo.segundo >= 60)
        {
            tiempo.segundo = 0;
            tiempo.minuto++;
        }
        // Minutos
        if(tiempo.minuto >= 60)
        {
            tiempo.minuto = 0;
            tiempo.hora++;
        }
        $("#Horas").text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
        $("#Minutos").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
        $("#Segundos").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
        $("#duration_task-"+taskID).val(tiempo.hora+':'+tiempo.minuto+':'+tiempo.segundo);
        $("input[name='update_time']").val(tiempo.hora+':'+tiempo.minuto+':'+tiempo.segundo);
    }, 1000);
    
}
$( document ).ready(function() {
    $('#task-fecha_inicio').val(moment().format("YYYY-MM-DD"));
    //timepickers
    $('#dateFrom').datetimepicker({
        format:"YYYY-MM-DD",
    });
    $('#dateTo').datetimepicker({
        format:"YYYY-MM-DD",
    });
    $("#dateFrom").on("dp.change", function(e) {
        $('#dateTo').data("DateTimePicker").minDate(e.date);
        $('#dpFrom').val(moment(e.date).format("YYYY-MM-DD"));
    });
    $("#dateTo").on("dp.change", function(e) {
        $('#dpTo').val(moment(e.date).format("YYYY-MM-DD"));
    });
    var csrfToken = $('[name="_token"]').attr('content');
    setInterval(refreshToken, 3600000); // 1 hour 
    function refreshToken(){
        $.get('refresh-csrf').done(function(data){
            csrfToken = data; // the new token
        });
    }
    setInterval(refreshToken, 3600000); // 1 hour
    $('#tabInProgress a').click(function (e) {
        e.preventDefault();
        $('#ToDo').hide();
        $('#history').hide();
        $('#current').show();
    })
    $('#tabToDo a').click(function (e) {
        e.preventDefault();
        $('#ToDo').show();
        $('#history').hide();
        $('#current').hide();
    })
    $('#tabHistoryToDo a').click(function (e) {
        e.preventDefault();
        $('#ToDo').hide();
        $('#history').show();
        $('#current').hide();
        console.log('historyTasks');
        var user=$("#historyTasks").attr("data-id");
        $.get('/tasks/'+user).done(function(data){
            $("#history").html(data);
        });
    })
    $(".inicio").click(function(e) {
        e.preventDefault();
        var row=$(this).parents("tr");
        var idTask=row.data('id');
        var duracion=$('tr[data-id='+idTask+'] div[data-name="duration_task"]').text();
        duracion=duracion.split(':');
        tiempo.hora=parseInt(duracion[0],10);
        tiempo.minuto=parseInt(duracion[1],10);
        tiempo.segundo=parseInt(duracion[2],10);
        $("#Horas").text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
        $("#Minutos").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
        $("#Segundos").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
        var user=$("#tasksTodo").attr("data-id");
        var control = cronometro(idTask);
        $.get('/tasks/tasksTodo/'+user+'/'+idTask).done(function(data){
            $('#ToDo').hide();
            $("#resTodoTasks").html(data);
            $("#tabInProgress").addClass('active');
            $("#current").addClass('in');
            $("#current").addClass('active');
            $("#tabToDo").removeClass('active');
            $("#inicio"+idTask).prop('disabled', true);
            $("#continuar"+idTask).attr('disabled', 'disabled');
            $("#update_button-"+idTask).prop('disabled', false);
        });
    });
    $('#resTodoTasks').on('click', '.parar', function(e) {
        e.preventDefault();
        clearInterval(tiempo_corriendo);
        var row=$(this).parents("tr");
        var idTask=row.data('id');
        $("#continuar"+idTask).prop('disabled', false);
        clearInterval(tiempo_corriendo);
        $("#update_button-"+idTask).prop('disabled', true);
        $("#continuar"+idTask).prop('disabled', false);
        var form=$("#update_tiempo-"+idTask);
        var url=form[0].action;
        var dataForm=form.serialize();
        var type = "PUT";
        var formData = {
            duration_task: $('#update_task-'+idTask).val(),
        }
        $.ajax({
            type: type,
            url: url,
            data: dataForm,
            dataType: 'json',
            success: function (data) {
                $("tr[data-id="+data.id+"] div[data-name='duration_task']").html(data.duration_task);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    $('#buscarTareas').click(function(e) {
        e.preventDefault();
        var form=$("#formBuscarTareas");
        var url=form[0].action;
        var dataForm=form.serialize();
        var type = "POST";
        //console.log('datos a mandar', form+' '+url+' '+dataForm+' '+type);
        $.ajax({
            type: type,
            url: url,
            data: dataForm,
            success: function (data) {
                //console.log('success:', data);
                $("#resFormBusc").html(data);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    $('#resTodoTasks').on('click', '.continuar', function(e) {
        e.preventDefault();
        var row=$(this).parents("tr");
        var idTask=row.data('id');
        $("#continuar"+idTask).prop('disabled', true);
        $("#update_button-"+idTask).prop('disabled', false);
        var control = cronometro(idTask);
    });
});