<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Licenciamento;

/**
 * LicenciamentoSearch represents the model behind the search form of `app\models\Licenciamento`.
 */
class LicenciamentoSearch extends Licenciamento
{
    public $param;
    public $from_date;
    public $to_date;
    public $ids;
    public $ano_listagem;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ordensdeservico_id', 'empreendimento_id'], 'integer'],
            [['numero', 'datacadastro', 'dataedicao', 'data_validade', 'data_renovacao', 'descricao'], 'safe'],
            [['from_date', 'to_date', 'ano_listagem'], 'safe'],
            [['param'], 'string', 'on' => 'MY_SCENARIO'],
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
            'sort'=> [
                'defaultOrder' => [
                    'id' => SORT_ASC
                ],
            ],
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);

        (isset($params['LicenciamentoSearch'])?$this->load($params):$this->load($params,''));

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
            'contrato_id' => $this->contrato_id,
        ]);

        $query->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'datacadastro', $this->datacadastro])
            ->andFilterWhere(['like', 'dataedicao', $this->dataedicao])
            ->andFilterWhere(['like', 'data_validade', $this->data_validade])
            ->andFilterWhere(['like', 'data_renovacao', $this->data_renovacao])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);

        $query->andFilterWhere(['between', 'datacadastro', $this->from_date, $this->to_date]);
        if ($this->ano_listagem != 'all') {
            $query->andFilterWhere([
                'YEAR(datacadastro)' => $this->ano_listagem,
            ]);
        }

        return $dataProvider;
    }
}
