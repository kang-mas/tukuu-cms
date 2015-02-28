<?php

namespace frontend\models;

use Yii;

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthdate
 * @property integer $gender_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Gender $gender
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gender_id'], 'required'],
            [['user_id', 'gender_id'], 'integer'],
            [['first_name', 'last_name'], 'string'],
            [['birthdate', 'created_at', 'updated_at'], 'safe'],
            [['birthdate'],'date','format'=>'Y-m-d'],
            [['gender_id'],'in','range'=>  array_keys($this->getGenderList())]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'birthdate' => 'Birthdate',
            'gender_id' => 'Gender ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'genderName'=>  Yii::t('app', 'Gender'),
            'userLink'=> Yii::t('app', 'User'),
            'profileIdLink'=> \Yii::t('app', 'Profile'),
        ];
    }
    
    public function behaviors()
    {
        return [
            'timestamp'=>[
                'class'=> 'yii\behaviors\TimestampBehavior',
                'attributes'=>[
                    ActiveRecord::EVENT_AFTER_INSERT =>['created_at','update_at'],
                    ActiveRecord::EVENT_AFTER_UPDATE=>['update_at'],
                ],
                'value'=>  new Expression('NOW'),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }
    
    public function getGenderName()
    {
        return $this->gender ? $this->gender->gender_name : '- no gender -';
    }
/**
 * 
 *  get list gender for dropdown
 */

    public function getGenderList()
    {
        $droptions=  Gender::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'gender_name');
    }
    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }
    
/**
 * 
 * @get Username
 */
    public function getUserName()
    {
        return $this->user->username;
    }
    
    /**
     * @getUserId
     */
    public function getUserId()
    {
        return $this->user? $this->user->id : 'none';
    }
    
    /**
     * @getUserLink
     */
    public function getUserLink()
    {
        $url=  Url::to(['user/view','id'=>$this->getUserId()]);
        $options=[];
        return Html::a($this->getUserName(), $url, $options);
    }
    
    public function getProfileIdLink()
    {
        $url=  Url::to(['profile/update','id'=>$this->id]);
        $options=[];
        return Html::a($this->id,$url, $options);
    }
}

