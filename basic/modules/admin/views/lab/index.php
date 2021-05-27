<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Upload', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'caption',
	    [
		'format' => 'html',
		'label' => 'Image',
		'value' => function($data){
		    return Html::img($data->getImage(), ['width'=>200]);
		}
	    ], 
            //['class' => 'yii\grid\ActionColumn'],
	    ['class' => 'yii\grid\ActionColumn',
 		'template' => '{update}&nbsp;&nbsp;&nbsp;{view}'
	    ],
        ],
    ]); ?>

</div>
