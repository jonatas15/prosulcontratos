<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Oficio;

/**
 * OficioSearch represents the model behind the search form of `app\models\Oficio`.
 */
class OficioSearch extends Oficio
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
            [['id', 'contrato_id', 'emprrendimento_id'], 'integer'],
            [['tipo', 'emprrendimento_desc', 'datacadastro', 'data', 'fluxo', 'emissor', 'receptor', 'num_processo', 'num_protocolo', 'Num_sei', 'assunto', 'diretorio', 'status'], 'safe'],
            [['from_date', 'to_date', 'ano_listagem'], 'safe'],
            [['ids', ], 'safe'],
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
        $query = Oficio::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'data' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);

        // $this->load($params);
        (isset($params['OficioSearch'])?$this->load($params):$this->load($params,''));

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'contrato_id' => $this->contrato_id,
            'emprrendimento_id' => $this->emprrendimento_id,
            'datacadastro' => $this->datacadastro,
            'data' => $this->data,
            'tipo' => $this->tipo,
            'status' => $this->status, 
        ]);

        $query->andFilterWhere(['like', 'emprrendimento_desc', $this->emprrendimento_desc])
            ->andFilterWhere(['like', 'fluxo', $this->fluxo])
            ->andFilterWhere(['like', 'emissor', $this->emissor])
            ->andFilterWhere(['like', 'receptor', $this->receptor])
            ->andFilterWhere(['like', 'num_processo', $this->num_processo])
            ->andFilterWhere(['like', 'num_protocolo', $this->num_protocolo])
            ->andFilterWhere(['like', 'Num_sei', $this->Num_sei])
            ->andFilterWhere(['like', 'assunto', $this->assunto])
            ->andFilterWhere(['like', 'diretorio', $this->diretorio]);
        
        $query->andFilterWhere(['between', 'data', $this->from_date, $this->to_date]);
        if ($this->ano_listagem != 'all') {
            $query->andFilterWhere([
                'YEAR(data)' => $this->ano_listagem,
            ]);
        }

        return $dataProvider;
    }
}
