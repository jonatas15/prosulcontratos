<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "revisao".
 *
 * @property int $id
 * @property int $produto_id
 * @property string $titulo
 * @property string|null $data
 * @property int|null $tempo_ultima_etapa
 * @property string|null $responsavel
 * @property string|null $status
 *
 * @property Produto $produto
 */
class Revisao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'revisao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produto_id', 'titulo'], 'required'],
            [['produto_id', 'tempo_ultima_etapa'], 'integer'],
            [['data'], 'safe'],
            [['titulo'], 'string', 'max' => 100],
            [['responsavel', 'status'], 'string', 'max' => 45],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produto_id' => 'Produto ID',
            'titulo' => 'Titulo',
            'data' => 'Data',
            'tempo_ultima_etapa' => 'Tempo Ultima Etapa',
            'responsavel' => 'Responsavel',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }
}
