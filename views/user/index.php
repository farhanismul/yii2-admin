<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use mdm\admin\components\Helper;
use common\models\OfficeOrUnit;
use appanggaran\models\BagianModels;
use appgudang\models\masterData\KelompokPetugas;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create User'), ['signup'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nama',
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'id_cabang',
                'value'=>function($model){
                        $modUnit = OfficeOrUnit::find()->where(['unit_id'=>$model->id_cabang])->one();
                        return $modUnit->name;
                },
                'filter' => ArrayHelper::map(OfficeOrUnit::find()->asArray()->all(), 'unit_id', 'name'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['prompt' => 'Filter Unit Kerja..'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width'=>'100%'
                    ],
                ]
              
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'id_kelompok',
                'label'=>'Kelompok',
                'value'=>function($model){
                    $modUnit = KelompokPetugas::find()->where(['id'=>$model->id_kelompok])->one();
                    return $modUnit->nama;
                }
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'id_bagian',
                'label'=>'Unit Kerja',
                'value'=>function($model){
                    $modUnit = BagianModels::find()->where(['IDBAGIAN'=>$model->id_bagian])->one();
                    return $modUnit->NAMABAGIAN;
                }
            ],
            'username',
            // 'email:email',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 0 ? 'Inactive' : 'Active';
                },
                'filter' => [
                    0 => 'Inactive',
                    10 => 'Active'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                // 'template' => Helper::filterActionColumn(['view', 'activates', 'delete']),
                'template' => '{tombolAktiv}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'tombolAktiv') {
                        return Url::toRoute(['user/activate', 'id' => $model['id']]);
                    }
                },
                'buttons' => [
                    'tombolAktiv' => function($url, $model) {
                        if ($model->status == 10) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('rbac-admin', 'Activate'),
                            'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            // 'data-method' => 'post',
                            // 'data-pjax' => '0',
                            'data' => [
                                'confirm' => 'Anda yakin ingin mengaktivasi user ini?',
                                'method' => 'post',
                            ],
                        ];
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                    }
                    ]
                ],
            ],
        ]);
        ?>
</div>
