
$(document).ready(function () {


    document.addEventListener("DOMContentLoaded", function () {
        var scrollbar = document.body.clientWidth - window.innerWidth + 'px';
        console.log(scrollbar);
        document.querySelector('[href="#addTask"]').addEventListener('click', function () {
            document.body.style.overflow = 'hidden';
            document.querySelector('#newTask').style.marginLeft = scrollbar;
        });
        document.querySelector('[href="#close"]').addEventListener('click', function () {
            document.body.style.overflow = 'visible';
            document.querySelector('#newTask').style.marginLeft = '0px';
        });
    });
    $("#searchBtn").click(function () {
        const id = $("#team").val();
        $.ajax({
            dataType: 'json',
            method: "POST",
            url: "/tasksAjax",
            data: {idUser: id, method: "getTaskHtml"},
            success: function (data) {
                if (data.html) {
                    $("#tasks").empty().append(data.html);
                }
            }
        })

    })


    $('#addBtn').click(function () {
        const id = $('#taskID').val();
        const name = $("#nameText").val();
        const description = $("#descrText").val();
        const date = $("#dateText").val();
        const executer = $("#executerCombo").val();
        const priority = $("#priorityCombo").val();
        const status=$("#statusCombo").val();
        $.ajax({
            dataType: 'json',
            method: "POST",
            url: "/tasksAjax",
            data: {id,name, description, date, executer, priority,status, method: "Upsert"},
            success: function () {
                console.log("Успешно добавлено!");

            },
            complete: function () {
                $("#closeBtn").click();
            }
        })

    })
    function PrepareTaskModal (action){
        if (action==="new"){
            $('#addBtn').text("Добавить");
            $('.modal-title').text("Новая задача");
        }
        else{
            $('#addBtn').text("Изменить");
            $('.modal-title').text("Изменить задачу");
        }
    }
    $('#tasks').on('click','.taskLI',function () {
        console.log("Зашел");
        const id = $(this).attr("id");
        var scrollbar = document.body.clientWidth - window.innerWidth + 'px';
        console.log(id);
        $.ajax({
            dataType: 'json',
            method: 'post',
            url: '/tasksAjax',
            data: {task_id: id, method: "viewTask"},
            success: function (data) {
                if (data.html) {
                    $("#taskmodal").empty().append(data.html);
                    document.querySelector('#newTask').style.opacity = 1;
                    document.querySelector("#newTask").style.pointerEvents = 'auto';
                    document.body.style.overflow = 'hidden';
                    document.querySelector('#newTask').style.marginLeft = scrollbar;
                    if (data.task) {
                        $('#taskID').val(id);
                        const name = data.task["name"];
                        $("#nameText").prop( "disabled", !data.enabled ).val(name);
                        const descr = data.task["description"];
                        $("#descrText").prop( "disabled", !data.enabled ).val(descr);
                        const date = data.task["date_end"];
                        $('#dateText').prop( "disabled", !data.enabled ).val(date);
                        $("#priorityCombo").prop( "disabled", !data.enabled ).val(data.task.priority_id);
                        $("#executerCombo").prop( "disabled", !data.enabled );
                        $('#statusCombo').val(data.task.status_id);
                        PrepareTaskModal("edit");
                        //$("#descrText").val(descr);

                    }
                    //$('#executerCombo').val(data.task.executer_id);

                }
            }
        })
    })
    $('#SelectTime').click(function (){
        const time=$("#timeTask").val();
        $.ajax({
            dataType:'json',
            url:'/tasksAjax',
            method: 'post',
            data: {time, method:"GetTasksForTime"},
            success: function (data){
                if (data.html) {
                    $("#tasks").empty().append(data.html);
                }
                console.log("Complete");
            }
        })
    })
})



