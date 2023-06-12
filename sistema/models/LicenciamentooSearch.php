<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Licenciamento;

/**
 * LicenciamentooSearch represents the model behind the search form of `app\models\Licenciamento`.
 */
class LicenciamentooSearch extends Licenciamento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ordensdeservico_id', 'empreendimento_id'], 'integer'],
            [['numero', 'datacadastro', 'dataedicao', 'data_validade', 'data_renovacao', 'descricao'], 'safe'],
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
        $query = Licenciamento::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'ordensdeservico_id' => $this->ordensdeservico_id,
            'empreendimento_id' => $this->empreendimento_id,
        ]);

        $query->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'datacadastro', $this->datacadastro])
            ->andFilterWhere(['like', 'dataedicao', $this->dataedicao])
            ->andFilterWhere(['like', 'data_validade', $this->data_validade])
            ->andFilterWhere(['like', 'data_renovacao', $this->data_renovacao])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
}
