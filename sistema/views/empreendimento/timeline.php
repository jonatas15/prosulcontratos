<?php 
    use app\models\Fase;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\grid\ActionColumn;
    use yii\grid\GridView;
    use kartik\editable\Editable;

    
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
    <?= $this->render(Yii::$app->homeUrl.'fase/create', [
        'model' => $novafase,
        'licenciamento_id' => $licenciamento_id,
        'licenciamento' => $model->numero
    ]) ?>
    <!-- Área Gerencial -->
    <div class="row text-center justify-content-center mb-5 mt-5">
        <!-- <div class="col-12">
            <h4 class="font-weight-bold">Evolução do Empreendimento</h4>
        </div> -->
    </div>

    <div class="row">
        <div class="col">
            <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                <?php $i = 1; ?>
                <?php foreach ($model->fases as $fase): ?>
                    <?php 
                    $innerBg = "";
                        switch ($fase->status) {
                            case 'Concluído': $innerBg = "bg-success"; break;
                            case 'Em andamento': $innerBg = "bg-info"; break;
                            case 'Pendente': $innerBg = "bg-default"; break;
                        }    
                    ?>
                    <div class="timeline-step" style="cursor: pointer">
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
                            <p class="h6 mt-3 mb-1"><?=date('d/m/Y', strtotime($fase->data))?></p>
                            <p class="h6 text-muted mb-0 mb-lg-0"><?=$fase->fase?></p>
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
        <?= GridView::widget([
            'dataProvider' => $dataProviderFases,
            // 'filterModel' => $searchModelFases,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn'
                ],
                // 'empreendimento_id',
                // 'licenciamento_id',
                'fase',
                'datacadastro',
                'data',
                'exigencias',
                'ambito',
                [
                    'attribute' => 'status',
                    'format'=>'raw',
                    'value' => function($data) {
                        return Editable::widget([
                            'name'=>'status', 
                            'asPopover' => true,
                            'value' => $data->status,
                            'header' => 'Status',
                            'size'=>'md',
                            'inputType' => Editable::INPUT_DROPDOWN_LIST,
                            'data' => [
                                'Pendente' => 'Pendente',
                                'Em andamento' => 'Em andamento',
                                'Concluído' => 'Concluído',
                            ],
                            'formOptions' => [
                                'action' => [
                                    Yii::$app->homeUrl.'fase/editcampo',
                                    'id' => $data->id,
                                    'campo' => 'status'
                                ]
                            ],
                        ]);
                    } 
                ],
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
                            case 'Pendente': $innerBg = "bg-default"; break;
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
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Fase $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => "{delete}"
                ],
            ],
        ]); ?>
    </div>
</div>
