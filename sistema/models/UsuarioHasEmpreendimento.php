<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_has_empreendimento".
 *
 * @property int $usuario_id
 * @property int $empreendimento_id
 *
 * @property Empreendimento $empreendimento
 * @property Usuario $usuario
 */
class UsuarioHasEmpreendimento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_has_empreendimento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'empreendimento_id'], 'required'],
            [['usuario_id', 'empreendimento_id'], 'integer'],
            [['usuario_id', 'empreendimento_id'], 'unique', 'targetAttribute' => ['usuario_id', 'empreendimento_id']],
            [['empreendimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empreendimento::class, 'targetAttribute' => ['empreendimento_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => 'Usuario ID',
            'empreendimento_id' => 'Empreendimento ID',
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
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }
}
