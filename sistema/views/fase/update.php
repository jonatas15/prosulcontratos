<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;
/** @var yii\web\View $this */
/** @var app\models\Fase $model */
?>
<?php
    Modal::begin([
        'title' => "Editar Etapa ".$model->fase,
        'options' => [
            'id' => 'editar-fase-'.$model->id,
            'tabindex' => false,
        ],
        'bodyOptions' => [
            'class' => 'bg-white',
        ],
        'size' => 'modal-md',
        'toggleButton' => [
            'label' => '<i class="bi bi-pencil"></i>',
            'class' => 'btn btn-success text-white float-right'
        ],
    ]);
?>
<div class="fase-update">
    <?= $this->render('_form', [
        'model' => $model,
        'action' => ['/fase/update','id' => $model->id],
    ]) ?>
</div>
<?php Modal::end(); ?>
