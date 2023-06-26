<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use app\models\Oficio;
use app\models\Usuario;
use app\models\Mensagem;

$model = Oficio::find()->where(['id' => $id])->one();

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */
// \yii\web\YiiAsset::register($this);

// $model = \app\models\Oficio::find()->where(['id' => $id])->one();

?>
<style>
    /* Chat container-chats */
.container-chat {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

/* Darker chat container-chat */
.darker {
  border-color: #ccc;
  background-color: #ddd;
}

/* Clear floats */
.container-chat::after {
  content: "";
  clear: both;
  display: table;
}

/* Style images */
.container-chat img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

/* Style the right image */
.container-chat img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

/* Style time text */
.time-right {
  float: right;
  color: #aaa;
}

/* Style time text */
.time-left {
  float: left;
  color: #999;
}
.avataruser {
    border-radius: 50% !important;
    width: 70px;
    border: 1px solid black;
    background-color: black;
    float: left;
}
.nomegestor {
    float: left;

}
</style>
<?php
Modal::begin([
    'title' => $model->tipo .': '.$model->id,
    'options' => [
        'id' => 'mensagens-'.$model->id,
        'tabindex' => false,
    ],
    'size' => 'modal-lg',
    'toggleButton' => [
        'label' => '<i class="bi bi-chat"></i>',
        'class' => 'btn btn-warning text-white'
    ],
]);
?>
<div class="row mb-100">
    <div class="col">

        <strong>Em construção</strong>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
                25%
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="row bg-primary text-white card mt-2 mb-3" style="flex-direction:row;">
            <div class="col-md-4" style="position: relative; ">
                <span style="z-index: 100000 !important;" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success fs-7">
                    <i class="bi bi-gear"></i></a>
                </span>
                <img 
                    class="avataruser" 
                    src="<?=Yii::$app->user->identity->foto ? Yii::$app->homeUrl.'usuarios/'.Yii::$app->user->identity->foto : Yii::$app->homeUrl.'usuarios/userpng.png'?>"
                    alt="Avatar"
                    style="object-fit: cover; border-radius: 30px;width:60px;height:60px"
                >
            </div>
            <div class="col-md-8">
                <div class="col">
                    <strong><?=Yii::$app->user->identity->nome?></strong>
                </div>
                <div class="col">
                    <?=Yii::$app->user->identity->nivel?><br>
                </div>
            </div>
        </div>
        <?php foreach(Usuario::find()->limit(5)->all() as $user): ?>
            <?php if ($user->id != Yii::$app->user->identity->id) : ?>
                <div class="row  card mt-2 mb-3" style="flex-direction:row;">
                    <div class="col-md-4" style="position: relative; ">
                        <span style="z-index: 100000 !important;" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success fs-7">
                            <i class="bi bi-gear"></i></a>
                        </span>
                        <img 
                            class="avataruser" 
                            src="<?=$user->foto ? Yii::$app->homeUrl.'usuarios/'.$user->foto : Yii::$app->homeUrl.'usuarios/userpng.png'?>"
                            alt="Avatar"
                            style="object-fit: cover; border-radius: 30px;width:60px;height:60px"
                        >
                    </div>
                    <div class="col-md-8">
                        <div class="col">
                            <strong><?=$user->nome?></strong>
                        </div>
                        <div class="col">
                            <?=$user->nivel?><br>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="col-md-8">
        <?php
            $ultimas3mensagens = \app\models\Mensagem::find()->where([
                'oficio_id' => $id
            ])->orderBy(['datacadastro' => SORT_DESC])->limit(3)->all();
            $reversed = array_reverse($ultimas3mensagens);
        ?>
        <?php foreach($reversed as $msg):?>
            <div class="container-chat">
                <?php 
                    $usuariofalando = Yii::$app->homeUrl.'usuarios/';
                    if ($msg->usuario->foto) {
                        $usuariofalando .= $msg->usuario->foto;
                    } else {
                        $usuariofalando .= "bandmember.jpg";
                    }
                ?>
                <img src="<?=$usuariofalando?>" alt="Avatar" style="object-fit: cover; border-radius: 30px;width:60px;height:60px">
                <h5 style="text-align: left;"><strong><?=$msg->usuario->nome?></strong></h5>
                <hr>
                <p><?=$msg->texto?></p>
                <span class="time-right"><?=date('d/m/Y H:i', strtotime($msg->datacadastro))?></span>
            </div>
        <?php endforeach; ?>
        <div class="container-chat darker">
            <div id="div-recemenviada-<?=$id?>" class="container-chat">
                <div id="recemenviada-<?=$id?>"></div>
                <span class="time-right"><?=date('d/m/Y H:i')?></span>
            </div>
            <textarea name="" id="textmensagem-<?=$id?>" cols="30" rows="5" style="width:100%;padding:2%" placeholder="Sua mensagem aqui"></textarea>
            <button id="enviarmensagem-<?=$id?>" class="btn btn-primary text-white" style="float: right">Enviar</button>
        </div>
    </div>
</div>
<?php Modal::end(); ?>
<?php 
$js_botao = "'#enviarmensagem-$id'";
$js_caixa = "'#textmensagem-$id'";
$js_return = "'#recemenviada-$id'";
$url = "'".Yii::$app->homeUrl.'mensagem/create'."'";
$mensageiro = "'".Yii::$app->user->identity->id."'";
$js = <<<JS
    $($js_botao).on('click', function() {
        $.ajax({
            method: "POST",
            url: $url,
            data: {
                'Mensagem[texto]': $($js_caixa).val(),
                'Mensagem[usuario_id]': $mensageiro,
                'Mensagem[oficio_id]': $id
            }
        }).done(function(returno) {
            $($js_caixa).val("");
            $($js_return).append(returno + "<br>");
        });
    });
JS;
$this->registerJs($js);
?>
