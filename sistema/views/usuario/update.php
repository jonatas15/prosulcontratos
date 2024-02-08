<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Atualizar Usuário: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="usuario-update">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
