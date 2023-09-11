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
 * @property string $datacadastro
 * @property string|null $data
 * @property string|null $exigencias
 * @property string|null $ambito
 * @property string|null $status
 * @property int|null $ordem
 *
 * @property Empreendimento $empreendimento
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
            [['empreendimento_id', 'licenciamento_id', 'ordem'], 'integer'],
            [['licenciamento_id', 'fase'], 'required'],
            [['datacadastro', 'data'], 'safe'],
            [['fase', 'exigencias', 'ambito', 'status'], 'string', 'max' => 200],
            [['empreendimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empreendimento::class, 'targetAttribute' => ['empreendimento_id' => 'id']],
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
            'datacadastro' => 'Datacadastro',
            'data' => 'Data',
            'exigencias' => 'Exigencias',
            'ambito' => 'Ambito',
            'status' => 'Status',
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
