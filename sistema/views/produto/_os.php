<?php
 use yii\bootstrap5\Modal;
 use app\models\Ordensdeservico;
 $OS = Ordensdeservico::findOne([
    'id' => $id
 ]);
 ?>
 <center>
<?php
 Modal::begin([
     'title' => 'Ordem de Serviço',
     'toggleButton' => [
         'label' => 'ver OS',
         'class' => 'btn btn-link'
        ],
        'size' => 'modal-md',
        'options' => [
            'id' => 'ver-os-detalhes-produto-'.$id,
            'tabindex' => false,
        ],
        'bodyOptions' => [
            'class' => 'bg-white'
            ]
        ]);
        ?>
<?= $OS->titulo ?>
<?php Modal::end(); ?>

</center>