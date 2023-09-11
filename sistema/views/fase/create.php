<?php
    use yii\helpers\Html;
    use yii\bootstrap5\Modal;
?>
<?php
Modal::begin([
    'title' => "Nova Fase",
    'options' => [
        'id' => 'cadastrar-nova-fase-'.$licenciamento_id,
        'tabindex' => false,
    ],
    'bodyOptions' => [
        'class' => 'bg-white',
    ],
    'size' => 'modal-md',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i> Nova Fase em '.$licenciamento,
        'class' => 'btn btn-success text-white float-right'
    ],
]);
?>
<div class="fase-create">
    <?= $this->render('_form', [
        'model' => $model,
        'action' => Yii::$app->homeUrl.'fase/create',
        'licenciamento_id' => $licenciamento_id
    ]) ?>
</div>
<?php Modal::end(); ?>