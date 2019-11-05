<?php
namespace frontend\controllers;

use Yii;
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
		if(Yii::$app->user->isGuest){
			return $this->redirect(['/user/default/login']);
		}
		
		$currentUser = Yii::$app->user->identity;
		$limit = Yii::$app->params['feedPostLimit'];
		$limit_on_page = Yii::$app->params['feedPostLimitOnPage'];
		$feedItems = $currentUser->getFeed($limit);
		
		$pages = new Pagination(['totalCount' => $limit_on_page]);
        return $this->render('index',[
			'feedItems' => $feedItems,
			'currentUser' => $currentUser,
			'pages' => $pages,
        ]);
    }
    
     public function actionAbout()
    {
        return $this->render('about');
    }
}
