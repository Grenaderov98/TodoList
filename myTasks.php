<?php
require "classes/taskClass.php";

?>
<head>
    <meta charset="UTF-8">
    <title>Task manager</title>
    <link rel="stylesheet" href="css/myTasks.css">
    <link rel="stylesheet" href="css/TeamTasks.css">
</head>
<div class="container">
    <table>
        <tr>
            <td>
                <select id="timeTask">
                    <option value="today">Сегодня</option>
                    <option value="week">Неделя</option>
                    <option value="future">На будущее</option>
                </select>
            </td>
            <td>
                <input type="submit" id="SelectTime" value="Выбрать время" name="selectTime">
            </td>
        </tr>
    </table>
    <?php
    require "taskmodel.tpl";
    ?>
    <div id="taskmodal">

    </div>
    <div id="tasks">

    </div>
</div>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script src="js/scripts.js"></script>

