<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "impacto_empreendimento".
 *
 * @property int $impacto_id
 * @property int $empreendimento_id
 * @property int $impactos
 *
 * @property Empreendimento $empreendimento
 * @property Impacto $impacto
 */
class ImpactoEmpreendimento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'impacto_empreendimento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['impacto_id', 'empreendimento_id'], 'required'],
            [['impacto_id', 'empreendimento_id', 'impactos'], 'integer'],
            [['impacto_id', 'empreendimento_id'], 'unique', 'targetAttribute' => ['impacto_id', 'empreendimento_id']],
            [['empreendimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empreendimento::class, 'targetAttribute' => ['empreendimento_id' => 'id']],
            [['impacto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Impacto::class, 'targetAttribute' => ['impacto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'impacto_id' => 'Impacto ID',
            'empreendimento_id' => 'Empreendimento ID',
            'impactos' => 'Impactos',
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
     * Gets query for [[Impacto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImpacto()
    {
        return $this->hasOne(Impacto::class, ['id' => 'impacto_id']);
    }
}
