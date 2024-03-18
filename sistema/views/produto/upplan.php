<?php 
    use app\models\Empreendimento;
    use app\models\Ordensdeservico;
    use app\models\Produto;
    use app\models\Revisao;
    use yii\helpers\ArrayHelper;

    $empreendimentos  = ArrayHelper::map(Empreendimento::find()->where([
        'contrato_id' => 2
    ])->all(), 'id', 'titulo');

    foreach ($empreendimentos as $emp) {
        echo '<br>'.$emp;
    }

    echo '<hr>';

    $oss  = ArrayHelper::map(Ordensdeservico::find()->where([
        'contrato_id' => 2
    ])->all(), 'id', 'titulo');

    foreach ($oss as $os) {
        echo '<br>'.$os;
    }

    echo '<hr>';


    $dados = [];
    if (($handle = fopen("produtos_lote_a_17mar2024.csv", "r")) !== false) {
        while (($linha = fgetcsv($handle, 1000, ";")) !== false) {
            // $arr = explode(';', $linha);
            array_push($dados, $linha);
        }
        fclose($handle);
    }
 ?>
 <div class="row">
     <div class="col-md-12">
         <?php 
            // echo '<pre>';
            // print_r($dados);
            // echo '</pre>';
            foreach ($dados as $key => $linha) {
                echo '<ul>';
                $produto = new Produto();
                $rev_1 = new Revisao();
                $rev_2 = new Revisao();
                $rev_3 = new Revisao();
                foreach ($linha as $k => $v) {
                    if ($k == 1) {
                        $verifica_os = Ordensdeservico::findAll([
                            'titulo' => $v,
                            'contrato_id' => 2
                        ]);
                        if(count($verifica_os) == 0) {
                            $nova_os = new Ordensdeservico();
                            $nova_os->titulo = $v;
                            $nova_os->contrato_id = 2;
                            $nova_os->save();
                        }
                    }
                    if ($k < 6 or $k >= 18) {
                        $empreendimento = Empreendimento::find()->where(['titulo' => $v, 'contrato_id' => 2])->one();
                        $ordemdeservico = Ordensdeservico::find()->where(['titulo' => $v, 'contrato_id' => 2])->one();
                        
                        switch ((int)$k) {
                            case 0: $produto->empreendimento_id = $empreendimento->id; break;
                            case 1: $produto->ordensdeservico_id = $ordemdeservico->id; break;
                            case 2: $produto->subproduto = $v; break;
                            case 3: $produto->servico = $v; break;
                            case 4: $produto->entrega = $v; break;
                            case 5: $produto->data_entrega = $this->context->dataprobanco($v); break;
                            case 18: $produto->aprov_data = $this->context->dataprobanco($v); break;
                            case 19: $produto->aprov_tempo_total = $v; break;
                            case 20: $produto->aprov_versao = $v; break;
                            case 21: $produto->diretorio_texto = $v; break;
                        }
                        echo "<li>$k - $v</li>";

                        

                    } else {
                        if ($k >= 6 and $k < 10 and $v != "") {
                            ## Nova rev:
                            
                            switch ((int)$k) {
                                case 6: $rev_1->data = $this->context->dataprobanco($v); break;
                                case 7: $rev_1->tempo_ultima_etapa = $v; break;
                                case 8: $rev_1->responsavel = $v; break;
                                case 9: $rev_1->status = ($v == 'Aprovado com ajustes' ? 'Em andamento' : $v); break;
                            }
                            ## Campos nova Rev 01:
                            echo '<ul>';
                            echo "<li>$k - $v</li>";
                            echo '</ul>';
                        }
                        elseif ($k >= 10 and $k < 14 and $v != "") {
                            ## Nova rev:
                            
                            switch ((int)$k) {
                                case 10: $rev_2->data = $this->context->dataprobanco($v); break;
                                case 11: $rev_2->tempo_ultima_etapa = $v; break;
                                case 12: $rev_2->responsavel = $v; break;
                                case 13: $rev_2->status = ($v == 'Aprovado com ajustes' ? 'Em andamento' : $v); break;
                            }
                            ## Campos nova Rev 02:
                            echo '<ul>';
                            echo "<li>$k - $v</li>";
                            echo '</ul>';
                        }
                        elseif ($k >= 14 and $k < 18 and $v != "") {
                            ## Nova rev:
                            
                            switch ((int)$k) {
                                case 14: $rev_3->data = $this->context->dataprobanco($v); break;
                                case 15: $rev_3->tempo_ultima_etapa = $v; break;
                                case 16: $rev_3->responsavel = $v; break;
                                case 17: $rev_3->status = ($v == 'Aprovado com ajustes' ? 'Em andamento' : $v); break;
                            }
                            ## Campos nova Rev 03:
                            echo '<ul>';
                            echo "<li>$k - $v</li>";
                            echo '</ul>';
                        }
                        // echo '<br>';
                    }

                }
                // Novo Produto:
                $produto->contrato_id = 2;
                // $produto->save();
                // Revisões
                if ($produto->save()) {
                    if ($rev_1->data != '') {
                        $rev_1->produto_id = $produto->id;
                        $rev_1->titulo = 'Rev 01';
                        $rev_1->save();
                    }
                    if ($rev_2->data != '') {
                        $rev_2->produto_id = $produto->id;
                        $rev_2->titulo = 'Rev 02';
                        $rev_2->save();
                    }
                    if ($rev_3->data != '') {
                        $rev_3->produto_id = $produto->id;
                        $rev_3->titulo = 'Rev 03';
                        $rev_3->save();
                    }
                        
                    echo '<br> Certo... '.$produto->id;
                } else {
                    echo '<br> Algo errado... '.$produto->id;
                    echo '<br> $produto->empreendimento_i: '. $produto->empreendimento_id;
                    echo '<br> $produto->ordensdeservico_id: '. $produto->ordensdeservico_id;
                    echo '<pre>'; 
                    print_r($produto->attributes);
                    echo '</pre>';
                }
                echo '</ul>';
                
            }

        ?>
    </div>
 </div>