<?php

/** @var yii\web\View $this */
use yii\bootstrap5\Accordion;
use app\models\Contrato;
use app\models\Oficio;
use app\models\Ordensdeservico as OS;
use app\models\Licenciamento;
use app\models\Produto;

use yii\bootstrap5\Modal;

$this->title = 'PROSUL-DNIT';
?>
<style>
    .card-header {
        font-size: 110% !important;
        font-weight: bolder !important;
    }
    .icone-modulo {
        width: 90px;
        height: 120px;
        opacity: .3;
    }
    .btn-primary {
        background-color: #0C326F !important;
    }
    .card-header {
        background-color: #0167A8 !important;
        color: white !important;
    }
</style>
<div class="site-index">
    
    <div class="row">
        <?php 
                // $identity = \app\models\Usuario::findByUsername('jonataswd');
                // Yii::$app->user->login($identity);
                /**
                 * 
                    <ul>
                        <li>User: <?= \app\models\Usuario::findByUsername('jonataswd')->nome; ?></li>
                        <li>Logado: <?= Yii::$app->user->isGuest; ?></li>
                        <li>User: <?= Yii::$app->user->identity->nome; ?></li>
                        <li>User ID: <?= Yii::$app->user->identity->id; ?></li>
                    </ul>
                */
            ?>
    </div>
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <!-- <h3 class="display-4">Bem vindo!</h3> -->

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <img style="width:40%" src="<?=Yii::$app->homeUrl.'logo/';?>logoprosul.jpg" alt="">
            </div>
            <!-- <div class="col-md-5">
                <img style="width:100%" src="<?php //=Yii::$app->homeUrl.'logo/';?>dnit.jpg" alt="">
            </div> -->
            <div class="col-md-4"></div>
        </div>

        <p align="right">
        <?php
            Modal::begin([
                'title' => "Novo Contrato",
                'options' => [
                    'id' => 'cadastrar-novo-contrato',
                    'tabindex' => false,
                ],
                'bodyOptions' => [
                    'class' => 'bg-white',
                ],
                'size' => 'modal-xl',
                'toggleButton' => [
                    'label' => '<i class="bi bi-card-list"></i> Novo Contrato',
                    'class' => 'btn btn-lg btn-primary align-right'
                ],
            ]);
        ?>
        <?php
            $newcontrato = new Contrato();
        ?>
        <?= $this->render(
            '/contrato/create',
        [
            'model' => $newcontrato
        ]) ?>
        <?php Modal::end(); ?>
            <!-- <a class="btn btn-lg btn-success align-right" href="https://www.yiiframework.com">
                Novo Contrato
            </a> -->
        </p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php /*
            <div class="col-lg-4 mb-3">
                <h2>Heading</h2>

                <?php //= yii\bootstrap5\Progress::widget(['percent' => 60, 'label' => 'test']) ?>
                <?php 
                    // use miloschuman\highcharts\Highcharts;

                    // echo Highcharts::widget([
                    //    'options' => [
                    //       'title' => ['text' => 'Fruit Consumption'],
                    //       'xAxis' => [
                    //          'categories' => ['Apples', 'Bananas', 'Oranges']
                    //       ],
                    //       'yAxis' => [
                    //          'title' => ['text' => 'Fruit eaten']
                    //       ],
                    //       'series' => [
                    //          ['name' => 'Jane', 'data' => [1, 0, 4]],
                    //          ['name' => 'John', 'data' => [5, 7, 3]]
                    //       ]
                    //    ]
                    // ]);
                ?>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="https://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            */?>
            <?php /**
            * ANTIGO MODO DE ACORDION COM DETALHES DOS MÓDULOS DO CONTRATO
            
            <div class="col-12 col-lg-12 col-md-12">
                <?php 
                    $contratos = Contrato::find()->all();
                    $lista = [];
                    
                    foreach ($contratos as $k => $contrato) {
                        $content = "";
                        $divrowA = "<div class='row'>";
                        $divrowX = "</div>";
                        $divcollA = "<div class='col-12 col-md'>";
                        $divcollX = "</div>";
                        $content .= $divrowA;
                        //Aqui os Módulos do Contrato
                        $content .= $divcollA;
                        $content .= '
                            <div class="card text-center">
                                <div class="card-header bg-primary text-white">
                                    Dados Contratuais
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <img src="'.Yii::$app->homeUrl.'logo/contract-icon.png" class="icone-modulo" />
                                    </h5>
                                    <p class="card-text">
                                        5 módulos<br>
                                        100 atualizações<br>
                                        9 mensagens<br>
                                    </p>
                                    <a href="'.Yii::$app->homeUrl.'contrato/view?id='.$contrato->id.'&abativa=aba_dados" class="btn btn-info text-white"><i class="far fa-eye"></i><br>Ver +</a>
                                    <a href="'.Yii::$app->homeUrl.'contrato/view?id='.$contrato->id.'&abativa=aba_impactos" class="btn btn-info text-white">Impactos<br>Contratuais</a>
                                </div>
                                <div class="card-footer text-muted">
                                    1 dia atrás
                                </div>
                            </div>
                        ';
                        $content .= $divcollX;
                        $content .= $divcollA;
                        $conta_mensagens = 0;
                        foreach ($contrato->oficios as $ofc):
                            $conta_mensagens += count($ofc->mensagens);
                        endforeach;
                        $content .= '
                            <div class="card text-center">
                                <div class="card-header bg-primary text-white">
                                    Gestão de Ofícios
                                    <span style="" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-7">
                                        <i class="bi bi-bell"></i> '.$conta_mensagens.'+
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                    <img src="'.Yii::$app->homeUrl.'logo/upload-files-icon.png" class="icone-modulo" />
                                    </h5>
                                    <p class="card-text">
                                        '.(count($contrato->oficios)).' registros feitos <br>
                                        '.(Oficio::find()->where([
                                            'contrato_id' => $contrato->id,
                                            'status' => 'Em Andamento'
                                        ])->count()).' em andamento <br>
                                        '.(Oficio::find()->where([
                                            'contrato_id' => $contrato->id,
                                            'status' => 'Resolvido'
                                        ])->count()).' concluídos
                                    </p>
                                    <a href="'.Yii::$app->homeUrl.'contrato/view?id='.$contrato->id.'&abativa=aba_oficios" class="btn btn-info text-white">Visualizar</a>
                                </div>
                                <div class="card-footer text-muted">
                                    0 dias atrás
                                </div>
                            </div>
                        ';
                        $content .= $divcollX;
                        $content .= $divcollA;
                        $content .= '
                            <div class="card text-center">
                                <div class="card-header bg-primary text-white">
                                    Ordens de Serviço
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                    <img src="'.Yii::$app->homeUrl.'logo/surveys-icon.png" class="icone-modulo" />
                                    </h5>
                                    <p class="card-text">
                                        '.(OS::find()->where([
                                            'contrato_id' => $contrato->id
                                        ])->count()).' registros feitos <br>
                                        <br>
                                        <br>
                                    </p>
                                    <a href="'.Yii::$app->homeUrl.'contrato/view?id='.$contrato->id.'&abativa=aba_ordens" class="btn btn-info text-white">Visualizar</a>
                                </div>
                                <div class="card-footer text-muted">
                                    2 dias atrás
                                </div>
                            </div>
                        ';
                        $content .= $divcollX;
                        $content .= $divcollA;
                        $content .= '
                            <div class="card text-center">
                                <div class="card-header bg-primary text-white">
                                    Licenciamentos
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                    <img src="'.Yii::$app->homeUrl.'logo/notary-icon.png" class="icone-modulo" />
                                    </h5>
                                    <p class="card-text">
                                        '.(Licenciamento::find()->where([
                                            'contrato_id' => $contrato->id
                                        ])->count()).' Registros feitos<br>
                                        <br>
                                        <br>
                                    </p>
                                    <a href="'.Yii::$app->homeUrl.'contrato/view?id='.$contrato->id.'&abativa=aba_licensas" class="btn btn-info text-white">Visualizar</a>
                                </div>
                                <div class="card-footer text-muted">
                                    2 dias atrás
                                </div>
                            </div>
                        ';
                        $content .= $divcollX;
                        $content .= $divcollA;
                        $content .= '
                            <div class="card text-center">
                                <div class="card-header bg-primary text-white">
                                    Produtos
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                    <img src="'.Yii::$app->homeUrl.'logo/slideshow-icon.png" class="icone-modulo" />
                                    </h5>
                                    <p class="card-text">
                                        '.(Produto::find()->where([
                                            'contrato_id' => $contrato->id
                                        ])->count()).' registros feitos <br>
                                        '.(Produto::find()->where([
                                            'contrato_id' => $contrato->id,
                                            'fase' => 'Em Andamento'
                                        ])->count()).' em andamento <br>
                                        '.(Produto::find()->where([
                                            'contrato_id' => $contrato->id,
                                            'fase' => 'Aprovado'
                                        ])->count()).' aprovados
                                    </p>
                                    <a href="'.Yii::$app->homeUrl.'contrato/view?id='.$contrato->id.'&abativa=aba_produtos" class="btn btn-info text-white">Visualizar</a>
                                </div>
                                <div class="card-footer text-muted">
                                    2 dias atrás
                                </div>
                            </div>
                        ';
                        $content .= $divcollX;
                        // Fim dos Módulos do Contrato
                        $content .= $divrowX;
                        array_push($lista, [
                            'label' => $contrato->titulo,
                            'content' => $content
                        ]);
                    }
                    echo Accordion::widget([
                        'items' => $lista
                    ]);
                ?>
            </div>

            */ ?>
            <?php $contratos = Contrato::find()->all(); ?>
            <?php foreach ($contratos as $k => $contrato): ?>
            <div class="col-6 my-3">
                <div class="card">
                    <div class="card-header bg-primary"><?=$contrato->titulo?></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label class="label form-label fw-bolder">Processo administrativo</label>
                                <br>
                                <label class="caption form-label"><?=$contrato->lote?></label>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-6">
                                <label class="label form-label fw-bolder">Nº Edital</label>
                                <br>
                                <label class="caption form-label"><?=$contrato->num_edital?></label>
                            </div>
                            <div class="col-6">
                                <label class="label form-label fw-bolder">Número do Contrato</label>
                                <br>
                                <label class="caption form-label"><?=$contrato->titulo?></label>
                            </div>
                        </div>
                        <div class="row">
                            <center>
                                <a href="<?=Yii::$app->homeUrl.'contrato/view?id='.$contrato->id?>" type="button" class="w-50 px-4 button-adicionar btn btn-primary">
                                    <!-- Acessar <i class="fa fa-search fa-flip-horizontal"></i> -->
                                    Acessar <i class="fa fa-search"></i>
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
