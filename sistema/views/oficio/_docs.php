<?php
use yii\bootstrap5\Modal;
Modal::begin([
    'title' => 'Lista de Documentos',
    'toggleButton' => [
        'label' => '<i class="bi bi-filetype-doc"></i>',
        'class' => 'btn btn-primary'
    ],
    'size' => 'modal-xl',
    'options' => [
        'tabindex' => "false"
    ]
]);

echo 'Aguardando Registros';
echo '<br>';
echo '<br>';
echo '<i class="fas fa-cog fa-spin fa-5x"></i>';

Modal::end();