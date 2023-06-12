<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordensdeservico".
 *
 * @property int $id
 * @property int|null $oficio_id
 * @property string|null $fase
 * @property string|null $plano
 * @property int $contrato_id
 * @property string $datacadastro
 *
 * @property Arquivo[] $arquivos
 * @property Contrato $contrato
 * @property Empreendimento[] $empreendimentos
 * @property Licenciamento[] $licenciamentos
 * @property Oficio $oficio
 * @property Produto[] $produtos
 */
class Ordensdeservico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordensdeservico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oficio_id', 'contrato_id'], 'integer'],
            [['fase', 'plano'], 'string'],
            [['contrato_id'], 'required'],
            [['datacadastro'], 'safe'],
            [['contrato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::class, 'targetAttribute' => ['contrato_id' => 'id']],
            [['oficio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Oficio::class, 'targetAttribute' => ['oficio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'oficio_id' => 'Oficio ID',
            'fase' => 'Fase',
            'plano' => 'Plano',
            'contrato_id' => 'Contrato ID',
            'datacadastro' => 'Datacadastro',
        ];
    }

    /**
     * Gets query for [[Arquivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArquivos()
    {
        return $this->hasMany(Arquivo::class, ['ordensdeservico_id' => 'id']);
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
     * Gets query for [[Empreendimentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpreendimentos()
    {
        return $this->hasMany(Empreendimento::class, ['ordensdeservico_id' => 'id']);
    }

    /**
     * Gets query for [[Licenciamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLicenciamentos()
    {
        return $this->hasMany(Licenciamento::class, ['ordensdeservico_id' => 'id']);
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
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['ordensdeservico_id' => 'id']);
    }
}
