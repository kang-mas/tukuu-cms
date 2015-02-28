<?php
namespace common\models;

use common\models\ValueHelpers;
use yii;
use yii\web\Controller;
use yii\helpers\Url;

Class PermissionHelpers
{
  public static function userMustBEOwner($model_name, $model_id)
  {
    $connection= \Yii::$app->db;
    $userid=Yii::$app->user->identity->id;
    $sql="SELECT id FROM $model_name WHERE user_id=:user_id and id=:model_id";
    $commandl=$connection->createCommand($sql);
    $command->bindValue(":user_id",$user_id);
    $command->bindValue(":model_id",$model_id);
    if ($result=$command->queryOne())
      {
	return true;
      }else
      {
	return false;
      }
  }
  
  public static function requireUpgradeTo($user_type_name)
  {
      if (\Yii::$app->user->identity->user_type_id!=
      ValueHelpers::getUserTypeValue($user_type_name))
      {
        return \Yii::$app->getResponse()->redirect(Url::to(['upgrade/index']));
      }
  }
  
  public  static function requireStatus($status_name)
  {
      if (\Yii::$app->user->identity->status_id==
      ValueHelpers::getStatusValue($status_name))
      {
          return true;
      } else {
          return false;
      }
  }
  
  public static function requireMinimumStatus($tatus_name)
  {
      if(\Yii::$app->user->identity->status_id >=
      ValueHelpers::getStatusValue($status_name))
      {
          return true;
      }  else {
          return false;
      }
  }
  public static function requireRole($role_name)
  {
      if (\Yii::$app->user->identity->role_id ==
      ValueHelpers::getRoleValue($role_name))
      {
          return true;
          
      } else {
          return false;
      }
  }
  
  public static function requireMinimumRule($role_name)
  {
      if(\Yii::$app->user->identity->role_id >=
        ValueHelpers::getRoleValue($role_name))
      {
        return true;
      }else{
          return false;
      }
          
  }

}