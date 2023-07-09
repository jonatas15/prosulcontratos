<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ordensdeservico;

/**
 * OrdensdeservicoSearch represents the model behind the search form of `app\models\Ordensdeservico`.
 */
class OrdensdeservicoSearch extends Ordensdeservico
{
    /**
     * {@inheritdoc}
     */
    public $param;
    public $from_date;
    public $to_date;
    public $ids;
    public $ano_listagem;
    public function rules()
    {
        return [
            [['id', 'oficio_id', 'contrato_id'], 'integer'],
            [['fase', 'plano', 'datacadastro', 'titulo'], 'safe'],
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
        $query = Ordensdeservico::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);

        (isset($params['OrdensdeservicoSearch'])?$this->load($params):$this->load($params,''));

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'oficio_id' => $this->oficio_id,
            'contrato_id' => $this->contrato_id,
            'datacadastro' => $this->datacadastro,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'fase', $this->fase])
            ->andFilterWhere(['like', 'plano', $this->plano]);
        
        $query->andFilterWhere(['between', 'datacadastro', $this->from_date, $this->to_date]);
        if ($this->ano_listagem != 'all') {
            $query->andFilterWhere([
                'YEAR(datacadastro)' => $this->ano_listagem,
            ]);
        }

        return $dataProvider;
    }
}
