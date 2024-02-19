<?php
    use yii\helpers\Html;
    use yii\bootstrap5\Modal;
?>
<?php
Modal::begin([
    'title' => "Novo Ofício",
    'options' => [
        'id' => 'cadastrar-novo-oficio',
        'tabindex' => false,
    ],
    'bodyOptions' => [
        'style' => [
            'background-color'=> 'darkslategray'
        ],
    ],
    'size' => 'modal-xl',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i> Novo Ofício',
        'class' => 'btn btn-primary text-white  float-right'
    ],
]);
?>
<div class="oficio-create text-white fw-bolder">
    <?= $this->render('_form', [
        'model' => $model,
        'action' => '/oficio/create',
        'contrato_id' => $contrato_id,
        'id_externo' => true
    ]) ?>
</div>
<?php Modal::end(); ?>