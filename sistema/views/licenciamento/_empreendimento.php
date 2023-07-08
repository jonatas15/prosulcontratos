<?php
    use yii\bootstrap5\Modal;
    use app\models\Empreendimento;
    $Emp = Empreendimento::findOne([
        'id' => $id
    ]);
?>
<center>
<?php
    Modal::begin([
        'title' => 'Empreendimento '.$Emp->titulo,
        'toggleButton' => [
            'label' => $Emp->titulo,
            'class' => 'btn btn-link'
        ],
        'size' => 'modal-md',
        'options' => [
            'id' => 'ver-empreendimento-detalhes-licenciamento-'.$id,
            'tabindex' => false,
        ],
        'bodyOptions' => [
            'class' => 'bg-white'
        ]
    ]);
?>
<?= $Emp->titulo ?>
<?php Modal::end(); ?>
</center>
