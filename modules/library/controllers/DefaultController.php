<?php

namespace app\modules\library\controllers;

use app\modules\library\models\Author;
use yii\web\Controller;

/**
 * Default controller for the `library` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionReport()
    {
        $year = $this->request->queryParams['year'] ?? date('Y');
        $authors = Author::find()->active()->top($year)->all();

        return $this->render('report', [
            'authors' => $authors,
            'year'   => $year,
        ]);
    }
}
