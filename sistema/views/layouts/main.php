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
        'brandLabel' => 'Prosul - DNIT',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'nnavbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar-collapse fixed-top',
            'id' => 'my-menu',
        ]
    ]);
    echo Nav::widget([
        'options' => [
            'class' => 'navbar-nav me-auto mb-2 mb-lg-0',
            'style' => 'align:center'
        ],
        'items' => [
            // ['label' => 'Início', 'url' => ['/site/index']],
            [
                'label' => 'Empreendimentos', 
                'url' => ['/empreendimento'],
                'visible' => !Yii::$app->user->isGuest
            ],
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
