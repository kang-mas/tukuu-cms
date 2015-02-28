<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

//$this->title = $model->id;
$this->title = $model->user->user_name ."'s Profile";
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
  <?php
  if (PermissionHelpers::userMustBeOwner('profile', $model->id){
      echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) 
	}

  ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			 //'id',
			 //'user_id',
	    'user.username',
            'first_name:ntext',
            'last_name:ntext',
            'birthdate',
            'gender.gender_name',
	    'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
