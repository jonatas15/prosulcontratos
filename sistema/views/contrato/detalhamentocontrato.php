<?php 
use app\models\Oficio;
use app\models\Ordensdeservico as Ordens;
use app\models\Produto;

?>
<div class="row">
<div class="col-5">
    <?php $i = 0; ?>
    <ul class="list-group list-group-horizontal row">
        <?php foreach ($model->attributes as $k => $row): ?>
            <?php //if(!in_array($k, ['id', 'icone', 'obs', 'titulo'])): ?>
            <?php if(in_array($k, ['datacadastro', 'dataupdate', 'lote', 'objeto'])): ?>
            <li class="list-group-item col" style="border: none !important;">
                <div class="ms-2 me-auto">
                    <div class="fw-bold"><?=$model->attributeLabels()[$k]?></div>
                    <?=formatar_campo($k, $row)?>
                </div>
                <!-- <span class="badge bg-primary rounded-pill">14</span> -->
            </li>
            <?php $i++; ?>
            <?php if ($i%2 == 0) {
                echo '</ul><ul class="list-group list-group-horizontal row">';
            } ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
<div class="col-7">
    <div class="row">
        <div class="col my-2">
            <div class="card text-center">
                <div class="card-header bg-primary text-white">
                    Empreendimentos
                    <span style="" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-7">
                        <i class="bi bi-bell"></i> <?=$conta_mensagens?>+
                        <span class="visually-hidden">mensagens não lidas</span>
                    </span>
                </div>
                <div class="card-body">
                    <h1 class="card-title" style="font-size: 50px">
                        <i class="fas fa-road"></i>
                    </h1>
                    <p class="card-text">
                        <?= (count($model->empreendimentos)).' registros feitos' ?><br>
                        <?= (count(\app\models\Licenciamento::find()->all())).' licenciamentos' ?><br>
                        <?= (count(\app\models\Fase::find()->all())).' processos' ?>
                    </p>
                    <a href="<?=Yii::$app->homeUrl.'empreendimento'?>" class="btn btn-info text-white">Visualizar</a>
                </div>
                <div class="card-footer text-muted">
                    0 dias atrás
                </div>
            </div>
        </div>
        <div class="col my-2">
            <div class="card text-center">
                <div class="card-header bg-primary text-white">
                    Gestão de Ofícios
                    <span style="" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-7">
                        <i class="bi bi-bell"></i> <?=$conta_mensagens?>+
                        <span class="visually-hidden">mensagens não lidas</span>
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                    <img src="<?=Yii::$app->homeUrl.'logo/upload-files-icon.png'?>" width="50" class="icone-modulo" />
                    </h5>
                    <p class="card-text">
                        <?= (count($model->oficios)).' registros feitos' ?><br>
                        <?= (Oficio::find()->where([
                            'contrato_id' => $model->id,
                            'status' => 'Em Andamento'
                        ])->count()).' em andamento'?> <br>
                        <?= (Oficio::find()->where([
                            'contrato_id' => $model->id,
                            'status' => 'Resolvido'
                        ])->count()).' concluídos'; ?>
                    </p>
                    <a href="<?=Yii::$app->homeUrl.'contrato/view?id='.$model->id.'&abativa=aba_oficios'?>" class="btn btn-info text-white">Visualizar</a>
                </div>
                <div class="card-footer text-muted">
                    0 dias atrás
                </div>
            </div>
        </div>
        <div class="col my-2">
            <div class="card text-center">
                <div class="card-header bg-primary text-white">
                    Ord. Serviço
                    <span style="" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-7">
                        <i class="bi bi-bell"></i> <?=$conta_mensagens?>+
                        <span class="visually-hidden">mensagens não lidas</span>
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                    <img src="<?=Yii::$app->homeUrl.'logo/upload-files-icon.png'?>" width="50" class="icone-modulo" />
                    </h5>
                    <p class="card-text">
                        <?= (count($model->ordensdeservicos)).' registros feitos' ?><br>
                        <?= (Ordens::find()->where([
                            'contrato_id' => $model->id,
                            'fase' => 'OS em Andamento'
                        ])->count()).' em andamento'?> <br>
                        <?= (Ordens::find()->where([
                            'contrato_id' => $model->id,
                            'fase' => 'OS Emitida'
                        ])->count()).' OS Emitidas'; ?>
                    </p>
                    <a href="<?=Yii::$app->homeUrl.'contrato/view?id='.$model->id.'&abativa=aba_ordens'?>" class="btn btn-info text-white">Visualizar</a>
                </div>
                <div class="card-footer text-muted">
                    0 dias atrás
                </div>
            </div>
        </div>
        <div class="col my-2">
            <div class="card text-center">
                <div class="card-header bg-primary text-white">
                    Produtos
                    <span style="" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-7">
                        <i class="bi bi-bell"></i> <?=$conta_mensagens?>+
                        <span class="visually-hidden">mensagens não lidas</span>
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                    <img src="<?=Yii::$app->homeUrl.'logo/upload-files-icon.png'?>" width="50" class="icone-modulo" />
                    </h5>
                    <p class="card-text">
                        <?= (count($model->produtos)).' registros feitos' ?><br>
                        <?= (Produto::find()->where([
                            'contrato_id' => $model->id,
                            'fase' => 'Em Andamento'
                        ])->count()).' em andamento'?> <br>
                        <?= (Produto::find()->where([
                            'contrato_id' => $model->id,
                            'fase' => 'Aprovado'
                        ])->count()).' Aprovados'; ?>
                    </p>
                    <a href="<?=Yii::$app->homeUrl.'contrato/view?id='.$model->id.'&abativa=aba_produtos'?>" class="btn btn-info text-white">Visualizar</a>
                </div>
                <div class="card-footer text-muted">
                    0 dias atrás
                </div>
            </div>
        </div>
    </div>
</div>
</div>