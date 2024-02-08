<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensagem_has_oficio".
 *
 * @property int $mensagem_id
 * @property int $oficio_id
 *
 * @property Mensagem $mensagem
 * @property Oficio $oficio
 */
class MensagemOficio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensagem_has_oficio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mensagem_id', 'oficio_id'], 'required'],
            [['mensagem_id', 'oficio_id'], 'integer'],
            [['mensagem_id', 'oficio_id'], 'unique', 'targetAttribute' => ['mensagem_id', 'oficio_id']],
            [['mensagem_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mensagem::class, 'targetAttribute' => ['mensagem_id' => 'id']],
            [['oficio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Oficio::class, 'targetAttribute' => ['oficio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mensagem_id' => 'Mensagem ID',
            'oficio_id' => 'Oficio ID',
        ];
    }

    /**
     * Gets query for [[Mensagem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensagem()
    {
        return $this->hasOne(Mensagem::class, ['id' => 'mensagem_id']);
    }

    /**
     * Gets query for [[Oficio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOficio()
    {
        return $this->hasOne(Oficio::class, ['id' => 'oficio_id']);
    }
}
