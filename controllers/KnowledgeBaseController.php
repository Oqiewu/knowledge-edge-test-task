<?php

namespace app\controllers;

use yii\web\Controller;

class KnowledgeBaseController extends Controller
{
    public $layout = false;

    public function actionIndex()
    {
        $data = [
            1 => [
                1 => 'Некий текст для Подтемы 1.1',
                2 => 'Некий текст для Подтемы 1.2',
                3 => 'Некий текст для Подтемы 1.3',
            ],
            2 => [
                1 => 'Некий текст для Подтемы 2.1',
                2 => 'Некий текст для Подтемы 2.2',
                3 => 'Некий текст для Подтемы 2.3',
            ]
        ];
    
        // Значения по умолчанию
        $theme = 1;
        $subTheme = 1;
        $content = $data[$theme][$subTheme] ?? '';
    
        return $this->render('index', [
            'data' => $data,
            'theme' => $theme,
            'subTheme' => $subTheme,
            'content' => $content,
        ]);
    }

}
