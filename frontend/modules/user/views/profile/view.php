<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */
/* @var $modelPicture frontend\modules\user\models\forms\PictureForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;
?>

<h3><?php echo Html::encode($user->username); ?></h3>
<p><?php echo HtmlPurifier::process($user->about); ?></p>

<img src="<?=$user->getPicture()?>" id="profile-picture" class="col-xs-4">

<?php if($currentUser && $currentUser->equals($user)){ ?>

	<?= FileUpload::widget([
		'model' => $modelPicture,
		'attribute' => 'picture',
		'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
		'options' => ['accept' => 'image/*'],
		'clientOptions' => [
			'maxFileSize' => 2000000
		],
		// Also, you can specify jQuery-File-Upload events
		// see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
		'clientEvents' => [
			'fileuploaddone' => 'function(e, data) {
									if (data.result.success) {
										$("#profile-image-success").show();
										$("#profile-image-fail").hide();
										$("#profile-picture").attr("src", data.result.pictureUri);
									} else {
										$("#profile-image-fail").html(data.result.errors.picture).show();
										$("#profile-image-success").hide();
									}
								}',
		],
	]); ?>

	<div class="alert alert-success d-none" id="profile-image-success">Profile image updated</div>
	<div class="alert alert-danger d-none" id="profile-image-fail"></div>

<?php }else{ ?>

	<hr>
	<?php if($currentUser){ ?>
		<?php if(!$currentUser->isFollowing($user)){ ?>
			<a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Subscribe</a>
		<?php } ?>
			<a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Unsubscribe</a>
			<hr>
	<?php } ?>

	<?php if ($currentUser && $mutualSubscriptions = $currentUser->getMutualSubscriptionsTo($user)): ?>
		<h5>Friends, who are also following <?php echo Html::encode($user->username); ?>: </h5>
		<div class="col-xs-8">
			<?php foreach ($mutualSubscriptions as $item): ?>
				<div class="col-md-12">
					<a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? $item['nickname'] : $item['id']]); ?>">
						<?php echo Html::encode($item['username']); ?>
					</a>
				</div>                
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<?php } ?>

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">
    Subscriptions: <?php echo $user->countSubscriptions(); ?>
</button>

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal2">
    Followers: <?php echo $user->countFollowers(); ?>
</button>


<!-- Modal subscriptions -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Subscriptions</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                <?php foreach ($user->getSubscriptions() as $subscription): ?>
                    <div class="col-md-12">
                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? $subscription['nickname'] : $subscription['id']]); ?>">
                            <?php echo Html::encode($subscription['username']); ?>
                        </a>
                    </div>                
                <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal subscriptions -->

<!-- Modal followers -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Followers</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                <?php foreach ($user->getFollowers() as $follower): ?>
                    <div class="col-md-12">
                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]); ?>">
                            <?php echo Html::encode($follower['username']); ?>
                        </a>
                    </div>                
                <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal followers -->
