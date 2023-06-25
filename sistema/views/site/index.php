<?php

/** @var yii\web\View $this */
// use yii\bootstrap2\Collapse;
use yii\bootstrap5\Accordion;
use app\models\Contrato;

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
            <div class="col-md-3">
                <img style="width:100%" src="<?=Yii::$app->homeUrl.'logo/';?>logoprosul.jpg" alt="">
            </div>
            <div class="col-md-5">
                <img style="width:100%" src="<?=Yii::$app->homeUrl.'logo/';?>dnit.jpg" alt="">
            </div>
            <div class="col-md-4"></div>
        </div>

        <p align="right">
            <a class="btn btn-lg btn-success align-right" href="https://www.yiiframework.com">
                Novo Contrato
            </a>
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
                                    <span style="z-index: 100000 !important;" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-7">
                                        <i class="bi bi-bell"></i> 9+
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <img src="'.Yii::$app->homeUrl.'logo/contract-icon.png" class="icone-modulo" />
                                    </h5>
                                    <p class="card-text">
                                        5 módulos
                                        <br>
                                        158 Registros
                                        <br>
                                        <br>
                                    </p>
                                    <a href="'.Yii::$app->homeUrl.'contrato/view?id='.$contrato->id.'&abativa=aba_dados" class="btn btn-info text-white">Visualizar</a>
                                </div>
                                <div class="card-footer text-muted">
                                    1 dia atrás
                                </div>
                            </div>
                        ';
                        $content .= $divcollX;
                        $content .= $divcollA;
                        $content .= '
                            <div class="card text-center">
                                <div class="card-header bg-primary text-white">
                                    Gestão de Ofícios
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                    <img src="'.Yii::$app->homeUrl.'logo/upload-files-icon.png" class="icone-modulo" />
                                    </h5>
                                    <p class="card-text">
                                        155 registros feitos <br>
                                        11 em andamento <br>
                                        8 concluídos
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
                                        0 registros feitos <br>
                                        0 em andamento <br>
                                        0 concluído
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
                                        0 registros feitos <br>
                                        0 em andamento <br>
                                        0 concluído
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
                                        0 registros feitos <br>
                                        0 em andamento <br>
                                        0 concluído
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
        </div>

    </div>
</div>
