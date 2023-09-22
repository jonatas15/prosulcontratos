<?php

namespace app\controllers;

use app\models\Empreendimento;
use app\models\Licenciamento;
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
    public function behaviors()
   {
       return [
           'verbs' => [
               'class' => VerbFilter::className(),
               'actions' => [
                   'delete' => ['POST'],
               ],
           ],
           'access' => [
               'class' => AccessControl::className(),
               'only' => ['index', 'view', 'update', 'create',  'delete', 'novafase', 'editfase'],
               'rules' => [
                   [
                       'allow' => false,
                       'actions' => [],
                       'roles' => ['?'],
                   ],
                   [
                       'allow' => true,
                       'actions' => ['index', 'view', 'update', 'create',  'delete', 'novafase', 'editfase'],
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
     * Lists all Empreendimento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmpreendimentoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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

    function diasentre($data_inicial, $data_final) {
        $diferenca = strtotime($data_final) - strtotime($data_inicial);
        $dias = floor($diferenca / (60 * 60 * 24)); 
        return $dias;
    }
}
