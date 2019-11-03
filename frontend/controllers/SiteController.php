<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\User;
use yii\data\Pagination;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$query = User::find();
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$users = $query->offset($pages->offset)->limit($pages->limit)->all();		
        return $this->render('index',[
			'users' => $users,
			'pages' => $pages,
        ]);
    }
}
