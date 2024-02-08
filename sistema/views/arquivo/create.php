<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Arquivo $model */

?>
<div class="arquivo-create">
    <?= $this->render('_form', [
        'model' => $model,
        // 'oficio_id' => $oficio_id,
        // 'ordensdeservico_id' => $ordensdeservico_id,
        // 'empreendimento_id' => $empreendimento_id,
        // 'produto_id' => $produto_id,
        'licenciamento_id' => $licenciamento_id,
        'id_tabela_referencia' => $id_tabela_referencia,
        'id_valor_referencia' => $id_valor_referencia,
    ]) ?>
</div>
