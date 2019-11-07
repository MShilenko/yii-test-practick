<?php

namespace backend\models;

use Yii;
use backend\models\Feed;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $description
 * @property int $created_at
 * @property int $complaints
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    //~ public function rules()
    //~ {
        //~ return [
            //~ [['user_id', 'filename', 'created_at'], 'required'],
            //~ [['user_id', 'created_at', 'complaints'], 'integer'],
            //~ [['description'], 'string'],
            //~ [['filename'], 'string', 'max' => 255],
        //~ ];
    //~ }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
            'complaints' => 'Complaints',
        ];
    }
    public static function findComplaints()
    {
        return Post::find()->where('complaints > 0')->orderBy('complaints DESC');
    }
    
    public function getImage(){
		return Yii::$app->storage->getFile($this->filename);
	}
    
    public function approve(){
		/* @var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->id}:complaints";
        $redis->del($key);
        
        $this->complaints = 0;
        return $this->save(false, ['complaints']);
	}
    
    public function deletePost(){
		$redis = Yii::$app->redis;
        $key = "post:{$this->id}:complaints";
        $key2 = "post:{$this->id}:likes";
        $redis->del($key, $key2);
		
		Feed::deleteAll('post_id = ' . $this->id);
		$this->delete();
		return Yii::$app->session->setFlash('success', 'Post delete successful');
	}
    
    
}
