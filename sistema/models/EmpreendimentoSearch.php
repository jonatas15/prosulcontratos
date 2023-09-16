<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Empreendimento;

/**
 * EmpreendimentoSearch represents the model behind the search form of `app\models\Empreendimento`.
 */
class EmpreendimentoSearch extends Empreendimento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'prazo', 'ordensdeservico_id', 'oficio_id'], 'integer'],
            [['titulo', 'datacadastro', 'dataupdate', 'status', 'uf', 'segmento', 'tipo_obra', 'municipios_interceptados', 'orgao_licenciador'], 'safe'],
            [['extensao_km'], 'number'],
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
        $query = Empreendimento::find();

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
            'prazo' => $this->prazo,
            'datacadastro' => $this->datacadastro,
            'dataupdate' => $this->dataupdate,
            'extensao_km' => $this->extensao_km,
            'ordensdeservico_id' => $this->ordensdeservico_id,
            'oficio_id' => $this->oficio_id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'uf', $this->uf])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'segmento', $this->segmento])
            ->andFilterWhere(['like', 'tipo_obra', $this->tipo_obra])
            ->andFilterWhere(['like', 'municipios_interceptados', $this->municipios_interceptados])
            ->andFilterWhere(['like', 'orgao_licenciador', $this->orgao_licenciador]);

        return $dataProvider;
    }
}
