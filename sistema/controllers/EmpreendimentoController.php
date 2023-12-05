<?php

namespace app\controllers;

use app\models\Empreendimento;
use app\models\Licenciamento;
use app\models\Fase;
use app\models\EmpreendimentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

use Yii;


/**
 * EmpreendimentoController implements the CRUD actions for Empreendimento model.
 */
class EmpreendimentoController extends Controller
{
    /**
     * @inheritDoc
     */
    // public function behaviors()
    // {
    //     return array_merge(
    //         parent::behaviors(),
    //         [
    //             'verbs' => [
    //                 'class' => VerbFilter::className(),
    //                 'actions' => [
    //                     'delete' => ['POST'],
    //                 ],
    //             ],
    //         ]
    //     );
    // }
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
               'only' => ['index', 'view', 'update', 'create',  'delete', 'novafase', 'editfase', 'empgerencial', 'preview', 'definicaofases', 'ativandoetapa', 'savechecklist'],
               'rules' => [
                   [
                       'allow' => false,
                       'actions' => [],
                       'roles' => ['?']
                   ],
                   [
                       'allow' => true,
                       'actions' => ['index', 'view', 'update', 'create',  'delete', 'novafase', 'editfase', 'empgerencial', 'preview', 'definicaofases', 'ativandoetapa', 'savechecklist'],
                       'roles' => ['@']
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
     * Lists all Empreendimento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $contrato_id = $_REQUEST['contrato'];
        $searchModel = new EmpreendimentoSearch();
        $dataProvider = $searchModel->search([
            'contrato_id'=>$contrato_id
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDefinicaofases()
    {
        return $this->render('definicaofases', [
            'fases' => $fases
        ]);
    }
    public function actionOmapa()
    {
        return $this->render('omapa');
    }
    public function actionAtivandoetapa()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $Fase = Fase::findOne([
            'id' => $_REQUEST['fase_id']
        ]);
        $Fase->ativo = $Fase->ativo == 1 ? 0 : 1;
        $Fase->data =  date('Y-m-d h:i:s', time());
        $Fase->datacadastro =  date('Y-m-d h:i:s', time());
        $Fase->status =  'Pendente';
        if ($Fase->save()) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Displays a single Empreendimento model.
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
    public function actionPreview($id)
    {
        return $this->render('preview', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Empreendimento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Empreendimento();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $licenciamentos = [
                    'IPHAN' => 'Anuência para LP Emitida',
                    'LAP' => 'Estudo Aprovado DNIT',
                    'LAI' => 'Estudo em Andamento',
                ];
                foreach ($licenciamentos as $key => $value) {
                    $novolicenciamento = new Licenciamento;
                    $novolicenciamento->numero = $key;
                    $novolicenciamento->descricao = $value;
                    $novolicenciamento->empreendimento_id = $model->id;
                    // echo "$key -> $value <br>";
                    $novolicenciamento->save();

                }
                return $this->redirect([
                    'update', 
                    'id' => $model->id,
                    'abativa' => 'arquivos'
                ]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Empreendimento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect([
                'update', 
                'id' => $model->id,
                'abativa' => 'fases'
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionEmpgerencial($id)
    {
        $model = $this->findModel($id);
        return $this->render('empgerencial', [
            'model' => $model,
        ]);
    }

    public function actionNovafase()
    {
        $model = new \app\models\Fase();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->data = $model->data != '' ? $this->dataprobanco($model->data): '';
                if ($model->save()) {
                    return $this->redirect([
                        'update', 
                        'id' => $model->empreendimento_id,
                        'abativa' => 'fases'
                    ]);
                }
            }
        } else {
            return 'algo errado, retorne';
        }
    }
    public function actionEditfase($id)
    {
        $model = \app\models\Fase::findOne(['id' => $id]);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->data = $model->data != '' ? $this->dataprobanco($model->data): '';
            if ($model->save()) {
                return $this->redirect([
                    'update', 
                    'id' => $model->empreendimento_id,
                    'abativa' => 'fases'
                ]);
            }
        }

        return 'algo errado, retorne';
    }

    /**
     * Deletes an existing Empreendimento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    public function actionDeletereview($id)
    {
        \app\models\Fase::findOne(['id' => $id])->delete();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the Empreendimento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Empreendimento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empreendimento::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function dataprobanco ($data) {
        $arr = explode('/', $data);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }

    public function diasentre ($data_inicial, $data_final) {
        $diferenca = strtotime($data_final) - strtotime($data_inicial);
        $dias = floor($diferenca / (60 * 60 * 24)); 
        return $dias;
    }
    public function grupo_de_fases ($titulo, $conteudo, $ref) {
        return '<div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#'.$ref.'" aria-expanded="false" aria-controls="'.$ref.'">
                '.$titulo.'
            </button>
            </h2>
            <div id="'.$ref.'" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                '.$conteudo.'
            </div>
            </div>
        </div>';
    }
    public function actionSavechecklist() {
        // $model = new Fase();
        
        // if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Processar os dados e salvar os registros
            $postData = Yii::$app->request->post('Fase');
            $orgao = $postData['orgao_grupo'];
            // echo 'Órgão: '.$orgao;
            // echo '<pre>';
            // print_r($postData);
            // echo '</pre>';
            // echo '<hr>';
            // echo '<hr>';
            // echo '<hr>';
            // exit();
            $arr_models = [];
            foreach ($postData as $k => $data) {
                // echo $k;
                if ($k != 'orgao_grupo') {
                    $data['ambito'] = $orgao;
                    array_push($arr_models, $data);
                }
            }
            foreach ($arr_models as $data) {
                $checklistItem = new Fase();
                $checklistItem->attributes = $data;
                $checklistItem->save();
            }
            // Yii::$app->session->setFlash('success', 'Registros salvos com sucesso.');
            return $this->redirect(\Yii::$app->request->referrer.'&abativa='.$model->licenciamento->numero);
        // }

        // return $this->render('checklistForm', ['model' => $model]);
    }

    public function limparString($string) {
        // Remove caracteres especiais
        $string = preg_replace('/[^a-zA-Z0-9]/', '', $string);
    
        // Remove espaços
        $string = str_replace(' ', '', $string);
    
        return $string;
    }

}
