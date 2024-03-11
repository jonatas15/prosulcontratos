<?php 
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

$produtos = \app\models\Produto::find()->where([
    'empreendimento_id' => $empreendimento_id
])->all();
    
$lista_servicos = ArrayHelper::map($produtos, 'servico', 'servico');

echo '</br>';
echo '<div class="row">';
echo '<div class="col-md-2" style="text-align: right">';
echo '<label class="form-label"><strong>Filtrar por Serviço | Produto:</strong></label>';
echo '</div>';
echo '<div class="col-md-9">';
echo '<select class="select_servico_produto form-control" onchange="
    $(\'#produtosearch-servico\').val($(this).val());
    $(\'#produtosearch-empreendimento_id\').val('.$empreendimento_id.');
    $(\'#form-pesquisa-produto\').submit();
">';

echo '<option value="">Selecione</option>';
// $radios_servicos = "";
foreach ($lista_servicos as $serv) {
    echo '<option value="'.$serv.'">'.$serv.'</option>';
    // $radios_servicos .= "
    // <label for=\"check-hoje-produto\" style=\"padding:1%\">
    //     <input type=\"radio\" name=\"ProdutoSearch[$serv]\" value=\"check-hoje\" id=\"check-hoje-produto_".$serv."\">
    //     $serv
    // </label>
    // ";
}
echo '</select>';
echo '</div>';
echo '</div>';
echo '</br>';
?>
<!-- <div class="col-md-12">
    <label class="control-label summary">Pastas</label><br>
    <?php //=$radios_servicos?>
</div> -->
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => 'Início',
            'lastPageLabel'  => 'Fim',
            'class' => 'yii\bootstrap5\LinkPager'
        ],
        'columns' => [
            // [
            //     'attribute' => 'id',
            //     'headerOptions' => [
            //         'width' => '3%'
            //     ]
            // ],
            // [
            //     'attribute' => 'empreendimento_id',
            //     'format' => 'raw',
            //     'value' => function($data) {
            //         // return $this->render('_empreendimento', [
            //         //     'id' => $data->empreendimento_id
            //         // ]);
            //         return $data->empreendimento->titulo;
            //     },
            //     'headerOptions' => [
            //         'width' => '5%'
            //     ]
            // ],
            'servico',
            'subproduto',
            [
                'attribute' => 'numero',
                'headerOptions' => [
                    'width' => '3%'
                ],
                'value' => function($data) {
                    $return = "";
                    foreach($data->revisaos as $rv) {
                        if ($rv->numero_sei) {
                            $return .= '<br>'.$rv->titulo.' <strong>SEI: '.$rv->numero_sei.'</strong>';
                        }
                    }
                    return $return;
                },
                'format' => 'raw',
            ],
            // [
            //     'attribute' => 'ordensdeservico_id',
            //     'format' => 'raw',
            //     'value' => function($data) {
            //         return $this->render('_os', [
            //             'id' => $data->ordensdeservico_id
            //         ]);
            //     },
            //     'headerOptions' => [
            //         'width' => '5%'
            //     ]
            // ],
            // [
                //     'attribute' => 'datacadastro',
            //     'value' => function($data) {
            //         return date('d/m/Y', strtotime($data->datacadastro));
            //     }
            // ],
            [
                'attribute' => 'data_entrega',
                'value' => function($data) {
                    return $data->data_entrega ? date('d/m/Y', strtotime($data->data_entrega)) : '';
                }
            ],
            [
                'attribute' => 'aprov_data',
                'value' => function($data) {
                    return $data->aprov_data ? date('d/m/Y', strtotime($data->aprov_data)) : '';
                }
            ],
            // 'fase',
            // 'aprov_versao',
            [
                'attribute' => 'fase',
                'format' => 'raw',
                'headerOptions' => [
                    'width' => '8%'
                ],
                'value' => function($data) {
                    switch ($data->fase) {
                        case 'Em andamento': $faseada = "<b class='text-warning'>$data->fase</b>"; break;
                        case 'Aprovado': $faseada = "<b class='text-success'>$data->fase</b>"; break;
                        case 'Reprovado': $faseada = "<b class='text-danger'>$data->fase</b>"; break;
                    }        
                    return "<center>$faseada</center><br>".
                        "<center>[ $data->aprov_versao ]</center>";
                }
            ],
            [
                'attribute' => 'diretorio_texto',
                'format' => 'raw',
                'value' => function($data) {
                    // return '<a class="btn btn-link" target="_blank" href="'.$data->link_diretorio.'">'.$data->diretorio.'</a>';
                    if ($data->diretorio_texto != "") {
                        return '<a class="btn btn-link" target="_blank" href="'.$data->diretorio_link.'" 
                        alt="'.$data->diretorio_texto.'"
                        title="'.$data->diretorio_texto.'"
                        >Acessar</a>';
                    }
                    // return $data->emprrendimento_desc;
                }
            ],
            [
                'attribute' => 'id',
                'header' => 'Detalhes',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'format' => 'raw',
                'value' => function($data) {        
                    return '<center>'.$this->render('detalhes', [
                        'id' => $data->id
                    ]).'</center>';
                }
            ],
            [
                'attribute' => 'id',
                'header' => 'Revisões',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'format' => 'raw',
                'value' => function($data) { 
                    $count_revisoes = \app\models\Revisao::find()->where([
                        'produto_id' => $data->id
                    ])->count();       
                    return '<center>'.
                    "<a class='btn btn-primary' href='".Yii::$app->homeUrl."produto/update?id=$data->id&abativa=reviews' target=''>
                    📋 $count_revisoes)
                    </a>".
                    '</center>';
                }
            ],
            [
                'attribute' => 'id',
                'header' => 'Docs',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'format' => 'raw',
                'value' => function($data) {
                    return '<center>'.
                    // $this->render('_docs', [
                    //     'oficio_id' => $data->id
                    //     ])
                    // }
                    "<a class='btn btn-primary' href='".Yii::$app->homeUrl."produto/update?id=$data->id&abativa=arquivos' target=''>
                        <i class='bi bi-filetype-doc'></i>
                    </a>".
                    '</center>';
                },
                'visible' => in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor']) ? true : false
            ],
            [
                'header' => 'Editar',
                'format' => 'raw',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'value' => function($data) {
                    return '<a href="'.Yii::$app->homeUrl.'produto/update?id='.$data->id.'" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                },
                'visible' => in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor']) ? true : false
            ],
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Oficio $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],
        ],
    ]); ?>