<?php
use yii\helpers\Html;
use yii\helpers\Json;

$theme = intval($theme);
$subTheme = intval($subTheme);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Base</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            border: 1px solid black;
            padding: 10px;
            vertical-align: top;
        }
        .selected {
            background-color: yellow;
        }
        #menu, #list {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td id="menu">
                <?php foreach ($data as $themeId => $subThemes): ?>
                    <div onclick="selectTheme(<?= Html::encode($themeId) ?>)" data-theme="<?= Html::encode($themeId) ?>" <?= $themeId == $theme ? 'class="selected"' : '' ?>>
                        Тема <?= Html::encode($themeId) ?>
                    </div>
                <?php endforeach; ?>
            </td>
            <td id="list">
                <?php if (isset($data[$theme])): ?>
                    <?php foreach ($data[$theme] as $subThemeId => $subContent): ?>
                        <div onclick="selectSubTheme(<?= Html::encode($subThemeId) ?>)" data-sub-theme="<?= Html::encode($subThemeId) ?>" <?= $subThemeId == $subTheme ? 'class="selected"' : '' ?>>
                            Подтема <?= Html::encode($theme) ?>.<?= Html::encode($subThemeId) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Нет подтем для выбранной темы.</p>
                <?php endif; ?>
            </td>
            <td id="content">
                <?= Html::encode($content) ?>
            </td>
        </tr>
    </table>

    <script>
        // Преобразуем PHP-данные в JavaScript-объект
        const content = <?= Json::encode($data) ?>;

        function selectTheme(theme) {
            // Убираем выделение с предыдущих элементов
            document.querySelectorAll('#menu div').forEach(div => div.classList.remove('selected'));
            document.querySelectorAll('#list div').forEach(div => div.classList.remove('selected'));

            // Добавляем выделение для выбранной темы
            document.querySelector(`#menu div[data-theme="${theme}"]`)?.classList.add('selected');

            const list = document.getElementById('list');
            if (content[theme]) {
                // Обновляем список подтем
                list.innerHTML = Object.keys(content[theme]).map(subThemeId =>
                    `<div onclick="selectSubTheme(${subThemeId})" data-sub-theme="${subThemeId}" ${subThemeId == 1 ? 'class="selected"' : ''}>
                        Подтема ${theme}.${subThemeId}
                    </div>`
                ).join('');
                
                // Обновляем содержимое
                const firstSubThemeId = Object.keys(content[theme])[0] || 1;
                document.getElementById('content').textContent = content[theme][firstSubThemeId] || '';
            } else {
                list.innerHTML = '<p>Нет подтем для выбранной темы.</p>';
                document.getElementById('content').textContent = '';
            }
        }

        function selectSubTheme(subTheme) {
            document.querySelectorAll('#list div').forEach(div => div.classList.remove('selected'));

            // Добавляем выделение для выбранной подтемы
            document.querySelector(`#list div[data-sub-theme="${subTheme}"]`)?.classList.add('selected');

            const selectedThemeDiv = document.querySelector('#menu div.selected');
            const selectedTheme = selectedThemeDiv ?
                parseInt(selectedThemeDiv.getAttribute('data-theme')) : 1;

            // Обновляем содержимое
            document.getElementById('content').textContent = content[selectedTheme] ? content[selectedTheme][subTheme] || '' : '';
        }

        // Инициализация с начальным состоянием
        selectTheme(<?= Html::encode($theme) ?>);
    </script>
</body>
</html>
