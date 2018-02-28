<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\utilities\DataHelper;
use yii\helpers\Url;
use app\models\AccountChart;
use yii\widgets\Pjax;
use app\models\AccountEntries;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountChartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Account Charts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-chart-index admin-content">

    
	 <ul class=" nav nav-pills nav-stacked">
             <?php //  echo AccountEntries::showButtons();?>
         </ul>
        <h1><?= Html::encode($this->title) ?></h1>
    <p>
         <?php 
		  $dh = new DataHelper();
		  $url = Url::to(['account-chart/create']);  //'site/update-data'
		   echo $dh->getModalButton(new AccountChart, 'account-chart/create', 'AccountChart', 'btn btn-danger btn-create btn-new pull-right','New',$url);
		   
         ?>
    </p>
	<?php Pjax::begin(['id'=>'pjax-account-chart',]); ?> 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            'name',
           
			[
			 'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'attribute' => 'fk_re_account_type',
                  
                    'header'=>'Account Type',
                    'format' => 'raw',
                    'value'=>function ($data) {
                               return isset($data->fkReAccountType->name)?$data->fkReAccountType->name:"";
                            },
			],
            
			[
			'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                        'attribute' => 'status',
                        'filter' => app\models\Lookup::getLookupValues('Status'),
                        'value' => function ($data) {
                            $category_id = \app\models\LookupCategory::getLookupCategoryID('Status');
                            return app\models\Lookup::getLookupCategoryValue($category_id, $data->status);
                        },
			],
            // 'description:ntext',
            // 'created_by',
            // 'modified_by',
            // 'created_on',
            // 'modified_on',

                               ['class' => 'yii\grid\ActionColumn',
                     'template' => '{view} {update}',
                     'buttons' => [
									'view' => function ($url, $model){
                                             $dh = new DataHelper();
                                             $url = Url::to(['account-chart/view', 'id'=>$model->id]);
                                              $popup = $dh->getModalButton($model, "account-chart/view", "AccountChart", 'glyphicon glyphicon-eye-open','',$url);
                                              return $popup;
									},
											  
                                    'update' => function ($url, $model) {
                                            $dh = new DataHelper();
                                            $url = Url::to(['account-chart/update','id'=>$model->id]);
                                           return $dh->getModalButton($model, "account-chart/update", "AccountChart", 'glyphicon glyphicon-edit','',$url);
                                            },
                            ], 
                    ],
        ],
    ]); ?>
	<?php Pjax::end(); ?>
</div>