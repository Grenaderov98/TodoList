<?php

class Task
{
    public $id;
    public $name;
    public $description;
    public $date_end;
    public $date_create;
    public $date_update;
    public $priority_id;
    public $priority;
    public $status;
    public $status_id;
    public $creator;
    public $creator_id;
    public $execurer_id;
    public $executer;

    function __construct($task)
    {
        $this->id = $task["id"];
        $this->name = $task["taskname"];
        $this->description = $task["description"];
        $this->date_create = $task["date_create"];
        $this->date_end = $task["date_end"];
        $this->date_update = $task["date_update"];
        $this->priority = $task["pname"];
        $this->priority_id = $task["pId"];
        $this->status = $task["sname"];
        $this->status_id = $task["sId"];
        $this->executer = $task["surname"];
        $this->execurer_id = $task["executer_id"];
        $this->creator_id = $task["creator_id"];
    }


    public static function UpdateTask($task)
    {
        R::exec('Update tasks set name = ?, description = ?, date_end=?, date_update=?, executer_id=?, priority_id=?, status_id = ?
                        WHERE id=?',
            [$task->name, $task->description, $task->date_end, date('Y-m-d'), $task->execurer_id, $task->priority_id, $task->status_id, $task->id]);
    }

    public static function GetTasks($executer_id, $task_id, $time)
    {
        $sql = "SELECT tasks.id, tasks.name as taskname,tasks.description,tasks.date_create,tasks.date_update,tasks.date_end,priority.name as pname,priority_id as pId,status.id as sId,
    users.surname,status.name as sname, tasks.creator_id 
    FROM tasks 
    JOIN priority on priority.id=tasks.priority_id
    JOIN status on status.id=tasks.status_id 
    JOIN users on users.id=tasks.executer_id
    WHERE 1=1";
        $params = [];
        if (!empty($executer_id)) {
            $sql .= " and tasks.executer_id = ?";
            $params[] = $executer_id;
        }
        if (!empty($task_id)) {
            $sql .= " and tasks.id = ?";
            $params[] = $task_id;

        }
        switch ($time) {
            case "today":
                $sql .= " and tasks.date_end <= now()";
                break;
            case "week":
                $sql .= ' and tasks.date_end BETWEEN DATE_ADD(now(), INTERVAL 1 day) AND DATE_ADD (now(), INTERVAL 1 week)';
                break;
            case "future":
                $sql .= ' and tasks.date_end > DATE_ADD(now(), INTERVAL 1 week)';
                break;

        }
        $tasksQuery = R::getAll($sql, $params);
        //var_dump($tasksQuery);
        $tasks = [];
        foreach ($tasksQuery as $task) {
            $tasks[] = new Task($task);
        }

        return $tasks;

    }

    public static function GetTask($id)
    {
        $task = current(Task::GetTasks(0, $id));
        return $task;
    }

    public static function DeleteTask($id)
    {
        R::exec('DELETE FROM `tasks` WHERE `id` = ?', array(
            $id
        ));
    }

    /**
     * @param Task $task
     */
    public static function AddNewTask($task)
    {
        R::exec('insert into tasks (name, description, date_end, date_create, priority_id, status_id,creator_id,executer_id) 
                    values (?,?,?,?,?,?,?,?)',
            array($task->name, $task->description, $task->date_end, $task->date_create, $task->priority_id, $task->status_id, $task->creator_id, $task->execurer_id));
    }

    public static function GetTasksHtml($tasks)
    {
        $result = "";
        $result .= '<ul class="tilesWrap">';
        foreach ($tasks as $task) {
            $result .= '<li class="taskLI" id ="' . $task->id . '">';
            if ($task->status == "Выполнено") {
                $result .= '<div class="green">';
            } else if (($task->status == "К выполнению" || $task->status == "Выполняется" ||
                    $task->status == "Отменено") && date("y.m.d") > date('y.m.d', strtotime($task->date_end))) {
                $result .= '<div class="red">';
            } else {
                $result .= '<div class="gray">';
            }
            $result .= '<h2>' . $task->name . '</h2>';
            $result .= '</div>';
            $result .= '<h3>Приоритет: ' . $task->priority . '</h3>';
            $result .= '<h3>Статус: ' . $task->status . '</h3>';
            $result .= '<h3>Исполнитель: ' . $task->executer . '</h3>';
            $result .= '<p>' . $task->description . '</p>';
            $result .= '<p>Дата завершения: ' . $task->date_end . '</p>';
            $result .= '</li>';
        }
        $result .= '</ul>';
        return $result;
    }
}
