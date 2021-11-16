<table id="filesTable">
    <tr>
        <th>#</th>
        <th>Название</th>
        <th>Путь</th>
        <th>Изменен</th>
        <th>Загружен</th>
        <th>Дейстиве</th>
    </tr>
<?php
foreach ($files as $file): ?>
    <tr>
        <td><?=$file['id']?></td>
        <td><?=$file['file_name']?></td>
        <td><?=$file['file_path']?></td>
        <td><?=$file['updated_at']?></td>
        <td><?=$file['created_at']?></td>
        <td><button>Удалить</button></td>
    </tr>
<?php endforeach;?>
</table>
