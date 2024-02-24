<?php

namespace app\controllers;

use app\models\Produto;
use app\models\ProdutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
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
     * Lists all Produto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexcontrato()
    {
        return $this->render('indexcontrato', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Produto model.
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
    // public function actionDetalhes($id)
    // {
    //     return $this->render('detalhes', [
    //         'model' => $this->findModel($id),
    //         'id' => $id,
    //     ]);
    // }

    /**
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->data_validade = $model->data_validade != '' ? $this->dataprobanco($model->data_validade): '';
                $model->data_renovacao = $model->data_renovacao != '' ? $this->dataprobanco($model->data_renovacao): '';
                $model->data_entrega = $model->data_entrega != '' ? $this->dataprobanco($model->data_entrega): '';
                $model->aprov_data = $model->aprov_data != '' ? $this->dataprobanco($model->aprov_data): '';
                if ($model->save()) {
                    return $this->redirect([
                        'update', 
                        'id' => $model->id,
                        'abativa' => 'reviews'
                    ]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionRevisao()
    {
        $model = new \app\models\Revisao();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->data = $model->data != '' ? $this->dataprobanco($model->data): '';
                if ($model->save()) {
                    // return $this->redirect(\Yii::$app->request->referrer);
                    return $this->redirect([
                        'update', 
                        'id' => $model->produto_id,
                        'abativa' => 'reviews'
                    ]);
                }
            }
        } else {
            return null;
        }
    }

    public function actionEditreview($id)
    {
        $model = \app\models\Revisao::findOne(['id' => $id]);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->data = $model->data != '' ? $this->dataprobanco($model->data): '';
            if ($model->save()) {
                return $this->redirect([
                    'update', 
                    'id' => $model->produto_id,
                    'abativa' => 'reviews'
                ]);
            }
        } else {
            return null;
        }

    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->data_validade = $model->data_validade != '' ? $this->dataprobanco($model->data_validade): '';
            $model->data_renovacao = $model->data_renovacao != '' ? $this->dataprobanco($model->data_renovacao): '';
            $model->data_entrega = $model->data_entrega != '' ? $this->dataprobanco($model->data_entrega): '';
            $model->aprov_data = $model->aprov_data != '' ? $this->dataprobanco($model->aprov_data): '';
            if ($model->save()) {
                return $this->redirect(['update', 
                    'id' => $model->id,
                    'abativa' => 'reviews'
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Produto model.
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
        \app\models\Revisao::findOne(['id' => $id])->delete();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne(['id' => $id])) !== null) {
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
