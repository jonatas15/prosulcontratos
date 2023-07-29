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

    #Globais ou quase
    $contrato = Contrato::findOne(['id' => 1]);
    $empreendimentos = Empreendimento::find()->all();
    $groups = Impc::find()->select('produto, count(id) as contaservicos')->groupBy('produto')->orderBy([
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
            'title' => "Novo Impacto",
            'options' => [
                'id' => 'cadastrar-novo-impacto',
                'tabindex' => false,
            ],
            'bodyOptions' => [
                'class' => 'bg-white',
            ],
            'size' => 'modal-md',
            'toggleButton' => [
                'label' => '<i class="bi bi-card-list"></i> Novo Impacto',
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
                <div class="col-md-12"><?= $form->field($novoimpacto, 'numeroitem')->textInput(['maxlength' => true]) ?></div>
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
        'name' => $emp->titulo, 'y' => $countaprodutos, 'url' => $emp->id
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
    foreach ($groups as $k => $grp) {
        // $label = mb_strimwidth($grp->produto,0,20,'...');
        $servicos_do_grupo = Impc::findAll([
            'produto' => $grp->produto
        ]);
        $impactos_em_todos_empreendimentos = 0;
        foreach ($servicos_do_grupo as $servico) {
            foreach($servico->impactoEmpreendimentos as $empimp) {
                $impactos_em_todos_empreendimentos += $empimp->impactos;
            }
        }
        array_push($graph_grupos, [
            'name' => $grp->produto, 'y' => $impactos_em_todos_empreendimentos, 'url' => $k
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
// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
//  echo $_REQUEST;
?>
<div class="row">
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
    <div class="col-md-5">
        <?= Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 300
                ],
                'title' => ['text' => 'Quantitativos nos Serviços, Empreendimento'],
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
                                        }
                                    }).done(function( msg ) {
                                        // console.log( msg );
                                        chartxxxx.series[0].setData(msg);
                                    });
                                    chartxxxx.setTitle({text: this.options.name + "<br>" + this.options.y + " quantitativos"});
                                    this.options.color = "red";
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
    <div id="visitas">
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
    </div>
    <div class="col-md-7">
        <div class="row px-2 py-2">
        <?php
            $itemsAcordion = [];
            foreach ($groups as $k => $gr):
                // echo '<div class="col-12">';
                // echo $gr->produto;
                // echo '</div>';
                $graph_quantidades_grupo = [];
                $graph_empreendimentos_grupo = [];
                $contentItem = '<div class="row">';
                foreach ($dataProvider->getModels() as $impacto):
                    if($impacto->produto == $gr->produto):
                        $contentItem .= '<div class="col-md-4">';
                        $contentItem .= '<div class="card my-1">';
                        $contentItem .= "<h6 class='text-center pt-2 pb-2 bg-primary text-white'>$impacto->numeroitem</h6>";
                        $contentItem .= $this->render('/impacto/view', [
                            'id' => $impacto->id,
                            'model' => $impacto
                        ]);
                        $contentItem .= '</div>';
                        $contentItem .= '</div>';
                        // $impactos_emp = 0;
                        // foreach($impacto->impactoEmpreendimentos as $kkk => $item) {
                        //     $impactos_emp += $item->impactos;
                        //     array_push($graph_empreendimentos_grupo, [
                        //         'name' => $item->empreendimento->titulo, 'y' => $item->impactos, 'url' => ''
                        //     ]);
                        // }
                        $somas_array_empreendimento = [];
                        // foreach ($impacto->impactoEmpreendimentos as $kk => $vv) {
                        //     foreach ($empreendimentos as $kkk => $vvv) {
                        //         if ($vvv)
                        //     }
                        //     array_push($somas_array_empreendimento [

                        //     ]);
                        // }
                    endif;

                endforeach;
                foreach ($empreendimentos as $emp) {
                    $impactosdogrupo = Impc::find()->where([
                        'produto' => $gr->produto
                    ])->all();
                    $impactos_emp = 0;
                    foreach ($impactosdogrupo as $impcatodogrupo) {
                        foreach ($impcatodogrupo->impactoEmpreendimentos as $ie) {
                            if ($ie->empreendimento_id == $emp->id) {
                                $impactos_emp += $ie->impactos;
                            }
                        }
                    }
                    array_push($graph_empreendimentos_grupo, [
                        'name' => $emp->titulo, 'y' => $impactos_emp, 'url' => ''
                    ]);
                }
                $contentItem .= '<div class="col-md-12">';
                $contentItem .= '<div class="card my-1">';
                $contentItem .= Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'column'
                        ],
                        'title' => ['text' => $gr->produto.' por <br>Empreendimentos'],
                        'yAxis' => [
                            'title' => ['text' => 'Impactos']
                        ],
                        'xAxis' => [
                            'type' => 'category'
                        ],
                        'series' =>  [
                            [
                                'name' => 'Impactos',
                                "cursor" => "zoom",
                                'colorByPoint' => false,
                                'data' => $graph_empreendimentos_grupo,
                                'showInLegend' => false,
                                'dataLabels' => [
                                    'enabled' => false,
                                ],
                            ],
                        ],
                    ]
                ]);
                $contentItem .= '</div>';
                $contentItem .= '</div>';
                // echo '<pre>';
                // print_r($graph_empreendimentos_grupo);
                // echo '</pre>';
                $contentItem .= "</div>";
                array_push($itemsAcordion, [
                    'label' => "♻️ $gr->produto",
                    'content' => $contentItem,
                    'clientOptions' => [
                        'active' => 0
                    ],
                    'options' => [
                        'id' => 'item_'.$k
                    ]
                ]);

            endforeach;
            echo Accordion::widget([
                'items' => $itemsAcordion
            ]);
        ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    const chartxxxx = Highcharts.chart('visitas', {
        chart: {
            type: 'pie'
        },
        series: [{
            point: {
                events: {
                    click: function(){
                        // $("#por_rv").val(this.options.url);
                        // $("#form-pesquisa-produto").submit();
                        console.log("foi");
                        
                        $(".accordion-item").children(".collapse").removeClass("show");
                        $(".accordion-item").children(".accordion-header").children("h5").children(".accordion-button").addClass("collapsed");

                        $("#item_"+this.options.url).children(".collapse").toggleClass("show");
                        $("#item_"+this.options.url).children(".accordion-header").children("h5").children(".accordion-button").toggleClass("collapsed");
                    
                    }
                }
                
            },
            data: [{"name":"03. ESTUDOS DE LEVANTAMENTO DE FAUNA","y":3,"url":""},{"name":"05. ESTUDOS DOS BENS CULTURAIS ACAUTELADOS","y":42,"url":""},{"name":"09. ESTUDO DE IMPACTO AMBIENTAL (EIA)","y":6,"url":""},{"name":"12. PLANO B\u00c1SICO AMBIENTAL (PBA)","y":1,"url":""},{"name":"13. OBTEN\u00c7\u00c3O DA ASV","y":1,"url":""},{"name":"14. VIAGENS","y":168,"url":""}]
        }]
    });
JS;
$this->registerJs($script);
?>
<?php Pjax::end(); ?>
