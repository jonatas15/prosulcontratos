<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Arquivo;

/**
 * ArquivoSearch represents the model behind the search form of `app\models\Arquivo`.
 */
class ArquivoSearch extends Arquivo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contrato_id', 'oficio_id', 'ordensdeservico_id', 'empreendimento_id', 'produto_id', 'licenciamento_id'], 'integer'],
            [['tipo', 'datacadastro', 'src', 'pasta', 'ref'], 'safe'],
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
        $query = Arquivo::find();

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
            'datacadastro' => $this->datacadastro,
            'contrato_id' => $this->contrato_id,
            'oficio_id' => $this->oficio_id,
            'ordensdeservico_id' => $this->ordensdeservico_id,
            'empreendimento_id' => $this->empreendimento_id,
            'produto_id' => $this->produto_id,
            'licenciamento_id' => $this->licenciamento_id,
        ]);

        $query->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'src', $this->src])
            ->andFilterWhere(['like', 'pasta', $this->pasta])
            ->andFilterWhere(['like', 'ref', $this->ref]);

        return $dataProvider;
    }
}
