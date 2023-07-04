<?php
use yii\bootstrap5\Modal;
use \app\models\Revisao;
$modelRevisao = new Revisao();

$count_revisoes = Revisao::find()->where([
    'produto_id' => $id
])->count();

// Modal::begin([
//     'title' => 'Gerenciar Revisões',
//     'toggleButton' => [
//         'label' => '📋 ('.($count_revisoes).')',
//         'class' => 'btn btn-primary'
//     ],
//     'size' => $count_revisoes > 0 ? 'modal-xl' : 'modal-md',
//     'options' => [
//         'id' => 'produto-cadastrar-revisao-'.$id,
//         'tabindex' => false,
//     ],
// ]);
?>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Revisao $modelRevisao */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row revisao-form text-left">
    <div class="col">
        <h4>Nova Revisão</h4>
        <div class="card">
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'action' => Yii::$app->homeUrl.'produto/revisao'
                ]); ?>
                <?= $form->field($modelRevisao, 'produto_id')->hiddenInput(['value' => $id])->label(false) ?>
                <?= $form->field($modelRevisao, 'titulo')->textInput(['maxlength' => true, 'value'=>'Revisão '.($count_revisoes + 1)]) ?>
                <?= $form->field($modelRevisao, 'data')->textInput() ?>
                <?= $form->field($modelRevisao, 'tempo_ultima_etapa')->textInput() ?>
                <?= $form->field($modelRevisao, 'responsavel')->textInput(['maxlength' => true]) ?>
                <?= $form->field($modelRevisao, 'status')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Salvar nova Revisão', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <?php if($count_revisoes > 0) : ?>
        <div class="col-8 text-center">
            <h4>Editar Revisões</h4>
            <div class="card text-center">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php
                        $reviews = Revisao::find()->where([
                            'produto_id' => $id
                        ])->all();
                        $corpo = '<div class="tab-content" id="myTabContent">';
                        $i = 1;
                        foreach ($reviews as $r):
                            echo '
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link '.($i == 1 ? 'active':'').'" id="home-tab" data-bs-toggle="tab" data-bs-target="#item-r-'.$r->id.'" type="button" role="tab" aria-controls="home" aria-selected="true">'.$r->titulo.'</button>
                                </li>';
                            $modelRevisao = Revisao::findOne([
                                'id' => $r->id
                            ]);
                            $formulario = $this->render('_editreview', [
                                'modelRevisao' => $modelRevisao,
                                'id' => $r->id,
                                'produto_id' => $id
                            ]);
                            $corpo .= '<div class="tab-pane fade '.($i == 1 ? 'show active':'').' text-left" id="item-r-'.$r->id.'" role="tabpanel" aria-labelledby="home-tab">
                                '.$formulario.'
                            </div>';
                            $i++;
                        endforeach;
                        $corpo .= '</div>';
                    ?>
                </ul>
                <?=$corpo?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php //Modal::end(); ?>
