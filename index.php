<?
include 'handler_five.php';

        // phpinfo();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css\main.css">
    <title>Практическое задание 1</title>
</head>
<body>
<div class="form formOne">
        <h3 class="formOne-title">Первая форма</h3>
        <h5 class="description">Создай все сущности</h5>
    <form action="handler_one.php" method="post" class="form-main">
        <div class="form_value">
        <input type ="text" name = "counter" placeholder="Введите кол-во сущностей">
        <input type="submit" value="Отправить">
        </div>
    </form>
</div>
<div class="form formTwo">
        <h3 class="formTwo-title">Вторая форма</h3>
        <h5 class="description">Установи значениев текстовое поле в элемент сущности</h5>
        <form action="handler_two.php" method="post" class="form-main">
        <div class="form_value">
        <p class="form_title">Выберите сущность</p>
        <select name="essence" required size ="4" value="">
        <option value="1">Контакты</option>
        <option value="3">Компании</option>
        <option value="12">Покупатели</option>
        <option value="2">Сделки</option>
        </select>
        <input type="text" name="idValue" placeholder="Введите id выбранной сущности">
        <textarea name="field_value" id="" cols="20" rows="5"></textarea>
        <input type="submit" value="Отправить">
        </div>
        </form>
</div>
<div class="form formThree">
        <h3 class="formTwo-title">Третья форма</h3>
        <h5 class="description">Добавить примечание к сущности</h5>
        <form action="handler_three.php" method="post" class="form-main">
        <div class="form_value">
        <p class="form_title">Выберите сущность</p>
        <select name="essence" required size ="4" value="">
        <option value="1">Контакты</option>
        <option value="3">Компании</option>
        <option value="12">Покупатели</option>
        <option value="2">Сделки</option>
        </select>
        <input type="text" name="idValue" placeholder="Введите id выбранной сущности">
        <div class="form_value-radio">
        <input type="radio" name="radio_essence" value="4" id="id_ess[1]"><label for="id_ess[2]">Обычноое примечание</label>
        <input type="radio" name="radio_essence" value="10" id="id_ess[1]"><label for="id_ess[2]">Входящий звонок</label>
        </div>
        <br>
        <textarea name="notice" cols="30" rows="5"></textarea>
        <input type="submit" value="Отправить">
        </div>
            </form>
</div>
        <div class="form formFour">
        <h3 class="formTwo-title">Четвертая форма</h3>
        <h5 class="description">Добавить задачу к сущности</h5>
        <form action="handler_four.php" method="post" class="form-main">
        <p class="form_title">Выберите сущность</p>
        <select name="essence" required size ="4" value="">
        <option value="1">Контакты</option>
        <option value="3">Компании</option>
        <option value="12">Покупатели</option>
        <option value="2">Сделки</option>
        </select>
        <input type="text" name="idValue" placeholder="Введите id выбранной сущности">
        <select name="typeTask" id="">
        <option value="1">Звонок</option>
        <option value="2">Встреча</option>
        <option value="3">Письмо</option>
        <option value="1080607">Тест</option>
        </select>
        <input type="text" name="idResponsible" placeholder="Введите id отвественного пользователя">
        <textarea name="task" cols="30" rows="5"></textarea>
        <input type="date" name="term">
        <input type="submit" value="Отправить">
    </form>
</div>
    <div class="form formFive">
        <h3 class="formTwo-title">Пятая форма</h3>
        <h5 class="description">Завершить задачу</h5>
        <form action="handler_five.php" method="post">
        <select name="task" id="">
        <!-- генерим нужное колличество задач -->
        <?
        $generate = new api();
        // $generate = new form_five();
        $generate->tack_list();
        foreach ($generate->_task as $value) {
            if ($value["text"] == "Завершено") {
        // die();
            } else {
                echo "<option value=\"{$value["id"]}\">{$value["text"]}</option>";
            }
        }
        ?>
        </select>
        <input type="submit" value="Завершить">
    </form>
    </div>
    <script src="js/ajax.js"></script>
</body>
</html>
