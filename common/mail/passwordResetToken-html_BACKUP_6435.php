<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

<<<<<<< HEAD
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
=======
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/default/reset-password', 'token' => $user->password_reset_token]);
>>>>>>> df0d65bde0cdb4d13f40d3d089d98ab7f67368bf
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
