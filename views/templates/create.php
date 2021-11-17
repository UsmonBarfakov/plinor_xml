    <div class="uploader">
        <form enctype="multipart/form-data" action="<?=BASE_URL?>index.php/upload" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            Отправить этот файл: <input name="file" type="file" />
            <input name="submit" type="submit" value="Отправить файл" />
        </form>
    </div>
