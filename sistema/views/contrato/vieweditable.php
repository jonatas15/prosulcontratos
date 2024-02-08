<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
// use kartik\detail\DetailView;
use app\models\Empreendimento;
use app\models\ImpactoEmpreendimento as ImpcEmp;
use yii\web\JsExpression;
// use miloschuman\highcharts\Highcharts;
use yii\bootstrap5\Modal;
use kartik\editable\Editable;

/** @var yii\web\View $this */
/** @var app\models\Impacto $model */

\yii\web\YiiAsset::register($this);

$this->title = "Editar ". $model->numeroitem;

?>
<?php
    // Modal::begin([
    //     'title' => $model->servico,
    //     'toggleButton' => [
    //         'label' => $model->servico,
    //         'class' => 'btn btn-link'
    //     ],
    //     'size' => 'modal-xl',
    //     'options' => [
    //         'id' => 'ver-os-detalhes-impacto-'.$model->id,
    //         'tabindex' => false,
    //     ],
    //     'bodyOptions' => [
    //         'class' => 'bg-white'
    //     ]
    // ]);
?>
<div class="impacto-view">
    <div class="row my-3">
        <div class="col">
            <h4 class="text-left">Contrato: <?= $model->contrato->titulo ?>, <br><?= $model->produto ?></h4>
            <sub class="text-white badge bg-danger">Clique sobre os campos para editá-los diretamente</sub>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'numeroitem',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor'])) {
                                return $this->context->imprimecampoeditavelmente($model->id, 'numeroitem', $model->numeroitem);
                            } else {
                                return $model->numeroitem;
                            }
                        },
                    ],
                    // 'contrato.titulo',
                    [
                        'attribute' => 'produto',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor'])) {
                                return $this->context->imprimecampoeditavelmente($model->id, 'produto', $model->produto, 'area');
                            } else {
                                return $model->produto;
                            }
                        },
                    ],
                    [
                        'attribute' => 'servico',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor'])) {
                                return $this->context->imprimecampoeditavelmente($model->id, 'servico', $model->servico, 'area');
                            } else {
                                return $model->servico;
                            }
                        },
                    ],
                    // 'unidade',
                    [
                        'attribute' => 'unidade',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor'])) {
                                return $this->context->imprimecampoeditavelmente($model->id, 'unidade', $model->unidade);
                            } else {
                                return $model->unidade;
                            }
                        },
                    ],
                    [
                        'attribute' => 'quantidade_a',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor'])) {
                                return $this->context->imprimecampoeditavelmente($model->id, 'quantidade_a', $model->quantidade_a);
                            } else {
                                return $model->quantidade_a;
                            }
                        },
                    ],
                    [
                        'attribute' => 'quantidade_utilizada',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor'])) {
                                return $this->context->imprimecampoeditavelmente($model->id, 'quantidade_utilizada', $model->quantidade_utilizada);
                            } else {
                                return $model->quantidade_utilizada;
                            }
                        },
                    ],
                    [
                        'attribute' => 'qt_restante_real',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor'])) {
                                return $this->context->imprimecampoeditavelmente($model->id, 'qt_restante_real', $model->qt_restante_real);
                            } else {
                                return $model->qt_restante_real;
                            }
                        },
                    ],
                    [
                        'attribute' => 'qt_restante',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor'])) {
                                return $this->context->imprimecampoeditavelmente($model->id, 'qt_restante', $model->qt_restante);
                            } else {
                                return $model->qt_restante;
                            }
                        },
                    ],
                ]
            ]); ?>
        </div>
        <div class="col-md-4">
        <div class="row">
            <div class="col">
                <h6 class="text-left">Empreendimentos</h6>
            </div>
        </div>
            <?php
                $contentItem .= '<table class="table table-striped table-bordered detail-view">';
                foreach ($model->impactoEmpreendimentos as $ie) {
                    // if ($ie->impactos > 0) {
                        $contentItem .= '<tr>';
                        $contentItem .= "<td>{$ie->empreendimento->titulo}</td>";
                        $contentItem .= "<td>";
                        if (in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor'])) {
                            $contentItem .= Editable::widget([
                                'id' => 'alteraimpacto_'."{$ie->impacto_id}_{$ie->empreendimento_id}", 
                                'name' => 'alteraimpacto_'."{$ie->impacto_id}_{$ie->empreendimento_id}", 
                                'asPopover' => false,
                                'value' => $ie->impactos,
                                'header' => 'Impactos em '.$ie->empreendimento->titulo,
                                'size'=>'md',
                                'options' => [
                                    'class'=>'form-control', 
                                    'placeholder'=>'Impactos:',
                                ],
                                'formOptions' => [
                                    'action' => [
                                        'alteraimpacto',
                                        'impacto_id' => $ie->impacto_id,
                                        'empreendimento_id' => $ie->empreendimento_id
                                    ]
                                ]
                            ]);
                        } else {
                            $contentItem .= $ie->impactos;
                        }
                        $contentItem .= "</td>";
                        $contentItem .= '</tr>';
                    // }
                }
                $contentItem .= '</table>';
                echo $contentItem;
            ?>
        </div>
    </div>

</div>
<?php // Modal::end(); ?>