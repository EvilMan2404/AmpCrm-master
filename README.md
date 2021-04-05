<h1>Оглавление</h1>    
<ul>
<li>
    <a href="#ParseDatabase">Парсинг csv файлов</a>
</li>
</ul>
<!-- Parse CSV FILE -->
<h3 id="ParseDatabase">Парсинг csv файлов</h3>
<p>
Чтобы спарсить файл :
</p>
<ul>
<li>Идем в app/Console/Commands/ParseDatabase.php</li>
<li>В 'images_path' - выставляем путь к картинкам </li>
<li>В 'report' - путь и название файла в который будем грузить отчет (по соответствию) (создастся сам в случае отсутсвия) </li>
<li>В 'reportUnUsed' - путь и название файла в который будем грузить отчет (по картинками неиспользованным) (создастся сам в случае отсутсвия) </li>
<li>В 'pathToParseFile' - путь к файлу из которого будем парсить все строки </li>
<li>После настройки этих данных - идем в консоль и вводим <b>php artisan parseDatabase</b> </li>
<li>В указанных местах смотрим отчеты в формате csv</li>
</ul>

<!-- End Parse CSV FILE -->

###### **Commands**
`
php artisan storage:link --relative`
