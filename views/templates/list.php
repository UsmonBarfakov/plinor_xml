<table id="filesTable">
    <tr>
        <th onclick="sortTable(0)">#</th>
        <th onclick="sortTable(1)">Название</th>
        <th onclick="sortTable(2)">Путь</th>
        <th onclick="sortTable(3)">Изменен</th>
        <th onclick="sortTable(4)">Загружен</th>
        <th>Дейстиве</th>
    </tr>
<?php
$i=1;
if (isset($files)) :

foreach ($files as $file): ?>
    <tr>
        <td><?=$file['id']?></td>
        <td><?=$file['file_name']?></td>
        <td><?=$file['file_path']?></td>
        <td><?=$file['updated_at']?></td>
        <td><?=$file['created_at']?></td>
        <td>
            <button onclick="deleteFile(<?=$file['id']?>, <?=$i?>)">Удалить</button>
        </td>
    </tr>
<?php
    $i++;
    endforeach;
endif;?>
</table>
