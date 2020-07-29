<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use appanggaran\models\BagianModels;
use common\models\OfficeOrUnit;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Signup */

$this->title = Yii::t('rbac-admin', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
// Get Data Bagian
$modbagian = BagianModels::find()->select(['IDBAGIAN', new \yii\db\Expression("NAMABAGIAN")])->all();
$bidang = ArrayHelper::map($modbagian, 'IDBAGIAN', 'NAMABAGIAN');
// Get Data Cabang
$modcabang = OfficeOrUnit::find()->select(['unit_id', new \yii\db\Expression("name")])->where(['parent_id' => 0])->all();
$cabang = ArrayHelper::map($modcabang, 'unit_id', 'name');
// Get Data Unit Kerja
$modunit_kerja = OfficeOrUnit::find()->select(['unit_id', new \yii\db\Expression("name")])->where(['parent_id' => 1])->all();
$unit_kerja = ArrayHelper::map($modunit_kerja, 'unit_id', 'name');
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Silahkan Memasukan Data User Baru:</p>
    <?= Html::errorSummary($model) ?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'nama') ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'id_cabang')->widget(Select2::classname(), [
                'data' => $cabang,
                'language' => 'en',
                'options' => ['id' => 'parent_id', 'placeholder' => 'Pilih Cabang ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Cabang');
            ?>
            <?= $form->field($model, 'id_bagian')->widget(Select2::classname(), [
                'data' => $unit_kerja,
                'language' => 'en',
                'options' => ['id' => 'unit_id', 'placeholder' => 'Pilih Unit Kerja ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Unit Kerja');
            ?>
            <?= $form->field($model, 'id_bidang')->widget(Select2::classname(), [
                'data' => $bidang,
                'language' => 'en',
                'options' => ['id' => 'id_bidang', 'placeholder' => 'Pilih Unit Kerja ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Bagian');
            ?>
           
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'retypePassword')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('rbac-admin', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>