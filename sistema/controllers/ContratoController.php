<?php

namespace app\controllers;

use app\models\Contrato;
use app\models\ContratoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

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
               'only' => ['index', 'view', 'update', 'create',  'delete', 'impactoscontratuais', 'alteraimpacto', 'alteraimpactocampo', 'porempreendimento'],
               'rules' => [
                   [
                       'allow' => true,
                       'actions' => [],
                       'roles' => ['?'],
                   ],
                   [
                       'allow' => true,
                       'actions' => ['index', 'view', 'update', 'create',  'delete', 'impactoscontratuais', 'alteraimpacto', 'alteraimpactocampo', 'porempreendimento'],
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
        $graph_grupos = [];
        // $quantidades = [
        //     'quantidade_a' => 0,
        //     'quantidade_utilizada' => 0,
        //     'qt_restante_real' => 0,
        //     'qt_restante' => 0,
        // ];
        $grupos = \app\models\Impacto::find()->select('produto, count(id) as contaservicos')->groupBy('produto')->orderBy([
            'produto' => SORT_ASC
        ])->all();
        $impactosporempreendimento = \app\models\ImpactoEmpreendimento::find()->where([
            'empreendimento_id' => $empreendimento_id
        ])->all();
        foreach ($grupos as $K => $grupo) {
            $valor = 0;
            // $label = "Valor";
            $label = $grupo->produto;
            foreach($impactosporempreendimento as $item) {
                if ($item->impactos > 0 && $item->impacto->produto == $grupo->produto) {
                    $impacto = $item->impacto;
                    $valor += $item->impactos;
                }
            }
            if ($label != "Valor") {
                array_push($graph_grupos, [
                    'name' => $label, 'y' => $valor, 'url' => $K
                ]);
            }
        }
        // echo '<pre>';
        // print_r($graph_grupos);
        // echo '</pre>';
        return $graph_grupos;
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
    public function actionImpactoscontratuais() {
        return $this->render('impactoscontratuais', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
    public function actionUpdate($id)
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

        return $this->redirect(['index']);
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
}
