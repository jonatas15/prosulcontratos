<?php 
    use app\models\Fase;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\grid\ActionColumn;
    use yii\grid\GridView;
    use kartik\editable\Editable;
    use yii\helpers\ArrayHelper;

    
?>
<style>
    .timeline-steps {
        display: flex;
        justify-content: center;
        flex-wrap: wrap
    }

    .timeline-steps .timeline-step {
        align-items: center;
        display: flex;
        flex-direction: column;
        position: relative;
        margin: 1rem
    }

    @media (min-width:768px) {
        .timeline-steps .timeline-step:not(:last-child):after {
            content: "";
            display: block;
            border-top: .25rem dotted gray;
            width: 3.46rem;
            position: absolute;
            left: 7.5rem;
            top: .3125rem
        }
        .timeline-steps .timeline-step:not(:first-child):before {
            content: "";
            display: block;
            border-top: .25rem dotted gray;
            width: 3.8125rem;
            position: absolute;
            right: 7.5rem;
            top: .3125rem
        }
    }

    .timeline-steps .timeline-content {
        width: 10rem;
        text-align: center
    }

    .timeline-steps .timeline-content .inner-circle {
        border-radius: 1.5rem;
        height: 1rem;
        width: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #3b82f6;
    }

    .timeline-steps .timeline-content .inner-circle:before {
        content: "";
        background-color: gray;
        display: inline-block;
        height: 3rem;
        width: 3rem;
        min-width: 3rem;
        border-radius: 6.25rem;
        opacity: .2
    }
    .nav-tabs > li {
    float:none;
    display:inline-block;
    zoom:1;
    }

    .nav-tabs {
        text-align:center;
    }
</style>
<div class="container">
    <!-- Área Gerencial -->
    <?php $novafase = new Fase(); ?>
    <div class="row my-3">
        <?php /*
        *
            <div class="col-md-2">
                <?= $this->render('/fase/create', [
                    'model' => $novafase,
                    'licenciamento_id' => $licenciamento_id,
                    'licenciamento' => $model->numero
                ]) ?>
            </div>
        */?>    
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <?= $this->render('definicaofases', [
                'fases' => $model->fases,
                'licenciamento' => $model->numero,
                'licenciamento_id' => $licenciamento_id,
            ]) ?>
        </div>
    </div>
    <!-- Área Gerencial -->
    <div class="row text-center justify-content-center mb-5 mt-2">
        <!-- <div class="col-12">
            <h4 class="font-weight-bold">Evolução do Empreendimento</h4>
        </div> -->
        <!-- <?=$model->id?> -->
    </div>

    <div class="row">
        <div class="col">
            <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                <?php $i = 1; ?>
                <?php 
                    $fases = \app\models\Fase::find()->where([
                        'licenciamento_id' => $model->id,
                        'ativo' => 1
                    ])->all();
                ?>
                <?php foreach ($fases as $fase): ?>
                    <?php 
                    $innerBg = "";
                        switch ($fase->status) {
                            case 'Concluído': $innerBg = "bg-success"; break;
                            case 'Em andamento': $innerBg = "bg-info"; break;
                            case 'Pendente': $innerBg = "bg-danger"; break;
                        }    
                    ?>
                    <div class="timeline-step" style="cursor: pointer" title="<?=date('d/m/Y', strtotime($fase->data))?>" alt="<?=date('d/m/Y', strtotime($fase->data))?>">
                        <span style="position: absolute; top: -5px" class="badge rounded-pill text-<?=$innerBg?> text-white fs-6"><?=$i?></span>
                        <div 
                            class="timeline-content" 
                            data-toggle="tooltip"
                            data-placement="top"
                            data-trigger="hover"
                            title="<?= $fase->exigencias;?>"
                            data-original-title="2003"
                        >
                            
                            <div class="inner-circle <?=$innerBg?>">
                            </div>
                            <!-- <p class="h6 mt-3 mb-1"><?=date('d/m/Y', strtotime($fase->data))?></p> -->
                            <p class="h6 text-muted mb-0 mb-lg-0" data-bs-toggle="tooltip"><?=$fase->fase?></p>
                            <?php /*
                            <p class="fs-6 text-muted mb-0 mb-lg-0"><?=Editable::widget([
                                'name'=>'status', 
                                'asPopover' => true,
                                'value' => $fase->status,
                                'header' => 'Status',
                                'size'=>'sm',
                                'inputType' => Editable::INPUT_RADIO_LIST,
                                'data' => [
                                    'Pendente' => 'Pendente',
                                    'Em andamento' => 'Em andamento',
                                    'Concluído' => 'Concluído',
                                ],
                                'formOptions' => [
                                    'action' => [
                                        'fase/editcampo',
                                        'id' => $fase->id,
                                        'campo' => 'status'
                                    ]
                                ],
                            ]);?></p>
                            */?>
                        </div>
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>
                <div class="timeline-step mb-0">
                    <div class="timeline-content" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Sistema Fechado" data-original-title="2020">
                        <div class="inner-circle bg-black"></div>
                        <p class="h6 mt-3 mb-1">Conclusão</p>
                        <p><center><?=$model->numero?></center></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        Licenciamento: <?= $licenciamento_id; ?>
        <?php 
            $previousDate = null;
            foreach ($dataProviderFases->models as $model) {
                if ($previousDate !== null) {
                    $model->daysBetween = (strtotime($model->data) - strtotime($previousDate)) / 86400;
                    // Use $daysBetween as needed
                }
                $previousDate = $model->data;
            }
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProviderFases,
            // 'filterModel' => $searchModelFases,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn'
                ],
                [
                    'attribute' => 'ambito',
                    'value' => function($data) {
                        $retorno = 'Estadual';
                        switch ($data->ambito) {
                            case '1': $retorno = 'Estadual'; break;
                            case '2': $retorno = 'Federal'; break;
                            case '3': $retorno = 'Funai'; break;
                            case '4': $retorno = 'INCRA'; break;
                            case '5': $retorno = 'IPHAN'; break;
                        }
                        return $retorno;
                    }
                ],
                'fase',
                [
                    'attribute' => 'data',
                    'format' => 'raw',
                    'headerOptions' => [
                        'width' => '10%'
                    ],
                    // 'value' => function($data) {
                    //     return date('d/m/Y', strtotime($data->data));
                    // }
                    'value' => function($data) {
                        
                        return Editable::widget([
                            'name'=>'data', 
                            'asPopover' => true,
                            'value' => date('d/m/Y', strtotime($data->data)),
                            'size'=>'md',
                            'inputType' => Editable::INPUT_DATE,
                            'options' => [
                                'language' => 'pt_BR',
                                'pluginOptions' => [
                                    'timePicker' => true,
                                    'format' => 'dd/mm/yyyy',
                                ],
                            ],
                            'formOptions' => [
                                'action' => [
                                    'fase/editcampo',
                                    'id' => $data->id,
                                    'campo' => 'data'
                                ]
                            ],
                        ]);
                    }
                ],
                // [
                //     'attribute' => 'datacadastro',
                //     'format' => 'raw',
                //     'headerOptions' => [
                //         'width' => '10%'
                //     ],
                //     // 'value' => function($data) {
                //     //     return date('d/m/Y H:i:s', strtotime($data->datacadastro));
                //     // }
                //     'value' => function($data) {
                        
                //         return Editable::widget([
                //             'name'=>'datacadastro', 
                //             'asPopover' => true,
                //             'value' => date('d/m/Y', strtotime($data->datacadastro)),
                //             'size'=>'md',
                //             'inputType' => Editable::INPUT_DATE,
                //             'options' => [
                //                 'language' => 'pt_BR',
                //                 'pluginOptions' => [
                //                     'timePicker' => true,
                //                     'format' => 'dd/mm/yyyy',
                //                 ],
                //             ],
                //             'formOptions' => [
                //                 'action' => [
                //                     'fase/editcampo',
                //                     'id' => $data->id,
                //                     'campo' => 'datacadastro'
                //                 ]
                //             ],
                //         ]);
                //     }
                // ],
                // 'ordem',
                [
                    'format' => 'raw',
                    'header' => 'Dias passados',
                    'headerOptions' => [
                        'width' => '10%'
                    ],
                    'value' => function($data) {
                        /**
                         * 
                            $data_update_anterior = \app\models\Fase::find()->where([
                             'licenciamento_id' => $data->licenciamento_id,
                             'ativo' => 1,
                            ])->andWhere([
                                '<', 'ordem', $data->ordem
                            ])->andWhere([
                                '<>', 'id', $data->id
                            ])->one();
                            return $data_update_anterior->datacadastro;
                            // return date('d/m/Y H:i:s', strtotime($data->datacadastro));
                            $dias_passados = $this->context->diasentre($data->data, date('Y-m-d', strtotime($data->datacadastro)));
                            $return = $dias_passados.($dias_passados != 1 ? ' dias' : ' dia');
                            return $return;
                        */
                        return ($data->daysBetween != '' ? '' : '0').$data->daysBetween.($data->daysBetween != 1 ? ' dias' : ' dia');
                    }
                ],
                // 'exigencias',
                // 'produto_id',
                [
                    'attribute' => 'produto_id',
                    'format'=>'raw',
                    'headerOptions' => [
                        'width' => '10%'
                    ],
                    'value' => function($data) {
                        $produtos_do_empreendimento = ArrayHelper::map(\app\models\Produto::find()->where([
                            'empreendimento_id' => $data->licenciamento->empreendimento_id
                        ])->all(), 'id', 'subproduto');
                        $renderizaProduto = '';
                        if (!in_array($data->produto_id, ['', ' ', 0, 'null', 'NULL', NULL, null])) {
                            $renderizaProduto = $this->render('/produto/detalhes', [
                                'id' => $data->produto_id
                            ]);
                        }
                        
                        return Editable::widget([
                            'name'=>'produto_id', 
                            'asPopover' => true,
                            'value' => $data->produto_id,
                            'displayValue' => ' ',
                            'size'=>'md',
                            'inputType' => Editable::INPUT_DROPDOWN_LIST,
                            'data' => $produtos_do_empreendimento,
                            'format' => 'button',
                            'formOptions' => [
                                'action' => [
                                    'fase/editcampo',
                                    'id' => $data->id,
                                    'campo' => 'produto_id'
                                ]
                            ],
                        ]).$renderizaProduto;
                    }
                ],
                [
                    'attribute' => 'status',
                    'format'=>'raw',
                    'value' => function($data) {
                        return Editable::widget([
                            'name'=>'status', 
                            'asPopover' => true,
                            'value' => $data->status,
                            'header' => 'Status',
                            'size'=>'sm',
                            'inputType' => Editable::INPUT_RADIO_LIST,
                            'data' => [
                                'Pendente' => 'Pendente',
                                'Em andamento' => 'Em andamento',
                                'Concluído' => 'Concluído',
                            ],
                            'formOptions' => [
                                'action' => [
                                    'fase/editcampo',
                                    'id' => $data->id,
                                    'campo' => 'status'
                                ]
                            ],
                        ]);
                    } 
                ],
                /*
                [
                    'attribute' => 'ordem',
                    'headerOptions' => [
                        'width' => '10%'
                    ],
                    'format' => 'raw',
                    'value' => function ($data) {
                        $innerBg = "";
                        switch ($data->status) {
                            case 'Concluído': $innerBg = "bg-success"; break;
                            case 'Em andamento': $innerBg = "bg-info"; break;
                            case 'Pendente': $innerBg = "bg-danger"; break;
                        }
                        return "<div class='row'>
                            <div class='col'>
                                <exp style='position: absolute;' class=\"badge rounded-pill text-$innerBg text-white fs-7\">$data->ordem</exp>
                                <center>
                                    <a href='".Yii::$app->homeUrl."fase/ordenaup?id=$data->id&ordem=$data->ordem"."' class='btn btn-warning rounded-start-4 rounded-end-0 fw-bolder mx-0'><i class='bi bi-arrow-bar-up'></i></a>
                                    <a href='".Yii::$app->homeUrl."fase/ordenadown?id=$data->id&ordem=$data->ordem"."' class='btn btn-warning rounded-start-0 rounded-end-4 fw-bolder mx-0'><i class='bi bi-arrow-bar-down'></i></a>
                                </center>
                            </div>
                        </div>";
                    }
                ],
                [
                    'attribute' => 'id',
                    'header' => 'Edite',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $this->render('/fase/update', [
                            'model' => Fase::findOne(['id' => $data->id])
                        ]);
                    }
                ]
                */
            ],
        ]); ?>
    </div>
</div>
