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

    #Globais ou quase
    $contrato = Contrato::findOne(['id' => 1]);
    $empreendimentos = Empreendimento::find()->all();
    $groups = Impc::find()->select('produto, count(id) as contaservicos')->groupBy('produto')->all();
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
<?php
    $graph_empreendimentos = [];
    # Por Empreendimentos
    foreach ($empreendimentos as $emp) {
        $countaprodutos = 0;
        foreach($contrato->impacto as $item) {
            $temqueter = ImpcEmp::find()->where([
                'impacto_id' => $item->id,
                'empreendimento_id' => $emp->id
            ])->one();
            $countaprodutos += (int)$temqueter->impactos;
        }
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
    foreach ($groups as $grp) {
        array_push($graph_grupos, [
            'name' => $grp->produto, 'y' => $grp->contaservicos, 'url' => ''
        ]);
    }

    $arr_todos = [];
    foreach ($contrato->impacto as $impct) {
        // array_push($arr_todos, [
        //     'name' => $impct->servico, 'y' => 1, 'url' => ''
        // ]);
        // Modal::begin([
        //     'title' => "Novo Impacto",
        //     'options' => [
        //         'id' => 'detalhes-impacto-'.$impct->id,
        //         'tabindex' => false,
        //     ],
        //     'bodyOptions' => [
        //         'class' => 'bg-white',
        //     ],
        //     'size' => 'modal-md',
        //     'toggleButton' => [
        //         'label' => '<i class="bi bi-card-list"></i> Novo Impacto',
        //         'class' => 'btn btn-primary text-white float-right width-200'
        //     ],
        // ]);
        // $impct->servico;
        // Modal::end();
        // Html::link
    }

    // echo '<pre>';
    // print_r($graph_quantidades);
    // echo '</pre>';
?>
<div class="row">
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
                                "click" => new JsExpression('function(){
                                    $("#produtosearch-empreendimento_id").val(this.options.url);
                                    $("#form-pesquisa-produto").submit();
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
                        "point" => [
                            "events" => [
                                "click" => new JsExpression('function(){
                                    $("#produtosearch-empreendimento_id").val(this.options.url);
                                    $("#form-pesquisa-produto").submit();
                                }')
                            ],
                        ],
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
    <div class="col-md-3">
        <?= Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'pie'
                    ],
                    'title' => ['text' => 'Grupos por Qtd. de Serviços'],
                    'yAxis' => [
                        'title' => ['text' => 'Versão']
                    ],
                    'series' =>  [
                        [
                            'name' => 'Serviços',
                            "cursor" => "pointer",
                            // "point" => [
                            //     "events" => [
                            //         "click" => new JsExpression('function(){
                            //             $("#por_rv").val(this.options.url);
                            //             $("#form-pesquisa-produto").submit();
                            //         }')
                            //     ],
                            // ],
                            'data' => $graph_grupos,
                            'showInLegend' => true,
                            'dataLabels' => [
                                'enabled' => false,
                            ],
                        ],
                    ],
                ]
            ]);
        ?>
    </div>
</div>
<div class="clearfix">
    <br />
</div>
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
    
    
    
    echo '<table class="table table-striped table-bordered detail-view">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Item</th>';
    // echo '<th>Grupo</th>';
    echo '<th>Descrição do serviço</th>';
    echo '<th>Unidades</th>';
    echo '<th>Quant. A</th>';
    $conta_emps = 8;
    foreach ($empreendimentos as $emp) {
        echo "<th>$emp->titulo</th>";
        $conta_emps++;
    }
    echo '<th>Quant. Utilizada</th>';
    echo '<th>Quant. restante real</th>';
    echo '<th>Quant. restante</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $i = 1;
    $j = 1;
    $k = 1;
    $l = 1;
    foreach ($groups as $kv):
        // echo $kv->produto.'<br>';
        $impactosrow = Impc::find()->where([ 'produto' => $kv->produto ])->all();
        echo "<tr class='mx-5'>
                <td class='bg-primary text-white text-left text-strong px-2 py-1'>$k</td>
                <td class='bg-primary text-white text-left text-strong px-2 py-1' colspan=\"$conta_emps\">$kv->produto</td>
            </tr>";
    // }
        foreach ($impactosrow as $impacto) {
            echo '<tr>';
            echo '<td>';
                echo Editable::widget([
                    'id' => "altera_campo_numeroitem_$impacto->id", 
                    'name' => "altera_campo_$impacto->id", 
                    'asPopover' => true,
                    'value' => $impacto->numeroitem,
                    'header' => 'Numeração',
                    'size'=>'md',
                    'options' => [
                        'class'=>'form-control'
                    ],
                    'formOptions' => [
                        'action' => [
                            'alteraimpactocampo',
                            'campo' => 'numeroitem',
                            'id' => $impacto->id
                        ]
                    ]
                ]);
            echo '</td>';
            /** GRUPO
            echo '<td>';
                echo Editable::widget([
                    'id' => "altera_campo_produto_$impacto->id", 
                    'name' => "altera_campo_$impacto->id", 
                    'asPopover' => true,
                    'value' => $impacto->produto,
                    'header' => 'Grupo ou Categoria',
                    'size'=>'md',
                    'options' => [
                        'class'=>'form-control'
                    ],
                    'formOptions' => [
                        'action' => [
                            'alteraimpactocampo',
                            'campo' => 'produto',
                            'id' => $impacto->id
                        ]
                    ]
                ]);
            echo '</td>';
             */
            // A definir se ficará ou não Conectado ao Módulo Produtos ================================= 
            echo '<td>';
            // echo $impacto->produto0->subproduto;
            echo $impacto->servico;
            echo '</td>';
            // A definir se ficará ou não Conectado ao Módulo Produtos ================================= 
            echo '<td>';
                echo Editable::widget([
                    'id' => "altera_unidade_$impacto->id", 
                    'name' => "altera_campo_$impacto->id", 
                    'asPopover' => true,
                    'value' => $impacto->unidade,
                    'header' => 'Grupo ou Categoria',
                    'size'=>'md',
                    'options' => [
                        'class'=>'form-control', 
                        'placeholder'=>'Impactos:',
                    ],
                    'formOptions' => [
                        'action' => [
                            'alteraimpactocampo',
                            'campo' => 'unidade',
                            'id' => $impacto->id
                        ]
                    ]
                ]);
            echo '</td>';
            echo '<td class="">';
                echo Editable::widget([
                    'id' => "altera_campo_quantidade_a_$impacto->id", 
                    'name' => "altera_campo_$impacto->id", 
                    'asPopover' => true,
                    'value' => $impacto->quantidade_a,
                    'header' => 'Quantidade (A)',
                    'size'=>'md',
                    'options' => [
                        'class'=>'form-control'
                    ],
                    'formOptions' => [
                        'action' => [
                            'alteraimpactocampo',
                            'campo' => 'quantidade_a',
                            'id' => $impacto->id
                        ]
                    ]
                ]);
            echo '</td>';
            
            
            foreach ($empreendimentos as $emp) {
                $impactos_por_empreendimento = ImpcEmp::find()->where([
                    'empreendimento_id' => $emp->id,
                    'impacto_id' => $impacto->id
                ])->one();
                // echo '<td onclick="$(this).toggleClass(\'bg-warning\')" class="text-center">';
                echo '<td class="text-center '.($impactos_por_empreendimento->impactos > 0 ? 'bg-registral':'').'">';
                echo '<!--';
                echo $impactos_por_empreendimento->impacto_id;
                echo ' . ';
                echo $impactos_por_empreendimento->empreendimento_id;
                echo '-->';
                echo Editable::widget([
                    'id' => 'alteraimpacto_'."{$impactos_por_empreendimento->impacto_id}_{$impactos_por_empreendimento->empreendimento_id}", 
                    'name' => 'alteraimpacto_'."{$impactos_por_empreendimento->impacto_id}_{$impactos_por_empreendimento->empreendimento_id}", 
                    'asPopover' => true,
                    'value' => $impactos_por_empreendimento->impactos,
                    'header' => 'Impactos em '.$emp->titulo,
                    'size'=>'md',
                    'options' => [
                        'class'=>'form-control', 
                        'placeholder'=>'Impactos:',
                    ],
                    'formOptions' => [
                        'action' => [
                            'alteraimpacto',
                            'impacto_id' => $impactos_por_empreendimento->impacto_id,
                            'empreendimento_id' => $impactos_por_empreendimento->empreendimento_id
                        ]
                    ]
                ]).'<br><sub class="text-gray">'.$emp->titulo.'</sub>';
                echo '</td>';
                /**
                    Aqui cria uma relação de impactos no empreendimento para cada
                    produto
                    $impcemp = new ImpcEmp();
                    $impcemp->impacto_id = $impact->id;
                    $impcemp->empreendimento_id = $emp->id;
                    $impcemp->save();
                **/
            }

            echo '<td class="">';
                echo Editable::widget([
                    'id' => "altera_quantidadeUtilizada_$impacto->id", 
                    'name' => "altera_campo_$impacto->id", 
                    'asPopover' => true,
                    'value' => $impacto->quantidade_utilizada,
                    'header' => 'Quant. Utilizada',
                    'size'=>'md',
                    'options' => [
                        'class'=>'form-control', 
                        'placeholder'=>'Impactos',
                    ],
                    'formOptions' => [
                        'action' => [
                            'alteraimpactocampo',
                            'campo' => 'quantidade_utilizada',
                            'id' => $impacto->id
                        ]
                    ]
                ]);
            echo '</td>';
            echo '<td>';
                echo Editable::widget([
                    'id' => "altera_quantidade_restante_real_$impacto->id", 
                    'name' => "altera_campo_$impacto->id", 
                    'asPopover' => true,
                    'value' => $impacto->qt_restante_real,
                    'header' => 'Quant. Restante Real',
                    'size'=>'md',
                    'options' => [
                        'class'=>'form-control', 
                        'placeholder'=>'Impactos',
                    ],
                    'formOptions' => [
                        'action' => [
                            'alteraimpactocampo',
                            'campo' => 'qt_restante_real',
                            'id' => $impacto->id
                        ]
                    ]
                ]);
            echo '</td>';
            echo '<td>';
                echo Editable::widget([
                    'id' => "altera_quantidade_restante_$impacto->id", 
                    'name' => "altera_campo_$impacto->id", 
                    'asPopover' => true,
                    'value' => $impacto->qt_restante,
                    'header' => 'Quant. Restante',
                    'size'=>'md',
                    'options' => [
                        'class'=>'form-control', 
                        'placeholder'=>'Impactos',
                    ],
                    'formOptions' => [
                        'action' => [
                            'alteraimpactocampo',
                            'campo' => 'qt_restante',
                            'id' => $impacto->id
                        ]
                    ]
                ]);
            echo '</td>';
            $j++;
            echo '</tr>';
            # INTERROMPE NA PRIMEIRA RONDA
            // break;
        }
        $k++;
    endforeach;
    echo '</tbody>';
    echo '</table>';

    // Cria as relações cruzadas... e é isso...

    // foreach (Impc::find()->all() as $ximpacto) {
    //     foreach ($empreendimentos as $xempreendimento) {
    //         $relacao = new ImpcEmp();
    //         $relacao->impacto_id = $ximpacto->id;
    //         $relacao->empreendimento_id = $xempreendimento->id;
    //         $relacao->impactos = 0;
    //         if($relacao->save()) {
    //             echo 'Ok <br>';
    //         } else {
    //             echo 'Não Ok <br>';
    //         }
    //     }
    // }


?>