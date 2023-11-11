<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fase".
 *
 * @property int $id
 * @property int|null $empreendimento_id
 * @property int $licenciamento_id
 * @property string $fase
 * @property string|null $datacadastro
 * @property string|null $data
 * @property string|null $exigencias
 * @property string|null $ambito
 * @property string|null $status
 * @property int|null $ordem
 * @property int|null $produto_id
 * @property int|null $fase_lai_id
 * @property int|null $fase_lap_id
 * @property int|null $ativo
 *
 * @property Empreendimento $empreendimento
 * @property FaseLai $faseLai
 * @property FaseLap $faseLap
 * @property Licenciamento $licenciamento
 */
class Fase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empreendimento_id', 'licenciamento_id', 'ordem', 'produto_id', 'fase_lai_id', 'fase_lap_id', 'ativo', 'fase_id'], 'integer'],
            [['licenciamento_id', 'fase'], 'required'],
            [['datacadastro', 'data'], 'safe'],
            [['fase', 'exigencias', 'ambito', 'status', 'natureza'], 'string', 'max' => 200],
            [['empreendimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empreendimento::class, 'targetAttribute' => ['empreendimento_id' => 'id']],
            [['fase_lai_id'], 'exist', 'skipOnError' => true, 'targetClass' => FaseLai::class, 'targetAttribute' => ['fase_lai_id' => 'id']],
            [['fase_lap_id'], 'exist', 'skipOnError' => true, 'targetClass' => FaseLap::class, 'targetAttribute' => ['fase_lap_id' => 'id']],
            [['licenciamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Licenciamento::class, 'targetAttribute' => ['licenciamento_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empreendimento_id' => 'Empreendimento ID',
            'licenciamento_id' => 'Licenciamento ID',
            'fase' => 'Fase',
            'datacadastro' => 'Última Alteração',
            'data' => 'Ativação',
            'exigencias' => 'Exigencias',
            'ambito' => 'Ambito',
            'status' => 'Status',
            'ordem' => 'Ordem',
            'produto_id' => 'Produtos',
            'fase_lai_id' => 'Fase Lai ID',
            'fase_lap_id' => 'Fase Lap ID',
        ];
    }

    /**
     * Gets query for [[Empreendimento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpreendimento()
    {
        return $this->hasOne(Empreendimento::class, ['id' => 'empreendimento_id']);
    }
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }

    /**
     * Gets query for [[FaseLai]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaseLai()
    {
        return $this->hasOne(FaseLai::class, ['id' => 'fase_lai_id']);
    }

    /**
     * Gets query for [[FaseLap]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaseLap()
    {
        return $this->hasOne(FaseLap::class, ['id' => 'fase_lap_id']);
    }

    /**
     * Gets query for [[Licenciamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLicenciamento()
    {
        return $this->hasOne(Licenciamento::class, ['id' => 'licenciamento_id']);
    }
}
