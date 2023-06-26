<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Entrar no Sistema';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h3><?= Html::encode($this->title) ?></h3>
    
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12">
            <div class="row">
                <!-- <div class="col-md-8"></div> -->
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-5">
                            <img style="width:100%" src="<?=Yii::$app->homeUrl.'logo/';?>logoprosul.jpg" alt="">
                        </div>
                        <div class="col-md-7">
                            <img style="width:100%" src="<?=Yii::$app->homeUrl.'logo/';?>dnit.jpg" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <br />
                    </div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'col-lg-12 col-form-label mr-lg-3'],
                            'inputOptions' => ['class' => 'col-lg-3 form-control'],
                            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Login do Usuário"); ?>

                    <?= $form->field($model, 'password')->passwordInput()->label("Senha"); ?>

                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])->label("Lembrar-me"); ?>

                    <div class="form-group">
                        <div>
                            <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <!-- <div style="color:#999;">
                        Você  <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
                    </div> -->

                </div>
            </div>
        </div>
    </div>
</div>
