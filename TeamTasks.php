<head>
    <meta charset="UTF-8">
    <title>Task manager</title>
    <link rel="stylesheet" href="css/myTasks.css">
    <link rel="stylesheet" href="css/TeamTasks.css">
</head>

<div class="container">
    <?php
    require "taskmodel.tpl";
    ?>
    <div id="taskmodal">

    </div>
    <table>
        <tr>
            <td>
                <select id="team">
                    <?php
                    foreach ($team as $item) {
                        echo "<option value=" . $item->id . '>' . $item->surname . ' ' . $item->name . ' ' . $item->middlename . '</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                <input type="submit" id="searchBtn" value="Просмотреть задачи" name="searchBtn">
            </td>
            <td>
                <button id="addTask"><a href="#newTask">Новая задача</a></button>
            </td>
        </tr>
    </table>
    <div id="tasks">

    </div>
</div>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script src="js/scripts.js"></script>


