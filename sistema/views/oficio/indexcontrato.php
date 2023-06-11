<?php

use app\models\Oficio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OficioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Oficios';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table, th, td {
        border: 1px solid;
    }
</style>
<div class="oficio-index">

    <h3><img src="/logo/upload-files-icon.png" class="icone-modulo" width="25" /> <?= Html::encode($this->title) ?></h3>
    <?php /**
    <p>
        <?= Html::a('Create Oficio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    */?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
        use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

        $path = Yii::$app->basePath.'/web/arquivo/exportar.xlsx';
        # open the file
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($path);
        # read each cell of each row of each sheet
        echo '<table border="2">';
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                echo '<tr>';
                // foreach ($row->getCells() as $cell) {
                //     echo '<td>'.$cell->getValue().'</td>';
                // }
                // echo $row->getCells()[0];
                echo '<td>'.$row->getCells()[0].'</td>'; # ID
                echo '<td>'.$row->getCells()[1].'</td>'; # Tipo
                echo '<td>'.$row->getCells()[2].'</td>'; # Empreendimento
                echo '<td>'.$row->getCells()[3].'</td>'; # Data
                echo '<td>'.$row->getCells()[4].'</td>'; # Fluxo
                echo '<td>'.$row->getCells()[5].'</td>'; # Emissor
                echo '<td>'.$row->getCells()[6].'</td>'; # Receptor	
                echo '<td>'.$row->getCells()[7].'</td>'; # Nº do Processo	
                echo '<td>'.$row->getCells()[8].'</td>'; # Nº do Protocolo	
                echo '<td>'.$row->getCells()[9].'</td>'; # Nº do SEI	
                echo '<td>'.$row->getCells()[10].'</td>'; # Assunto
                echo '<td>'.$row->getCells()[11].'</td>'; # Diretório
                echo '<td>'.$row->getCells()[12].'</td>'; # Status
                echo '</tr>';
            }
        }
        echo '</table>';
        $reader->close();
    ?>
    <div class="clearfix">
        <br />
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            // 'contrato_id',
            // 'emprrendimento_id',
            'tipo',
            'emprrendimento_desc',
            //'datacadastro',
            'data',
            'fluxo',
            //'emissor',
            //'receptor',
            //'num_processo',
            //'num_protocolo',
            //'Num_sei',
            //'assunto:ntext',
            //'diretorio',
            //'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Oficio $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
