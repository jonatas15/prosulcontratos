<?php

namespace app\controllers;

use app\models\Arquivo;
use app\models\ArquivoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;

/**
 * ArquivoController implements the CRUD actions for Arquivo model.
 */
class ArquivoController extends Controller
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
     * Lists all Arquivo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArquivoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Arquivo model.
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
     * Creates a new Arquivo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Arquivo();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                foreach ($model->imageFiles as $file) {

                    // Define o valor vindo campo vindo da tabela externa
                    $valor_tabela_externa = "";
                    $valor_tabela_externa .= $model->contrato_id != '' ? $model->contrato_id : '';
                    $valor_tabela_externa .= $model->oficio_id != '' ? $model->oficio_id : '';
                    $valor_tabela_externa .= $model->ordensdeservico_id != '' ? $model->ordensdeservico_id : '';
                    $valor_tabela_externa .= $model->empreendimento_id != '' ? $model->empreendimento_id : '';
                    $valor_tabela_externa .= $model->produto_id != '' ? $model->produto_id : '';
                    $valor_tabela_externa .= $model->licenciamento_id != '' ? $model->licenciamento_id : '';
                    $valor_tabela_externa .= $model->fase_id != '' ? $model->fase_id : '';

                    // Define o campo vindo campo vindo da tabela externa
                    $campo_tabela_externa = "";
                    $campo_tabela_externa .= $model->contrato_id != '' ? 'contrato_id' : '';
                    $campo_tabela_externa .= $model->oficio_id != '' ? 'oficio_id' : '';
                    $campo_tabela_externa .= $model->ordensdeservico_id != '' ? 'ordensdeservico_id' : '';
                    $campo_tabela_externa .= $model->empreendimento_id != '' ? 'empreendimento_id' : '';
                    $campo_tabela_externa .= $model->produto_id != '' ? 'produto_id' : '';
                    $campo_tabela_externa .= $model->licenciamento_id != '' ? 'licenciamento_id' : '';
                    $campo_tabela_externa .= $model->fase_id != '' ? 'fase_id' : '';
                    
                    
                    $arquivo = $this->clean($file->baseName) . '.' . $this->clean($file->extension);
                    $campos = "tipo, src, $campo_tabela_externa, pasta, ref";

                    $model->ref = $file->baseName;

                    $valores = "'$model->tipo', '$arquivo', '$valor_tabela_externa', '$model->pasta', '$model->ref'";
                    \Yii::$app->db->createCommand("insert into arquivo ($campos) VALUES ($valores)")->execute(); 
                }
                // exit();
                if ($model->upload()) {
                    return $this->redirect(\Yii::$app->request->referrer);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Arquivo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Arquivo model.
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
     * Finds the Arquivo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Arquivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Arquivo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function clean($string) {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string = preg_replace('/-+/', '_', $string); // Replaces multiple hyphens with single one.
        $string = strtolower($string);
        return $string;
     }
}
