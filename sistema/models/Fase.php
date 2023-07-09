<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fase".
 *
 * @property int $id
 * @property int $empreendimento_id
 * @property string $fase
 * @property string $datacadastro
 * @property string|null $data
 * @property string|null $exigencias
 * @property string|null $ambito
 * @property string|null $status
 *
 * @property Empreendimento $empreendimento
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
            [['empreendimento_id', 'fase'], 'required'],
            [['empreendimento_id'], 'integer'],
            [['datacadastro', 'data'], 'safe'],
            [['fase', 'exigencias', 'ambito', 'status'], 'string', 'max' => 200],
            [['empreendimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empreendimento::class, 'targetAttribute' => ['empreendimento_id' => 'id']],
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
}
