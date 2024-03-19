<?php 
    use app\models\Empreendimento;
    use app\models\Oficio;
    use yii\helpers\ArrayHelper;
    $contrato_id = 2;

    $empreendimentos  = ArrayHelper::map(Empreendimento::find()->where([
        'contrato_id' => $contrato_id
    ])->all(), 'id', 'titulo');

    foreach ($empreendimentos as $emp) {
        echo '<br>'.$emp;
    }

    echo '<hr>';

    $dados = [];
    if (($handle = fopen("novos_oficios.csv", "r")) !== false) {
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
                $oficio = new Oficio();
                foreach ($linha as $k => $v) {
                        $empreendimento = Empreendimento::find()->where(['titulo' => $v, 'contrato_id' => $contrato_id])->one();
                        $oficio->emprrendimento_id = $empreendimento->id;
                        switch ((int)$k) {
                            case 0: $oficio->tipo = $v; break;
                            case 1: $oficio->emprrendimento_desc = $v; break;
                            case 2: $oficio->data = $this->context->dataprobanco($v); break;
                            case 3: $oficio->fluxo = $v; break;
                            case 4: $oficio->emissor = $v; break;
                            case 5: $oficio->receptor = $v; break;
                            case 6: $oficio->num_processo = $v; break;
                            case 7: $oficio->num_protocolo = $v; break;
                            case 8: $oficio->Num_sei = $v; break;
                            case 9: $oficio->assunto = $v; break;
                            case 10: $oficio->diretorio = $v; break;
                            case 11: $oficio->status = $v; break;
                        }
                        echo "<li>$k - $v</li>";                       

                   

                }
                // Novo Produto:
                $oficio->contrato_id = $contrato_id;
                // $oficio->save();
                // Revisões
                
                /**
                 if ($oficio->save()) {
                     echo '<br> Certo... '.$oficio->id;
                } else {
                    echo '<br> Algo errado... '.$oficio->id;
                }
                */
                
                echo '</ul>';
                
            }

        ?>
    </div>
 </div>