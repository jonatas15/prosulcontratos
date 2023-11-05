<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fase;

/**
 * FaseSearch represents the model behind the search form of `app\models\Fase`.
 */
class FaseSearch extends Fase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'empreendimento_id', 'licenciamento_id', 'ativo'], 'integer'],
            [['fase', 'datacadastro', 'data', 'exigencias', 'ambito', 'status'], 'safe'],
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
        $query = Fase::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'ordem' => SORT_DESC
                ],
            ],
        ]);

        (isset($params['EtapaSearch'])?$this->load($params):$this->load($params,''));

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'empreendimento_id' => $this->empreendimento_id,
            'licenciamento_id' => $this->licenciamento_id,
            'datacadastro' => $this->datacadastro,
            'data' => $this->data,
            'ativo' => $this->ativo
        ]);

        $query->andFilterWhere(['like', 'fase', $this->fase])
            ->andFilterWhere(['like', 'exigencias', $this->exigencias])
            ->andFilterWhere(['like', 'ambito', $this->ambito])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
