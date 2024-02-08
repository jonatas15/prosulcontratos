<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensagem".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int|null $contrato_id
 * @property int|null $oficio_id
 * @property string $datacadastro
 * @property string $texto
 *
 * @property Contrato $contrato
 * @property MensagemHasOficio[] $mensagemHasOficios
 * @property Oficio $oficio
 * @property Oficio[] $oficios
 * @property Usuario $usuario
 */
class Mensagem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensagem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'texto'], 'required'],
            [['usuario_id', 'contrato_id', 'oficio_id'], 'integer'],
            [['datacadastro'], 'safe'],
            [['texto'], 'string'],
            [['contrato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::class, 'targetAttribute' => ['contrato_id' => 'id']],
            [['oficio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Oficio::class, 'targetAttribute' => ['oficio_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'contrato_id' => 'Contrato ID',
            'oficio_id' => 'Oficio ID',
            'datacadastro' => 'Datacadastro',
            'texto' => 'Texto',
        ];
    }

    /**
     * Gets query for [[Contrato]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContrato()
    {
        return $this->hasOne(Contrato::class, ['id' => 'contrato_id']);
    }

    /**
     * Gets query for [[MensagemHasOficios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensagemHasOficios()
    {
        return $this->hasMany(MensagemHasOficio::class, ['mensagem_id' => 'id']);
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

    /**
     * Gets query for [[Oficios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOficios()
    {
        return $this->hasMany(Oficio::class, ['id' => 'oficio_id'])->viaTable('mensagem_has_oficio', ['mensagem_id' => 'id']);
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
