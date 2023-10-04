<?php

namespace app\controllers;

use app\models\Fase;
use app\models\FaseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FaseController implements the CRUD actions for Fase model.
 */
class FaseController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Fase models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FaseSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fase model.
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
     * Creates a new Fase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Fase();

        if ($this->request->isPost) {
            
            
            if ($model->load($this->request->post())) {
                $model->data = $this->dataprobanco($model->data);
                
                $maiorOrdem = \app\models\Fase::find()->where(['licenciamento_id' => $model->licenciamento_id])->max('ordem');
                $novaOrdem = $maiorOrdem + 1;
                
                $model->ordem = $novaOrdem;
                
                if ($model->save()) {
                    return $this->redirect(\Yii::$app->request->referrer);
                }
                // return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Fase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->data = $this->dataprobanco($model->data);
            if ($model->save()) {
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Fase model.
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
     * Finds the Fase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Fase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fase::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionOrdenaup () {
        $id = $_REQUEST['id'];
        $or = (int)$_REQUEST['ordem'];
        $model = $this->findModel($id);
        $model->ordem = (int)$or + 1;
        $outros = \app\models\Fase::find()->where([
            'licenciamento_id' => $model->licenciamento_id
        ])->all();
        foreach ($outros as $dmais) {
            if ($dmais->ordem == ($or + 1)) {
                $dmais->ordem = $or;
            }
            $dmais->save();
        }
        $model->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }
    public function actionOrdenadown () {
        $id = $_REQUEST['id'];
        $or = (int)$_REQUEST['ordem'];
        $model = $this->findModel($id);
        $model->ordem = (int)$or - 1;
        $outros = \app\models\Fase::find()->where([
            'licenciamento_id' => $model->licenciamento_id
        ])->all();
        foreach ($outros as $dmais) {
            if ($dmais->ordem == ($or - 1)) {
                $dmais->ordem = $or;
            }
            $dmais->save();
        }
        $model->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }
    public function actionEditcampo($id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $campo = $_REQUEST['campo'];
        $valor = $_REQUEST[$campo];
        $model = $this->findModel($id);
        $model->$campo = $valor != "" ? $valor : $model->$campo;
        $model->save();
        return ['output' => $valor, 'message'=>''];
    }
    public function dataprobanco ($data) {
        $arr = explode('/', $data);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }
    public function dataproview ($data) {
        $arr = explode('-', $data);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }
}
