<?php 
    use app\models\Impacto as Impc;
    use app\models\Contrato;
    use app\models\Produto;
    use app\models\Empreendimento;
    use app\models\ImpactoEmpreendimento as ImpcEmp;

    use kartik\editable\Editable;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\bootstrap5\Modal;

    use yii\web\JsExpression;
    use miloschuman\highcharts\Highcharts;
    use yii\bootstrap5\Accordion;
    use yii\widgets\Pjax;

    // CONTRATO
    // $contrato_id = 1;

    #Globais ou quase
    $contrato = Contrato::findOne(['id' => $contrato_id]);
    $empreendimentos = Empreendimento::find()->where([
        'contrato_id' => $contrato_id
    ])->all();
    $groups = Impc::find()->select('produto, count(id) as contaservicos')->where([
        'contrato_id' => $contrato_id
    ])->groupBy('produto')->orderBy([
        'produto' => SORT_ASC
    ])->all();
?>
<style>
    .celula-ativa {
        background-color: red;
    }
    .bg-registral {
        background-color: lightgray !important;
    }
    .bg-registral sub {
        color: blue !important;
    }
</style>
<div class="row mb-3 mt-3">
    <div class="col-8">
        <h3><strong><i class="bi bi-card-list"></i> Impactos Contratuais</strong></h3>
    </div>
    <div class="col-4">
        <?php
        Modal::begin([
            'title' => "Novo Registro",
            'options' => [
                'id' => 'cadastrar-novo-impacto',
                'tabindex' => false,
            ],
            'bodyOptions' => [
                'class' => 'bg-white',
            ],
            'size' => 'modal-lg',
            'toggleButton' => [
                'label' => '<i class="bi bi-card-list"></i> Novo Registro',
                'class' => 'btn btn-primary text-white float-right width-200'
            ],
        ]);
        ?>
        <div class="impacto-create">
            <?php $novoimpacto = new Impc(); ?>
            <?php $form = ActiveForm::begin([
                'action' => 'novoimpacto'
            ]); ?>
            <div class="row">
                <div class="col-md-12"><?= $form->field($novoimpacto, 'contrato_id')->hiddenInput([
                    'value' => $contrato->id,
                    'maxlength' => true,
                ])->label(false) ?></div>
                <div class="col-md-12"><?= $form->field($novoimpacto, 'produto')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-12"><?= $form->field($novoimpacto, 'servico')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-5"><?= $form->field($novoimpacto, 'unidade')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-4"><?= $form->field($novoimpacto, 'numeroitem')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($novoimpacto, 'quantidade_a')->textInput([
                    'maxlength' => true,
                    'type' => 'number',
                    'value' => 0
                ]) ?></div>
                <!-- Empreendimentos -->
                <div class="col-md-12 py-2">
                    <div class="card px-2 py-2 bg-registral">
                        <h5 class="text-center">Empreendimentos</h5>
                        <div class="row">
                            <?php foreach ($empreendimentos as $empr): ?>
                                <?php $arr_titulo = explode(" ", $empr->titulo) ?>
                                <div class="col-md-3 text-center my-2">
                                    <?="<label class='control-label'><b>$arr_titulo[0] $arr_titulo[1] $arr_titulo[2]</b></label>";?>
                                    <?="<input class='form-control' type='number' name='Empreendimento[$empr->id]' value='0' />";?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- Empreendimentos -->
                <div class="col-md-4"><?= $form->field($novoimpacto, 'quantidade_utilizada')->textInput([
                    'maxlength' => true,
                    'type' => 'number',
                    'value' => 0,
                ]) ?></div>
                <div class="col-md-4"><?= $form->field($novoimpacto, 'qt_restante_real')->textInput([
                    'maxlength' => true,
                    'type' => 'number',
                    'value' => 0,
                ]) ?></div>
                <div class="col-md-4"><?= $form->field($novoimpacto, 'qt_restante')->textInput([
                    'maxlength' => true,
                    'type' => 'number',
                    'value' => 0,
                ]) ?></div>
                <div class="col-md-12">
                    <button class="btn btn-success float-right" type="submit">Salvar</button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?php Modal::end(); ?>
    </div>
</div>
<?php
    $graph_empreendimentos = [];
    # Por Empreendimentos
    foreach ($empreendimentos as $emp) {
        $countaprodutos = 0;
        $countregistros = 0;
        foreach($contrato->impacto as $item) {
            $temqueter = ImpcEmp::find()->where([
                'impacto_id' => $item->id,
                'empreendimento_id' => $emp->id
            ])->one();
            $countaprodutos += (int)$temqueter->impactos;
            if ($temqueter->impactos > 0) {
                $countregistros += 1;
            }
        }
        // ." <br>[$countregistros registros]"
        array_push($graph_empreendimentos, [
            'name' => $emp->titulo,
            'y' => $countaprodutos,
            'url' => $emp->id
        ]);
    }
    # Por Quantidades
    $graph_quantidades = [];
    $quantidades = [
        'quantidade_a' => 0,
        'quantidade_utilizada' => 0,
        'qt_restante_real' => 0,
        'qt_restante' => 0,
    ];
    foreach ($quantidades as $key => $value) {
        $valor = 0;
        $label = "Valor";
        foreach($contrato->impacto as $chave => $item) {
            $valor += $item->$key;
            $label = Impc::instance()->getAttributeLabel($key);
        }
        array_push($graph_quantidades, [
            'name' => $label, 'y' => $valor, 'url' => ''
        ]);
    }

    $graph_grupos = [];
    // foreach ($groups as $k => $grp) {
    //     // $label = mb_strimwidth($grp->produto,0,20,'...');
    //     $servicos_do_grupo = Impc::findAll([
    //         'produto' => $grp->produto
    //     ]);
    //     $impactos_em_todos_empreendimentos = 0;
    //     foreach ($servicos_do_grupo as $servico) {
    //         foreach($servico->impactoEmpreendimentos as $empimp) {
    //             $impactos_em_todos_empreendimentos += $empimp->impactos;
    //             $empreendimento_id = $empimp->empreendimento_id;
    //         }
    //     }
    //     array_push($graph_grupos, [
    //         'name' => $grp->produto, 'y' => $impactos_em_todos_empreendimentos, 'url' => $k
    //     ]);
    // }


    // TODOS OS SERVICOS
    $graph_servicos = [];
    foreach ($contrato->impacto as $servico) {
        // $label = mb_strimwidth($grp->produto,0,20,'...');
        // $servicos_do_grupo = Impc::findAll([
        //     'produto' => $grp->produto
        // ]);
        $impactos_em_todos_empreendimentos = 0;
        foreach($servico->impactoEmpreendimentos as $empimp) {
            $impactos_em_todos_empreendimentos += $empimp->impactos;
        }
        array_push($graph_servicos, [
            'name' => $servico->servico, 'y' => $impactos_em_todos_empreendimentos, 'url' => $servico->id
        ]);
    }

    // echo '<pre>';
    // print_r($graph_quantidades);
    // echo '</pre>';
?>
<?php Pjax::begin([
    'id' => 'admin-crud-id-impactos', 
    'timeout' => false,
    'enablePushState' => true
]); ?>
<script>
    var contratos = [];
</script>

<?php 
$lista_btn_empreendimentos = "<div class='row my-2'>";
foreach ($empreendimentos as $emp) {    
    $lista_btn_empreendimentos .= "<div class='col my-2'>";
    $lista_btn_empreendimentos .= Html::button($emp->titulo, [ 
        'class' => 'btn btn-primary w-100 btn-seleciona-empreendimento h-100', 
        'emp_id' => $emp->id,
        'emp_titulo' => $emp->titulo
    ]);
    $lista_btn_empreendimentos .= "</div>";
}
$lista_btn_empreendimentos .= "</div><hr>";
// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
//  echo $_REQUEST;
// echo json_encode($graph_grupos);
?>
<div class="row">
    <div class="col-md-7">
        <?= $lista_btn_empreendimentos ?>
    </div>
    <div class="col-md-5">
    <?= Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 250
                    ],
                    'title' => ['text' => 'Quantitativos nos Serviços por Empreendimento'],
                    'yAxis' => [
                        'title' => ['text' => 'Quantitativos']
                    ],
                    'xAxis' => [
                        'type' => 'category'
                    ],
                    'series' =>  [
                        [
                            'name' => 'Quantitativos',
                            "cursor" => "pointer",
                            'colorByPoint' => false,
                            "states" => [
                                "select" => [
                                    "color" => "blue"
                                ]
                            ],
                            'allowPointSelect' => true,
                            "point" => [
                                "events" => [
                                    "click" => new JsExpression('function() {
                                        $.ajax({
                                        method: "POST",
                                            url: "porempreendimento",
                                            data: { 
                                                empreendimento: this.options.url,
                                                contrato_id: '.$contrato_id.',
                                            }
                                        }).done(function( msg ) {
                                            // console.log( msg );
                                            chartxxxx.series[0].setData(msg);
                                            chartservicos.series[0].setData([]);
                                        });
                                        chartxxxx.setTitle({text: "Empreendimento: " + this.options.name + "<br>" + this.options.y + " quantitativos"});
                                        $(".linha-empreendimento").removeClass("bg-warning text-dark");
                                        $(".linha-empreendimento-" + this.options.url).addClass("bg-warning text-dark");
                                        $(".todos-os-grupos").addClass("d-none");
                                    }')
                                ],
                            ],
                            'data' => $graph_empreendimentos,
                            'showInLegend' => false,
                            'dataLabels' => [
                                'enabled' => false,
                            ],
                        ],
                    ],
                ]
            ]);
        ?>
    </div>
    <?php /**
    <div class="col-md-7">
        <?= Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column'
                ],
                'title' => ['text' => 'Por Empreendimento'],
                'yAxis' => [
                    'title' => ['text' => 'Impactos']
                ],
                'xAxis' => [
                    'type' => 'category'
                ],
                'series' =>  [
                    [
                        'name' => 'Impactos',
                        "cursor" => "pointer",
                        'colorByPoint' => false,
                        "point" => [
                            "events" => [
                                "click" => new JsExpression('function() {
                                    $.ajax({
                                    method: "POST",
                                        url: "porempreendimento",
                                        data: { 
                                            empreendimento: this.options.url,
                                        }
                                    }).done(function( msg ) {
                                        console.log( msg );
                                    });
                                }')
                            ],
                        ],
                        'data' => $graph_empreendimentos,
                        'showInLegend' => false,
                        'dataLabels' => [
                            'enabled' => false,
                        ],
                    ],
                ],
            ]
        ]);
        ?>
    </div>
    <div class="col-md-5">
        <?= Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column'
                ],
                'title' => ['text' => 'Por Quantidades Resultantes'],
                'yAxis' => [
                    'title' => ['text' => 'Impactos']
                ],
                'xAxis' => [
                    'type' => 'category'
                ],
                'series' =>  [
                    [
                        'name' => 'Impactos',
                        "cursor" => "pointer",
                        'colorByPoint' => false,
                        // "point" => [
                        //     "events" => [
                        //         "click" => new JsExpression('function(){
                                    
                        //         }'),
                        //         'load' => new JsExpression("function () {
                        //             var series = this.series[0];
                        //             setInterval(function () {
                        //                 $.getJSON('http://url-to-json-file/index.php', function (jsondata) {
                        //                     series.data = JSON.parse(jsondata.cpu);
                        //                 });
                        //             }, 5000);")
                        //     ],
                        // ],
                        'data' => $graph_quantidades,
                        'showInLegend' => false,
                        'dataLabels' => [
                            'enabled' => false,
                        ],
                    ],
                ],
            ]
        ]);
        ?>
    </div>
     */ ?>
     <div class="col-md-7">
        <select name="select-servicos" id="select-servicos" class="form-control fs-5 my-3 text-center"></select>
        <!-- <div class="col-md-12" style="border-radius: 0 !important"> -->
            <!-- <h3 class="text-center">Detalhes dos Serviços</h3><hr> -->
            <!-- <div class="row"> -->
                <?php
                    foreach ($groups as $k => $gr):
                        $contentItem = '<div class="row todos-os-grupos" def="'.$gr->produto.'">';
                        // $contentItem .= "<h5 class='col-md-12'>$gr->produto</h5>";
                        foreach ($dataProvider->getModels() as $impacto):
                            if($impacto->produto == $gr->produto):
                                // style="min-height: 300px !important;"
                                $contentItem .= '<div id="supercard-servico-'.$impacto->id.'" class="col-md-12">';
                                $contentItem .= '<div class="card my-1">';
                                $contentItem .= '<div class="row">';
                                $contentItem .= '<div class="col-md-7">';
                                $contentItem .= "<h6 class='text-center pt-2'>$impacto->numeroitem";
                                $contentItem .= $this->render('/impacto/view', [
                                    'id' => $impacto->id,
                                    'model' => $impacto
                                ]);
                                // botão pra editar
                                $contentItem .= Html::a('<i class="bi bi-pencil-square"></i>', [
                                    'vieweditable',
                                    'id' => $impacto->id,
                                ], ['class' => 'btn w-25 my-2 mx-2 float-right', 'target' => '_blank', 'data-pjax'=>"0"]);
                                $contentItem .= "</h6>";
                                $contentItemTB  = '<h5 class="my-2">Empreendimentos:</h5>';
                                $contentItemTB  .= '<table class="table table-striped table-bordered detail-view my-2 mx-0">';
                                
                                foreach ($impacto->impactoEmpreendimentos as $ie) {
                                    if ($ie->impactos > 0) {
                                        $contentItemTB .= '<tr">';
                                        $contentItemTB .= "<td class='linha-empreendimento linha-empreendimento-".$ie->empreendimento_id."'>{$ie->empreendimento->titulo}</td>";
                                        $contentItemTB .= "<td class='linha-empreendimento linha-empreendimento-".$ie->empreendimento_id."'>{$ie->impactos}</td>";
                                        $contentItemTB .= '</tr>';
                                    }
                                }
                                $contentItemTB .= '</table>';

                                // $contentItem .= Accordion::widget([
                                //     'items' => [
                                //         [
                                //             'label' => 'Ver mais',
                                //             'content' => $contentItemTB
                                //         ]
                                //     ]
                                // ]);
                                $contentItemTB2 = "<table class='table table-striped table-bordered detail-view'>";
                                $contentItemTB2 .= '<tr>';
                                $contentItemTB2 .= "<td>Unidade</td>";
                                $contentItemTB2 .= "<td>$impacto->unidade</td>";
                                $contentItemTB2 .= '</tr>';
                                $quantidades = [
                                    'quantidade_a' => 0,
                                    'quantidade_utilizada' => 0,
                                    'qt_restante_real' => 0,
                                    'qt_restante' => 0,
                                ];
                                foreach ($quantidades as $key => $value) {
                                    $valor = 0;
                                    $label = "Valor";
                                    foreach($impacto as $chave => $item) {
                                        $label = $impacto::instance()->getAttributeLabel($key);
                                        $valor = $impacto->$key;
                                        if ($key == 'qt_restante') {
                                            $valor = $impacto->quantidade_a - $impacto->quantidade_utilizada;
                                        }
                                    }
                                    $vetor = "text-primary";
                                    if ($valor < 0) {
                                        $vetor = "text-danger";
                                    }
                                    $contentItemTB2 .= '<tr>';
                                    $contentItemTB2 .= "<td><strong class='$vetor'>{$label}</strong></td>";
                                    $contentItemTB2 .= "<td><strong class='$vetor'>{$valor}</strong></td>";
                                    $contentItemTB2 .= '</tr>';
                                }
                                $contentItemTB2 .= '</table>';
                                $contentItem .= $contentItemTB2;
                                $contentItem .= '</div>';
                                $contentItem .= '<div class="col-md-5">';
                                $contentItem .= $contentItemTB;
                                $contentItem .= '</div>';
                                $contentItem .= '</div>';
                                $contentItem .= '</div>';
                                $contentItem .= '</div>';
                            endif;
                        endforeach;
                        $contentItem .= '</div>';
                        echo $contentItem;
                    endforeach;
                ?>
            <!-- </div> -->
        <!-- </div> -->
     </div>
    <div class="col-md-5">
        <div class="col-md-12" style="border-radius: 0 !important">
            <!-- <h3 class="text-center">Produtos por Empreendimento</h3><hr> -->
            <div id="visitas"></div>
            <?php /*= Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                    'id' => 'visitas',
                    'options' => [
                        'chart' => [
                            'type' => 'pie',
                            'height' => 500
                        ],
                        'title' => ['text' => 'Grupos por Qtd. de Serviços'],
                        'yAxis' => [
                            'title' => ['text' => 'Versão']
                        ],
                        'xAxis' => [
                            'type' => 'category'
                        ],
                        'series' =>  [
                            [
                                'name' => 'Serviços',
                                "cursor" => "pointer",
                                "point" => [
                                    "events" => [
                                        "click" => new JsExpression('function(){
                                            // $("#por_rv").val(this.options.url);
                                            // $("#form-pesquisa-produto").submit();
                                            // console.log(this.options.url);
                                            
                                            $(".accordion-item").children(".collapse").removeClass("show");
                                            $(".accordion-item").children(".accordion-header").children("h5").children(".accordion-button").addClass("collapsed");

                                            $("#item_"+this.options.url).children(".collapse").toggleClass("show");
                                            $("#item_"+this.options.url).children(".accordion-header").children("h5").children(".accordion-button").toggleClass("collapsed");
                                        
                                        }')
                                    ],
                                ],
                                'data' => $graph_grupos,
                                'showInLegend' => false,
                                'dataLabels' => [
                                    'enabled' => true,
                                    'alignTo' => 'left'
                                ],
                            ],
                        ],
                    ]
                ]);
            */ ?>
            
        </div>
        <div class="col-md-12" style="border-radius: 0 !important">
            <h3 class="text-center">Quantitativos dos Serviços por Produto no Empreendimento</h3><hr>
            <div class="row px-2 py-2" id="servicos_grupo">
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs("var contrato_id = ".$contrato_id); 
$this->registerJs("var inicio_grafico = ".json_encode($graph_grupos)); 
$this->registerJs("var inicio_grafico_servicos = ".json_encode($graph_servicos)); 
$this->registerJs("$('.todos-os-grupos').addClass('d-none');"); 
$script = <<< JS
    Highcharts.setOptions({
        colors: ['#87CEEB', '#87CEFA', '#00BFFF', '#1E90FF', '#4169E1', '#0000FF', '#0000CD', '#00008B', '#483D8B']
    });
    const chartxxxx = Highcharts.chart('visitas', {
        chart: {
            type: 'pie',
            height: 450
        },
        title: {
            text: "Produtos"
        },
        series: [{
            cursor: 'pointer',
            point: {
                events: {
                    click: function(){
                        // $("#por_rv").val(this.options.url);
                        // $("#form-pesquisa-produto").submit();
                        // console.log("foi");
                        $.ajax({
                            method: "POST",
                            url: "porproduto",
                            data: { 
                                produto: this.options.name,
                                empreendimento: this.options.empreendimento
                            }
                        }).done(function( servicos ) {
                            // console.log( servicos );
                            chartservicos.series[0].setData(servicos);
                        });
                        chartservicos.setTitle({text: this.options.name + "<br>" + this.options.y + " quantitativos no Emp. " + this.options.empreendimento_titulo });
                        $('.todos-os-grupos').addClass("d-none");
                        $("[def='"+this.options.name+"']").removeClass("d-none");
                        $("#select-servicos").val(this.options.name);
                        // this.options.color = "red";
                        // $(".accordion-item").children(".collapse").removeClass("show");
                        // $(".accordion-item").children(".accordion-header").children("h5").children(".accordion-button").addClass("collapsed");
                        // $("#item_"+this.options.url).children(".collapse").toggleClass("show");
                        // $("#item_"+this.options.url).children(".accordion-header").children("h5").children(".accordion-button").toggleClass("collapsed");
                    }
                }
            },
            showInLegend: false,
            dataLabels: {
                enabled: true,
                alignTo: 'center'
            },
            data: inicio_grafico
        }]
    });
    const chartservicos = Highcharts.chart('servicos_grupo', {
        chart: {
            type: 'column',
            height: 550
        },
        title: {
            text: "Serviços em..."
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Quantitativos'
            }
        },
        series: [{
            name: 'Quantitativos',
            cursor: 'pointer',
            point: {
                events: {
                    click: function(){
                        // $("#por_rv").val(this.options.url);
                        // $("#form-pesquisa-produto").submit();
                        // console.log("foi");
                        $('#ver-os-detalhes-impacto-' + this.options.url).modal('show');
                        
                    
                    }
                }
                
            },
            data: [],
            showInLegend: false,
            dataLabels: {
                enabled: true,
                alignTo: 'left'
            },

        }],
    });
JS;
$this->registerJs($script);
?>
<?php Pjax::end(); ?>

<?php
// Registro do código JavaScript
$js_dos_botoes = <<< JS
    // Função que será chamada ao clicar no botão
    function performAjaxRequest(empreendimento_id, empreendimento_titulo) {
        $.ajax({
            method: 'POST',
            url: "porempreendimento",
            data: { 
                empreendimento: empreendimento_id,
                contrato_id: contrato_id,
            }
        }).done(function( msg ) {
            // console.log( msg );
            chartxxxx.series[0].setData(msg);
            chartservicos.series[0].setData([]);
        });
        chartxxxx.setTitle({text: "Empreendimento: " + empreendimento_titulo + "<br>"});
        $(".linha-empreendimento").removeClass("bg-warning text-dark");
        $(".linha-empreendimento-" + empreendimento_id).addClass("bg-warning text-dark");
        $(".todos-os-grupos").addClass("d-none");
    }
    $('.btn-seleciona-empreendimento').on('click', function(){
        performAjaxRequest(
            $(this).attr('emp_id'),
            $(this).attr('emp_titulo')
        );
        $("[def='14. VIAGENS']").removeClass("d-none"),
        $.ajax({
            method: "POST",
            url: "porproduto",
            data: { 
                produto: '14. VIAGENS',
                empreendimento: $(this).attr('emp_id')
            }
        }).done(function( servicos ) {
            console.log( servicos );
            chartservicos.setTitle({text: "14. VIAGENS" });
            chartservicos.series[0].setData(servicos);
        });
        $("#select-servicos").val("14. VIAGENS");
    })
    $('.collapse').collapse("hide");
    // Funções de Inicialização:
    $.ajax({
        method: "POST",
        url: "porempreendimento",
        data: { 
            empreendimento: 4,
            contrato_id: 1,
        }
    }).done(function( msg ) {
        // console.log( msg );
        chartxxxx.series[0].setData(msg);
        chartservicos.series[0].setData([]);
        $.each(msg, function( index, value ) {
            $("#select-servicos").append('<option value="'+value.name+'">'+value.name+'</option>');
            $("#select-servicos").val("14. VIAGENS");
        });
    });
    chartxxxx.setTitle({text: "Empreendimento: BR-080"});
    $(".linha-empreendimento").removeClass("bg-warning text-dark");
    $(".linha-empreendimento-4").addClass("bg-warning text-dark");
    $(".todos-os-grupos").addClass("d-none");
    $.ajax({
        method: "POST",
        url: "porproduto",
        data: { 
            produto: '14. VIAGENS',
            empreendimento: 4
        }
    }).done(function( servicos ) {
        console.log( servicos );
        chartservicos.series[0].setData(servicos);
    });
    chartservicos.setTitle({text: "Quantitativos no Emp. BR-080" });
    $('.todos-os-grupos').addClass("d-none");
    $("[def='14. VIAGENS']").removeClass("d-none");
    $("#select-servicos").on('change', function() {
        $.ajax({
            method: "POST",
            url: "porproduto",
            data: { 
                produto: $(this).find(":selected").val(),
                empreendimento: 4
            }
        }).done(function( servicos ) {
            // console.log( servicos );
            chartservicos.series[0].setData(servicos);
        });
        chartservicos.setTitle({text: $(this).val() });
        $('.todos-os-grupos').addClass("d-none");
        $("[def='"+$(this).find(":selected").val()+"']").removeClass("d-none");
    });
JS;

$this->registerJs($js_dos_botoes);

?>
