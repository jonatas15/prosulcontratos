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
 * @property string|null $numero_sei
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
    // Variáveis do Jonatas
    public $daysBetween = '';
    public $orgao_grupo;
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
            [['datacadastro', 'data', 'daysBetween', 'orgao_grupo'], 'safe'],
            [['fase', 'exigencias', 'ambito', 'status', 'natureza', 'numero_sei'], 'string', 'max' => 200],
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
            'datacadastro' => 'Atualização',
            'data' => 'Início',
            'exigencias' => 'Exigencias',
            'ambito' => 'Órgão',
            'status' => 'Status',
            'ordem' => 'Ordem',
            'produto_id' => 'Produtos',
            'fase_lai_id' => 'Fase Lai ID',
            'fase_lap_id' => 'Fase Lap ID',
            'numero_sei' => 'Nº SEI',
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
