<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Produto;

/**
 * ProdutoSearch represents the model behind the search form of `app\models\Produto`.
 */
class ProdutoSearch extends Produto
{
    public $ano_listagem;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'produto_id', 'empreendimento_id', 'ordensdeservico_id', 'aprov_tempo_ultima_revisao', 'aprov_tempo_total'], 'integer'],
            [['numero', 'datacadastro', 'data_validade', 'data_renovacao', 'data_entrega', 'fase', 'entrega', 'servico', 'descricao', 'aprov_data', 'aprov_versao', 'diretorio_texto', 'diretorio_link'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Produto::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id' => SORT_ASC
                ],
            ],
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'produto_id' => $this->produto_id,
            'empreendimento_id' => $this->empreendimento_id,
            'ordensdeservico_id' => $this->ordensdeservico_id,
            'datacadastro' => $this->datacadastro,
            'data_validade' => $this->data_validade,
            'data_renovacao' => $this->data_renovacao,
            'data_entrega' => $this->data_entrega,
            'aprov_data' => $this->aprov_data,
            'aprov_tempo_ultima_revisao' => $this->aprov_tempo_ultima_revisao,
            'aprov_tempo_total' => $this->aprov_tempo_total,
        ]);

        $query->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'fase', $this->fase])
            ->andFilterWhere(['like', 'entrega', $this->entrega])
            ->andFilterWhere(['like', 'servico', $this->servico])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'aprov_versao', $this->aprov_versao])
            ->andFilterWhere(['like', 'diretorio_texto', $this->diretorio_texto])
            ->andFilterWhere(['like', 'diretorio_link', $this->diretorio_link]);

        return $dataProvider;
    }
}
