<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Empreendimento;
use app\models\ImpactoEmpreendimento as ImpcEmp;
use yii\web\JsExpression;
use miloschuman\highcharts\Highcharts;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\Impacto $model */

\yii\web\YiiAsset::register($this);
?>
<?php
    Modal::begin([
        'title' => $model->servico,
        'toggleButton' => [
            'label' => $model->servico,
            'class' => 'btn btn-link'
        ],
        'size' => 'modal-xl',
        'options' => [
            'id' => 'ver-os-detalhes-impacto-'.$model->id,
            'tabindex' => false,
        ],
        'bodyOptions' => [
            'class' => 'bg-white'
        ]
    ]);
?>
<div class="impacto-view">
    <div class="row">
        <div class="col">
            <h6 class="text-left">Contrato: <?= $model->contrato->titulo ?>, <br><?= $model->produto ?></h6>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                'numeroitem',
                'contrato.titulo',
                'produto:ntext',
                'servico:ntext',
                'unidade',
                'quantidade_a',
                'quantidade_utilizada',
                'qt_restante_real',
                'qt_restante'
            ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?php 
                $empreendimentos = Empreendimento::find()->all();
                $graph_empreendimentos = [];

                foreach($model->impactoEmpreendimentos as $item) {
                    array_push($graph_empreendimentos, [
                        'name' => $item->empreendimento->titulo, 'y' => $item->impactos, 'url' => $emp->id
                    ]);
                }

                # Por Quantidades
                $graph_quantidades = [];
                $quantidades = [
                    'quantidade_a' => 0,
                    'quantidade_utilizada' => 0,
                    'qt_restante_real' => 0,
                    'qt_restante' => 0,
                ];
                foreach ($quantidades as $key => $value) {
                    $valor = 0;
                    $label = "Valor";
                    foreach($model as $chave => $item) {
                        $label = $model::instance()->getAttributeLabel($key);
                        $valor = $model->$key;
                    }
                    array_push($graph_quantidades, [
                        'name' => $label, 'y' => $valor, 'url' => ''
                    ]);
                }
            ?>
            <div class="col-md-12">
                <?= Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'column'
                        ],
                        'title' => ['text' => 'Por Empreendimento'],
                        'yAxis' => [
                            'title' => ['text' => 'Impactos']
                        ],
                        'xAxis' => [
                            'type' => 'category'
                        ],
                        'series' =>  [
                            [
                                'name' => 'Impactos',
                                "cursor" => "pointer",
                                'colorByPoint' => false,
                                // "point" => [
                                //     "events" => [
                                //         "click" => new JsExpression('function(){
                                //             // $("#produtosearch-empreendimento_id").val(this.options.url);
                                //             // $("#form-pesquisa-produto").submit();
                                //         }')
                                //     ],
                                // ],
                                'data' => $graph_empreendimentos,
                                'showInLegend' => false,
                                'dataLabels' => [
                                    'enabled' => false,
                                ],
                            ],
                        ],
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-12">
                <?= Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'column'
                        ],
                        'title' => ['text' => 'Por Quantidades Resultantes'],
                        'yAxis' => [
                            'title' => ['text' => 'Impactos']
                        ],
                        'xAxis' => [
                            'type' => 'category'
                        ],
                        'series' =>  [
                            [
                                'name' => 'Impactos',
                                "cursor" => "pointer",
                                'colorByPoint' => false,
                                "point" => [
                                    "events" => [
                                        "click" => new JsExpression('function(){
                                            $("#produtosearch-empreendimento_id").val(this.options.url);
                                            $("#form-pesquisa-produto").submit();
                                        }')
                                    ],
                                ],
                                'data' => $graph_quantidades,
                                'showInLegend' => false,
                                'dataLabels' => [
                                    'enabled' => false,
                                ],
                            ],
                        ],
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>

</div>
<?php Modal::end(); ?>