<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);


// IUcone DRIVE
$g_drive = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M339 314.9L175.4 32h161.2l163.6 282.9H339zm-137.5 23.6L120.9 480h310.5L512 338.5H201.5zM154.1 67.4L0 338.5 80.6 480 237 208.8 154.1 67.4z"/></svg>';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- on your view layout file HEAD section -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <?php $this->head() ?>
</head>
<style>
    div#my-menu-collapse ul li {
        text-align: center !important;
        margin: 0 auto !important;
    }
    .breadcrumb {
        background-color: rgba(0, 0, 0, 0.05);
    }
    .bradscrumbs {
        /* color: red !important; */
        padding: 10px !important;
        /* border: 1px solid red */
    }
    .breadcrumb-item.active {
        color: var(--bs-breadcrumb-item-active-color);
        padding: 10px !important;
        background-color: rgba(0, 0, 0, 0.05);
        font-weight: 900;
    }
    .float-right {
        float: right !important;
    }
    .float-left {
        float: left !important;
    }
    .text-right {
        text-align: right !important;
    }
    .text-left {
        text-align: left !important;
    }
    .cr-nao-resolvido-bg {
        background-color: red !important;
        color: white !important;
    }
    .cr-nao-resolvido-tx {
        color: red !important;
    }

    .cr-resolvido-bg {
        background-color: green !important;
        color: white !important;
    }
    .cr-resolvido-tx {
        color: green !important;
    }

    .cr-em-andamento-bg {
        background-color: blue !important;
        color: white !important;
    }
    .cr-em-andamento-tx {
        color: orange !important;
    }

    .cr-informativo-bg {
        background-color: lightblue !important;
        color: black !important;
    }
    .cr-informativo-tx {
        color: gray !important;
    }
</style>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="'.Yii::$app->homeUrl.'logo/download.png'.'" width="200"/>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'nnavbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar-collapse fixed-top',
            'id' => 'my-menu',
            'style' => [
                'background-color' => '#0167A8 !important',
                'font-size' => '20px'
            ]
        ]
    ]);
    $contratos = \app\models\Contrato::find()->all();
    $contratoslistados = [];
    foreach ($contratos as $k => $contrato):
        array_push($contratoslistados, [
            'label' => $contrato->titulo, 
            'url' => ['contrato/view?id='.$contrato->id],
        ]);
    endforeach;
    echo Nav::widget([
        'options' => [
            'class' => 'navbar-nav me-auto mb-2 mb-lg-0 nav-pills',
            'style' => 'align:center'
        ],
        'encodeLabels' => false,
        'activateParents' => true,
        'items' => [
            // ['label' => 'Início', 'url' => ['/site/index']],
            [
                'class' => 'bg-primary',
                'label' => '<i class="fa fa-calendar"></i> Calendar', 
                'url' => ['site/calendar'],
                'visible' => !Yii::$app->user->isGuest,
            ],
            [
                'class' => 'bg-primary',
                'label' => '<i class="fa fa-list"></i> Contratos', 
                // 'url' => ['/empreendimento'],
                'visible' => !Yii::$app->user->isGuest,
                'items' => $contratoslistados
            ],
            [
                'class' => 'bg-primary',
                'label' => '<i class="fa fa-globe"></i> Empreendimentos', 
                'url' => ['/empreendimento'],
                'visible' => !Yii::$app->user->isGuest
            ],
            [
                'class' => 'bg-primary',
                'label' => '<i class="fa fa-link"></i> Links - DRIVE',
                // 'url' => ['/empreendimento'],
                'visible' => !Yii::$app->user->isGuest,
                'items' => [
                    [
                        'label' => 'Empreendimentos',
                        'url' => 'http://prosul.bmt.eng.br/#/empreendimentos?contrato_id=1',
                        'linkOptions' => ['target'=>'_blank'],
                    ],
                    [
                        'label' => 'Equipe',
                        'linkOptions' => ['target'=>'_blank'],
                        'url' => 'https://drive.google.com/drive/u/0/folders/17tibbErWqOxvXvrIPxtuIeiaVP1ta4vQ'
                    ],
                    [
                        'label' => 'Cronograma',
                        'linkOptions' => ['target'=>'_blank'],
                        'url' => 'https://drive.google.com/drive/u/0/folders/1h9QY9ybCKnFm6uh3P9FAKbReBGlSX3aM'
                    ],
                    [
                        'label' => 'Impacto Contratual',
                        'linkOptions' => ['target'=>'_blank'],
                        'url' => 'https://drive.google.com/drive/u/0/folders/1rTVS4XHhvJFJTRP5fmWe_WkEFdP4dwhS'
                    ],
                    [
                        'label' => 'Monitoramento Contratual',
                        'linkOptions' => ['target'=>'_blank'],
                        'url' => 'https://docs.google.com/spreadsheets/d/1ykXt_3lxOgUdw0l9SLUMDacd-ym1pHmR/edit#gid=574077694'
                    ],
                ]
            ],
            // [
            //     'label' => 'Empreendimentos', 
            //     'url' => ['/empreendimento'],
            //     'visible' => !Yii::$app->user->isGuest
            // ],
            // ['label' => 'Contact', 'url' => ['/site/contact']],
            // Yii::$app->user->isGuest
            //     ? ['label' => 'Login', 'url' => ['/site/login']]
            //     : '<li class="nav-item">'
            //         . Html::beginForm(['/site/logout'])
            //         . Html::submitButton(
            //             'Logout (' . Yii::$app->user->identity->login . ')',
            //             ['class' => 'nav-link btn btn-link logout']
            //         )
            //         . Html::endForm()
            //         . '</li>'
        ]
    ]);
    echo Nav::widget([
        'encodeLabels' => false,
        'options' => [
            'class' => 'navbar-nav'
        ],
        'items' => [
            [
                'label' => 'Usuários', 
                'items' => [
                    ['label' => 'Usuários', 'url' => ['/usuario']],
                    ['label' => 'Cadastrar Novo', 'url' => ['/usuario/create']],
                    ['label' => 'Editar meus dados', 'url' => ['/usuario/update', 'id' => Yii::$app->user->identity->id]],
                ],
                'visible' => !Yii::$app->user->isGuest
            ],
            Yii::$app->user->isGuest
                ? ['label' => ' Login', 'url'=>['/site/login']]
                : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->nome . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
        ]
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <!-- <div class="container"  style="max-width: 80%;"> -->
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li class='bradscrumbs'><b>{link} <i class='bi bi-chevron-double-right'></i> </b></li>", // template for all links
                'links' => $this->params['breadcrumbs']
            ]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Prosul <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end">J.S. webdeveloper </div>
        </div>
    </div>
</footer>
<script type="module" src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
