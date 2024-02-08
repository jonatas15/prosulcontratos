<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Impacto;

/**
 * ImpactoSearch represents the model behind the search form of `app\models\Impacto`.
 */
class ImpactoSearch extends Impacto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contrato_id', 'produto_id', 'quantidade_a', 'quantidade_utilizada', 'qt_restante_real', 'qt_restante'], 'integer'],
            [['produto', 'servico', 'numeroitem', 'unidade'], 'safe'],
            [['preco_unitario', 'custos_diretos', 'custos_indiretos', 'custo_total', 'custo_utilizado', 'saldo_restante', 'custo_real'], 'number'],
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
        $query = Impacto::find();

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

        (isset($params['ImpactoSearch'])?$this->load($params):$this->load($params,''));

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'contrato_id' => $this->contrato_id,
            'produto_id' => $this->produto_id,
            'quantidade_a' => $this->quantidade_a,
            'quantidade_utilizada' => $this->quantidade_utilizada,
            'qt_restante_real' => $this->qt_restante_real,
            'qt_restante' => $this->qt_restante,
            'preco_unitario' => $this->preco_unitario,
            'custos_diretos' => $this->custos_diretos,
            'custos_indiretos' => $this->custos_indiretos,
            'custo_total' => $this->custo_total,
            'custo_utilizado' => $this->custo_utilizado,
            'saldo_restante' => $this->saldo_restante,
            'custo_real' => $this->custo_real,
        ]);

        $query->andFilterWhere(['like', 'produto', $this->produto])
            ->andFilterWhere(['like', 'servico', $this->servico])
            ->andFilterWhere(['like', 'numeroitem', $this->numeroitem])
            ->andFilterWhere(['like', 'unidade', $this->unidade]);

        return $dataProvider;
    }
}
