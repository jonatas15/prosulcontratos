<?php

namespace app\controllers;

use app\models\Contrato;
use app\models\Impacto;
use app\models\ImpactoEmpreendimento as IEmp;
use app\models\ContratoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

use kartik\editable\Editable;

use Yii;

/**
 * ContratoController implements the CRUD actions for Contrato model.
 */
class ContratoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors() {
       return [
           'verbs' => [
               'class' => VerbFilter::className(),
               'actions' => [
                   'delete' => ['POST'],
               ],
           ],
           'access' => [
               'class' => AccessControl::className(),
               'only' => ['index', 'view', 'update', 'create',  'delete', 
                    'impactoscontratuais', 'alteraimpacto', 'alteraimpactocampo', 
                    'porempreendimento', 'porproduto',
                    'novoimpacto', 'os', 'pr', 'go'
                ],
               'rules' => [
                   [
                       'allow' => false,
                       'actions' => [],
                       'roles' => ['?'],
                   ],
                   [
                       'allow' => true,
                       'actions' => ['index', 'view', 'update', 'create',  'delete', 
                            'impactoscontratuais', 'alteraimpacto', 'alteraimpactocampo', 
                            'porempreendimento', 'porproduto',
                            'novoimpacto', 'os', 'pr', 'go'
                        ],
                       'roles' => ['@'],
                   ],
               ],
               'denyCallback' => function($rule, $action) {
                   if (Yii::$app->user->isGuest) {
                       Yii::$app->user->loginRequired();
                   }
                   else {
                       throw new ForbiddenHttpException('Somente administradores podem entrar nessa página.');
                   }                   
               }


           ],
       ];
    }

    /**
     * Lists all Contrato models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ContratoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionPorempreendimento()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $empreendimento_id = $_REQUEST['empreendimento'];
        $contrato_id = $_REQUEST['contrato_id'];
        $graph_grupos = [];
        // $quantidades = [
        //     'quantidade_a' => 0,
        //     'quantidade_utilizada' => 0,
        //     'qt_restante_real' => 0,
        //     'qt_restante' => 0,
        // ];
        $grupos = \app\models\Impacto::find()->select('produto, count(id) as contaservicos')->where([
            'contrato_id' => $contrato_id
        ])->groupBy('produto')->orderBy([
            'produto' => SORT_ASC
        ])->all();
        $impactosporempreendimento = \app\models\ImpactoEmpreendimento::find()->where([
            'empreendimento_id' => $empreendimento_id
        ])->all();
        foreach ($grupos as $K => $grupo) {
            $valor = 0;
            // $label = "Valor";
            $label = $grupo->produto;
            $emp_titulo = "Empreendimento Base";
            foreach($impactosporempreendimento as $item) {
                if ($item->impactos > 0 && $item->impacto->produto == $grupo->produto) {
                    $impacto = $item->impacto;
                    $valor += $item->impactos;
                    $emp_titulo = $item->empreendimento->titulo;
                }
            }
            if ($label != "Valor") {
                array_push($graph_grupos, [
                    'name' => $label, 
                    'y' => $valor, 
                    'url' => $K, 
                    'empreendimento' => $empreendimento_id,
                    'empreendimento_titulo' => $emp_titulo,
                ]);
            }
        }
        // echo '<pre>';
        // print_r($graph_grupos);
        // echo '</pre>';
        return $graph_grupos;
    }
    public function actionPorproduto()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $produto = $_REQUEST['produto'];
        $empreendimento = $_REQUEST['empreendimento'];
        $graph_grupos = [];
        
        $servicos = \app\models\Impacto::find()->where([
            'produto' => $produto
        ])->all();
        
        // TODOS OS SERVICOS Do PRODUTO
        $graph_servicos = [];
        foreach ($servicos as $servico) {
            // $label = mb_strimwidth($grp->produto,0,20,'...');
            // $servicos_do_grupo = Impc::findAll([
            //     'produto' => $grp->produto
            // ]);
            $impactos_em_todos_empreendimentos = 0;
            foreach($servico->impactoEmpreendimentos as $empimp) {
                if ($empimp->empreendimento_id == $empreendimento) {
                    $impactos_em_todos_empreendimentos += $empimp->impactos;
                }
            }
            if ($impactos_em_todos_empreendimentos > 0) {

                array_push($graph_servicos, [
                    'name' => $servico->servico, 'y' => $impactos_em_todos_empreendimentos, 'url' => $servico->id
                ]);
            }
        }
        
        // echo '<pre>';
        // print_r($graph_grupos);
        // echo '</pre>';
        return $graph_servicos;
    }

    public function actionNovoimpacto() {
        // echo '<pre>';
        // print_r($_REQUEST);
        // echo '</pre>';
        $modelI = new Impacto();
        if ($this->request->isPost && $modelI->load($this->request->post())) {
            if ($modelI->save()) {
                $empreendimentais = $_REQUEST['Empreendimento'];
                foreach ($empreendimentais as $k => $v) {
                    $ie = new IEmp();
                    $ie->impacto_id = $modelI->id;
                    $ie->empreendimento_id = $k;
                    $ie->impactos = $v;
                    // echo "$k => $v <br>";
                    $ie->save();
                }
                return $this->redirect([
                    'view',
                    'id' => $modelI->contrato_id,
                    'abativa' => 'aba_impactos'
                ]);
            }
        }
    }

    /**
     * Displays a single Contrato model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionOs($id)
    {
        // return $this->render('view', [
        //     'model' => $this->findModel($id),
        // ]);
        $searchModelOrdens = new \app\models\OrdensdeservicoSearch();
        $dataProviderOrdens = $searchModelOrdens->search(['contrato_id' => $id]);
        return $this->render('/ordensdeservico/indexcontrato', [
            'searchModel' => $searchModelOrdens,
            'dataProvider' => $dataProviderOrdens,
            'contrato' => $this->findModel($id),
            'contrato_id' => $id
        ]);
    }
    public function actionPr($id)
    {
        $searchModelProduto = new \app\models\ProdutoSearch();
        $dataProviderProduto = $searchModelProduto->search(['contrato_id'=>$id]);
        return $this->render('/produto/indexcontrato', [
            'searchModel' => $searchModelProduto,
            'dataProvider' => $dataProviderProduto,
            'contrato' => $this->findModel($id),
            'contrato_id' => $id
        ]);
    }
    public function actionGo($id)
    {
        $searchModelOficio = new \app\models\OficioSearch();
        $dataProviderOficio = $searchModelOficio->search(['contrato_id'=>$id]);
        return $this->render('/oficio/indexcontrato', [
            'searchModel' => $searchModelOficio,
            'dataProvider' => $dataProviderOficio,
            'contrato' => $this->findModel($id),
            'contrato_id' => $id
        ]);
    }
    public function actionImpactoscontratuais() {
        return $this->render('impactoscontratuais', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionImpactoscontratuaisiframe() {
        /**
         * Montar aqui as search e provider
         */
        echo '<style>#my-menu, #yii-debug-toolbar {display: none !important} #main, .col-md-5, .col-md-4, .col-md-7, .col-md-8, .row{background-color: rgba(240, 243, 245) !important}</style>';
        $searchModelImpacto = new \app\models\ImpactoSearch();
        $dataProviderImpacto = $searchModelImpacto->search(['contrato_id' => 1]);
        return $this->render('impactoscontratuais', [
            'searchModel' => $searchModelImpacto,
            'dataProvider' => $dataProviderImpacto,
            'contrato_id' => 1
        ]);
    }

    /**
     * Creates a new Contrato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Contrato();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contrato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function dataprobanco ($data) {
        $arr = explode('/', $data);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }
    public function actionUpdate ($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->data_assinatura = $model->data_assinatura ? $this->dataprobanco($model->data_assinatura) : '';
            $model->data_final = $model->data_final ? $this->dataprobanco($model->data_final) : '';
            $model->data_base = $model->data_base ? $this->dataprobanco($model->data_base) : '';
            $model->vigencia = $model->vigencia ? $this->dataprobanco($model->vigencia) : '';

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Contrato model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/']);
    }

    /**
     * Finds the Contrato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Contrato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contrato::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    function diasentre($data_inicial, $data_final) {
        $diferenca = strtotime($data_final) - strtotime($data_inicial);
        $dias = floor($diferenca / (60 * 60 * 24)); 
        return $dias;
    }

    public function actionAlteraimpacto() {
        $impacto_id = $_REQUEST['impacto_id'];
        $empreendimento_id = $_REQUEST['empreendimento_id'];
        $impactos = $_REQUEST['alteraimpacto_'.$impacto_id.'_'.$empreendimento_id];
        $modelar = \app\models\ImpactoEmpreendimento::findOne([
            'impacto_id' => $impacto_id,
            'empreendimento_id' => $empreendimento_id,
        ]);
        $modelar->impactos = $impactos;
        if ($modelar->save()) {
            return 1;
        } else {
            return false;
        }
    }

    public function actionAlteraimpactocampo() {
        $id = $_REQUEST['id'];
        $campo = $_REQUEST['campo'];
        $impactos = $_REQUEST['altera_campo_'.$id];
        $modelar = \app\models\Impacto::find()->where([ 'id'=>$id ])->one();
        $modelar->$campo = $impactos;
        
        // echo "id: ".$id.'<br>';
        // echo "campo: ".$campo.'<br>';
        // echo "impactos: ".$impactos.'<br>';
        // echo "<pre>";
        // print_r($modelar);
        // echo "</pre>";
        
        if ($modelar->save()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function imprimecampoeditavelmente($id, $campo, $valor, $editavel = null) {
        switch ($editavel) {
            case 'area': $tipoeditavel = Editable::INPUT_TEXTAREA; break;
            default: $tipoeditavel = Editable::INPUT_TEXT; break;
        }
        return Editable::widget([
            'id' => "altera_campo_{$campo}_{$id}", 
            'name' => "altera_campo_$id", 
            'value' => $valor,
            'attribute' => $campo,
            'asPopover' => true,
            'inputType' => $tipoeditavel, // Pode ser Editable::INPUT_DROPDOWN, Editable::INPUT_DATE, etc.
            // 'editableValueOptions' => ['class' => 'text-success'],
            'displayValue' => $valor,
            // 'submitButton' => ['class' => 'btn btn-primary btn-sm'],
            'formOptions' => [
                'action' => [
                    'alteraimpactocampo',
                    'campo' => $campo,
                    'id' => $id
                ]
            ]
        ]);
    }
    public function actionVieweditable($id)
    {
        $modelimpacto = \app\models\Impacto::findOne([
            'id' => $id
        ]);
        return $this->render('vieweditable', [
            'model' => $modelimpacto,
        ]);
    }
    public function clean($string) {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string = preg_replace('/-+/', '_', $string); // Replaces multiple hyphens with single one.
        $string = strtolower($string);
        return $string;
    }
    public function numeros_limpos($string) {
        $string = preg_replace('/[^0-9]/', '', $string);
        return $string;
    }
    public function formatatituloscampos($campo) {
        
        switch ($campo) {
            case 'NU_CNPJ_CPF': $retorno = "Nº CNPJ/CPF"; break;
            case 'SK_CONTRATO': $retorno = "SK Contrato"; break;
            case 'NU_CON_FORMATADO': $retorno = "Nº do Contrato"; break;
            case 'SK_CONTRATO_SUPERVISOR': $retorno = "SK Supervisor"; break;
            case 'NU_CON_FORMATADO_SUPERVISOR': $retorno = "Nº do Contrato - Supervisor"; break;
            case 'DT_BASE': $retorno = "Data de Base"; break;
            case 'DT_CORRENTE': $retorno = "Data Corrente"; break;
            case 'DT_TERMINO_VIGENCIA': $retorno = "Data de término da vigência"; break;
            case 'DT_APROVACAO': $retorno = "Data de aprovação"; break;
            case 'DT_ASSINATURA': $retorno = "Data de assinatura"; break;
            case 'DT_PROPOSTA': $retorno = "Data da Proposta"; break;
            case 'DT_PUBLICACAO': $retorno = "Data da Publicação"; break;
            case 'SK_DT_APROVACAO': $retorno = "SK: Data de aprovação"; break;
            case 'DT_DIA': $retorno = "Dia"; break;
            case 'DT_INICIO': $retorno = "Data de início"; break;
            case 'DT_TER_ATZ': $retorno = "Data de término (Atz)"; break;
            case 'DT_TER_PRV': $retorno = "Data de término (Prv)"; break;
            case 'SK_EMPRESA': $retorno = "SK: Empresa"; break;
            case 'NO_EMPRESA': $retorno = "NO: Empresa"; break;
            case 'SK_EMPRESA_SUPERVISOR': $retorno = "SK: Empresa Supervisora"; break;
            case 'SG_EMPRESA_SUPERVISOR': $retorno = "SG: Empresa Supervisora"; break;
            case 'SK_FISCAL': $retorno = "SK: Fiscal"; break;
            case 'NM_FISCAL': $retorno = "NM: Fiscal"; break;
            case 'DS_GRUPO_INTERVENCAO': $retorno = "DS: Grupo de Intervenção"; break;
            case 'SK_MODAL': $retorno = "SK: Modal"; break;
            case 'DS_MODAL': $retorno = "DS: Modal"; break;
            case 'MODALIDADE_LICITACAO': $retorno = "Modalidade de Licitação"; break;
            case 'SK_MUNICIPIO': $retorno = "SK: Município"; break;
            case 'NO_MUNICIPIO': $retorno = "NO: Município"; break;
            case 'CO_MUNICIPIO': $retorno = "CO: Município"; break;
            case 'NO_MUNICIPIO0': $retorno = "NO(0) Município"; break;
            case 'NU_EDITAL': $retorno = "Nº Edital"; break;
            case 'NU_LOTE_LICITACAO': $retorno = "Nº Lote de Licitação"; break;
            case 'NU_PROCESSO': $retorno = "Nº Processo"; break;
            case 'DS_OBJETO': $retorno = "DS: Objeto"; break;
            case 'SK_PROGRAMA': $retorno = "SK: Programa"; break;
            case 'NM_PROGRAMA': $retorno = "NM: Programa"; break;
            case 'NU_DIA_PARALISACAO': $retorno = "Nº dia de Paralisação"; break;
            case 'NU_DIA_PRORROGACAO': $retorno = "Nº dia de Prorrogação"; break;
            case 'SK_SITUACAO_CONTRATO': $retorno = "SK: Situação do Contrato"; break;
            case 'DS_FAS_CONTRATO': $retorno = "DS: Fase do Contrato"; break;
            case 'CO_TIP_CONTRATO': $retorno = "CO: Tipo do Contrato"; break;
            case 'DS_TIP_CONTRATO': $retorno = "DS: Tipo do Contrato"; break;
            case 'SK_TIPO_INTERVENCAO': $retorno = "SK: Tipo de Intervenção"; break;
            case 'ds_tip_intervencao': $retorno = "DS: Tipo de Intervenção"; break;
            case 'TIPO_LICITACAO': $retorno = "Tipo de Licitação"; break;
            case 'DESCRICAO_BR': $retorno = "Descrição"; break;
            case 'SK_UF_UNIDADE_LOCAL': $retorno = "SK: UF - Unidade Local"; break;
            case 'SG_UF_UNIDADE_LOCAL': $retorno = "SG: UF - Unidade Local"; break;
            case 'CO_UF': $retorno = "CO - UF"; break;
            case 'SG_UF': $retorno = "SG - UF"; break;
            case 'SK_UNIDADE_FISCAL': $retorno = "SK: Unidade Fiscal"; break;
            case 'NM_UND_FISCAL': $retorno = "NM: Unidade Fiscal"; break;
            case 'SG_UND_FISCAL': $retorno = "SG: Unidade Fiscal"; break;
            case 'SK_UNIDADE_GESTORA': $retorno = "SK: Unidade Gestora"; break;
            case 'NM_UND_GESTORA': $retorno = "NM: Unidade Gestora"; break;
            case 'SG_UND_GESTORA': $retorno = "SG: Unidade Gestora"; break;
            case 'SK_UNIDADE_LOCAL': $retorno = "SK: Unidade Local"; break;
            case 'NM_UND_LOCAL': $retorno = "NM: Unidade Local"; break;
            case 'SG_UND_LOCAL': $retorno = "SG: Unidade Local"; break;
            case 'SK_UNIDADE_PAGAMENTO': $retorno = "SK: Unidade Pagamento"; break;
            case 'NM_UND_PAGAMENTO': $retorno = "NM: Unidade Pagamento"; break;
            case 'SG_UND_PAGAMENTO': $retorno = "SG: Unidade Pagamento"; break;
            case 'Extensao_Total': $retorno = "Extenção Total"; break;
            case 'Valor_Inicial': $retorno = "Valor Inicial"; break;
            case 'Valor_Total_de_Aditivos': $retorno = "Valor total de aditivos"; break;
            case 'Valor_Total_de_Reajuste': $retorno = "Valor total de reajustes"; break;
            case 'Valor_Inicial_Adit_Reajustes': $retorno = "Valor inicial de aditivos e reajustes"; break;
            case 'Valor_Empenhado': $retorno = "Valor empenhado"; break;
            case 'Valor_Saldo': $retorno = "Valor de saldo"; break;
            case 'Valor_Medicao_PI_R': $retorno = "Valor de Medição (PI R)"; break;
            case 'Valor_PI_Medicao': $retorno = "Valor PI de Medição"; break;
            case 'Valor_Reajuste_Medicao': $retorno = "Valor de reajuste de Medição"; break;
            case 'Valor_Oficio_Pagamento': $retorno = "Valor do ofício de pagamento"; break;
            case 'Ajuste_Contratual_Acumulado': $retorno = "Ajuste contratual acumulado"; break;
            case 'Valor_Medicao_PI_R_Ajuste_Acumulado': $retorno = "Valor de medição (PI R) - Ajuste Acumulado"; break;
            default: $retorno = $campo; break;
        }

        return $retorno;
    }
    public function formatacampos($campo, $valor) {
        $needle = "Valor";
        $pos = strpos($campo, $needle);
        $pos_data = strpos($campo, "DT_");
        $pos_extensao = strpos($campo, "Extensao");
        $pos_ajuste = strpos($campo, "Ajuste_Contratual");
        
        // if ($pos === 0) {
        if ($pos === false) {
        } else {
            $valor = (float)$valor;
            $valor = 'R$ ' . number_format($valor, 2, ',', '.');
        }
        if ($pos_data === false) {
        } else {
            $valor = date("d/m/Y H:i", strtotime($valor));
        }
        if ($pos_extensao === false) {
        } else {
            $valor = (float)$valor;
            $valor = number_format($valor, 2, ',', '.');
        }
        if ($pos_ajuste === false) {
        } else {
            $valor = (float)$valor;
            $valor = number_format($valor, 2, ',', '.');
        }
        return $valor;
    }
}
