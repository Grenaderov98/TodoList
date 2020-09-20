<?php
require "classes/taskClass.php";
$data = $_POST;
switch ($data["method"]) {
    case "getTaskHtml":
        $id = $data["idUser"];
        $tasks = Task::GetTasks($id,0);
        $array = (["html" => Task::GetTasksHtml($tasks)]);
        die(json_encode($array));
    case "Upsert":
        $id = $data["id"];
        $taskData=[
            "taskname" => $data["name"],
            "description" => $data["description"],
            "date_end" => $data["date"],
            "date_create" => date("Y-m-d"),
            "pId" => $data["priority"],
            "sId" => $data["status"],
            "creator_id"=>$_SESSION["logged_user_id"],
            "executer_id" => $data["executer"]];
        if (empty($id)){
            $task = new Task($taskData);

            Task::AddNewTask($task);
        }
        else{
            $taskData["id"]=$id;
            $task=new Task($taskData);
            Task::UpdateTask($task);
        }
        die();
    case "viewTask":
        $id=$data["task_id"];
        $task=Task::GetTask($id);
        ob_start();
        $enabled=$task->creator_id == $_SESSION["logged_user_id"];
        require "taskmodel.tpl";
        $array = (["html" => ob_get_contents(),'task'=>$task, 'enabled'=>$enabled]);
        ob_end_clean();
        die(json_encode($array));
    case "GetTasksForTime":
        $time=$data["time"];
        $id = $_SESSION["logged_user_id"];
        $tasks = Task::GetTasks($id,0,$time);
        $array = (["html" => Task::GetTasksHtml($tasks)]);
        die(json_encode($array));
    default:
        die("unknown method!");

}
?>
