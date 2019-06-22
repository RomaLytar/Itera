<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Itera</title>
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<?php
$arrValue = array(
    array(
        'text' => "Текст красного цвета",
        'cells' => '1,2,4,5',
        'align' => 'center',
        'valign' => 'center',
        'color' => '#FF0000',
        'bgcolor' => '#0000FF'
    ),
    array(
        'text' => "Текст зеленого цвета",
        'cells' => '8,9',
        'align' => 'right',
        'valign' => 'bottom',
        'color' => '#00FF00',
        'bgcolor' => '#FFFFFF'
    ),
);
function Itera(array $arrValue){
//Создание массива $arrValue с ключами cells и сортирую по возростанию
for ($i = 0; $i < count($arrValue); $i++) {
    $delimiter = ',';
    $arrValueCells[] = explode($delimiter, $arrValue[$i]['cells']);
    sort($arrValueCells[$i]);
}
$size = 3; // Размер Таблицы = $size*$size.

static $k = 1;
//Под каждый элементо создаем свой массив
$colspan = array();
$rowspan = array();
$width = array();
$height = array();
$class = array();
$color = array();
$bgcolor = array();
$text = array();
//Заполняю тадлицу данными подефолту
for ($i = 1; $i <= $size * $size; $i++) {
    $width[] = '100';
    $height[] = '100';
    $colspan[] = '1';
    $rowspan[] = '1';
    $text[] = $i;
}
//Цыкл построения таблицы

for ($i = 0; $i < count($arrValueCells); $i++) {
    //запоминая для каждой группы ячеек нужные данные
    $color[$arrValueCells[$i][0] - 1] = $arrValue[$i]['color'];
    $bgcolor[$arrValueCells[$i][0] - 1] = $arrValue[$i]['bgcolor'];
    $text[$arrValueCells[$i][0] - 1] = $arrValue[$i]['text'];
    $align[$arrValueCells[$i][0] - 1] = $arrValue[$i]['align'];
    $valign[$arrValueCells[$i][0] - 1] = $arrValue[$i]['valign'];

    $count = count($arrValueCells[$i]); //кол-во ячеек

    $row = 1;
    for ($s = $count - 2, $j = 1; $j < $count, $s >= 0; $j++, $s--) {
        $class[$arrValueCells[$i][$j] - 1] = 'hidden';// для ненужных ячеек присваиваю класс
        //Устанавливаю число ячеек которые должны быть объединены по вертикали
        if (($arrValueCells[$i][$count - $j] - $arrValueCells[$i][$s]) != 1) {
            $row++;
        }
    }
    $col = $count / $row;//Устанавливаю число ячеек которые должны быть объединены по горизонтали
    $colspan[$arrValueCells[$i][0] - 1] = $col;
    $rowspan[$arrValueCells[$i][0] - 1] = $row;
    // Проверка если номера ячеек идут подряд
    for ($l = 1; $l < $count; $l++) {
        if ((max($arrValueCells[$i]) - min($arrValueCells[$i])) == $l * $size - 1) {
            $rowspan[$arrValueCells[$i][0] - 1] = $count / $size;
            $colspan[$arrValueCells[$i][0] - 1] = $size;
        }
    }
}
?>

<!--Вывод таблици-->
<div class="container-fluid">
    <div class=" row">
        <div class="col-lg-<?php echo $size ?>">
            <table class="table table-bordered">
                <?php for ($i = 0; $i < $size; $i++) {
                    ?>
                    <tr>
                        <?php for ($j = 0; $j < $size; $j++, $k++) { ?>
                            <td colspan="<?php echo $colspan[$k - 1] ?>"
                                rowspan="<?php echo $rowspan[$k - 1] ?>"
                                class="<?php echo $class[$k - 1] ?>"
                                style="
                                        width: <?php echo $colspan[$k - 1] * $width[$k - 1] . 'px'; ?>;
                                        height: <?php echo $rowspan[$k - 1] * $height[$k - 1] . 'px'; ?>;
                                        background: <?php echo $bgcolor[$k - 1] ?>;
                                        color: <?php echo $color[$k - 1] ?>;
                                        text-align: <?php echo $align[$k - 1] ?>;
                                        vertical-align: <?php echo $valign[$k - 1] ?>;
                                        ">
                                <?php echo $text[$k - 1]; ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<?php } ?><!--завершение тела функции Itera-->
<?php Itera($arrValue); ?><!-- Вызов функции Itera($arrValue)-->
<a href="http://certifications.ru/resume/217016/"><img src="http://certifications.ru/static/images/banner/86ru.png" border=0></a>
</body>
</html>

