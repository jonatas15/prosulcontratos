<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contrato;

/**
 * ContratoSearch represents the model behind the search form of `app\models\Contrato`.
 */
class ContratoSearch extends Contrato
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['titulo', 'datacadastro', 'dataupdate', 'icone', 'lote', 'objeto', 'num_edital', 'empresa_executora', 'data_assinatura', 'data_final', 'data_base', 'vigencia', 'obs'], 'safe'],
            [['saldo_prazo', 'valor_total', 'valor_faturado', 'saldo_contrato', 'valor_empenhado', 'saldo_empenho'], 'number'],
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
        $query = Contrato::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id' => SORT_ASC
                ],
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
            'datacadastro' => $this->datacadastro,
            'dataupdate' => $this->dataupdate,
            'data_assinatura' => $this->data_assinatura,
            'data_final' => $this->data_final,
            'saldo_prazo' => $this->saldo_prazo,
            'valor_total' => $this->valor_total,
            'valor_faturado' => $this->valor_faturado,
            'saldo_contrato' => $this->saldo_contrato,
            'valor_empenhado' => $this->valor_empenhado,
            'saldo_empenho' => $this->saldo_empenho,
            'data_base' => $this->data_base,
            'vigencia' => $this->vigencia,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'icone', $this->icone])
            ->andFilterWhere(['like', 'obs', $this->obs])
            ->andFilterWhere(['like', 'lote', $this->lote])
            ->andFilterWhere(['like', 'objeto', $this->objeto])
            ->andFilterWhere(['like', 'num_edital', $this->num_edital])
            ->andFilterWhere(['like', 'empresa_executora', $this->empresa_executora]);

        return $dataProvider;
    }
}
