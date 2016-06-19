$( document ).ready(function() {
    //timepickers
    $('#dateFrom').datetimepicker({
        format:"YYYY-MM-DD",
    });
    $('#dateTo').datetimepicker({
        format:"YYYY-MM-DD",
    });
    $("#dateFrom").on("dp.change", function(e) {
        $('#dateTo').data("DateTimePicker").minDate(e.date);
    });
    var tiempo = {
        hora: 0,
        minuto: 0,
        segundo: 0
    };
    var tiempo_corriendo = null;
    function inicio (taskID) {
        control = cronometro(taskID);
        $("#inicio"+taskID).prop('disabled', true);
        $("#parar"+taskID).prop('disabled', false);
        $("#continuar"+taskID).prop('disabled', true);
        $(".reinicio"+taskID).prop('disabled', false);
    }
    function reinicio (taskID) {
        clearInterval(tiempo_corriendo);

        tiempo.segundo = 0;
        tiempo.minuto = 0;
        tiempo.hora = 0;
        $("#duracion-"+taskID).val();
        $("#Segundos-"+taskID).text("00");
        $("#Minutos-"+taskID).text("00");
        $("#Horas-"+taskID).text("00");
        $("#inicio"+taskID).attr('disabled', 'disabled');
        $("#parar"+taskID).attr('disabled', 'disabled');
        $("#continuar"+taskID).attr('disabled', 'disabled');
        $(".reinicio"+taskID).attr('disabled', 'disabled');
    }
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
            $("#Horas-"+taskID).text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
            $("#Minutos-"+taskID).text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
            $("#Segundos-"+taskID).text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
            $("#duration_task-"+taskID).val(tiempo.hora+':'+tiempo.minuto+':'+tiempo.segundo);
        }, 1000);
    }
    function parar (taskID) {
        clearInterval(tiempo_corriendo);
        document.getElementById("parar"+taskID).disabled = true;
        document.getElementById("continuar"+taskID).disabled = false;
    }
    var csrfToken = $('[name="_token"]').attr('content');
    setInterval(refreshToken, 3600000); // 1 hour 

    function refreshToken(){
        $.get('refresh-csrf').done(function(data){
            csrfToken = data; // the new token
        });
    }
    setInterval(refreshToken, 3600000); // 1 hour
    $( "#historyTasks" ).click(function() {
        var user=$("#historyTasks").attr("data-id");
        $.get('/tasks/'+user).done(function(data){
            $("#history").html(data);
        });
    });
});