<div class="row my-5">
    <?php 
        $searchModelArquivo = new \app\models\ArquivoSearch();
        $dataProviderArquivo = $searchModelArquivo->search(['fase_id'=>$model->id]);
        echo $this->render('/arquivo/index', [
            'searchModel' => $searchModelArquivo,
            'dataProvider' => $dataProviderArquivo,
            'funcionalidades' => true,
            'id_tabela_referencia' => 'fase_id',
            'id_valor_referencia' => $model->id,
        ]);
    ?>
</div>