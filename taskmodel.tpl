<div id="newTask" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    Новая задача
                </h3>
                <a href="#close" id="closeBtn"  title="Close" class="close">×</a>
            </div>
            <div class="modal-body">
                <input type="hidden" id="taskID">
                <table>
                    <tr>
                        <td><p>Название задачи:</p></td>
                        <td><input id="nameText" type="text" ></td>
                    </tr>
                    <tr>
                        <td><p>Описание задачи:</p></td>
                        <td><textarea id="descrText" rows="5" cols="30"></textarea></td>
                    </tr>
                    <tr>
                        <td><p>Дата окончания задачи:</p></td>
                        <td><input id="dateText" type="date"></td>
                    </tr>
                    <tr>
                        <td><p>Исполняющий:</p></td>
                        <td>
                            <select id="executerCombo">
                                <?php
                                    foreach ($team as $item) {
                                        echo "<option value='{$item->id}'>{$item->surname} </option>";
                                }
                                ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td><p>Приоритет задачи:</p></td>
                        <td>
                            <select id="priorityCombo">
                                <?php
                                    foreach ($priority as $item) {
                                        echo "<option value='{$item->id}'>{$item->name} </option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><p>Статус задачи:</p></td>
                        <td>
                            <select id="statusCombo">
                                <?php
                                    foreach ($status as $item) {
                                        echo "<option value='{$item->id}'>{$item->name} </option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button id="addBtn" type="button">Добавить</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

