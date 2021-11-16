    <div class="uploader">
        <!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
        <form enctype="multipart/form-data" action="index.php/upload" method="POST">
            <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <!-- Название элемента input определяет имя в массиве $_FILES -->
            Отправить этот файл: <input name="file" type="file" />
            <input name="submit" type="submit" value="Отправить файл" />
        </form>
    </div>
