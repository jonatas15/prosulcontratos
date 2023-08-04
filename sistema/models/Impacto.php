<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "impacto".
 *
 * @property int $id
 * @property int $contrato_id
 * @property string $produto
 * @property string $servico
 * @property string|null $numeroitem
 * @property int|null $produto_id
 * @property string $unidade
 * @property int|null $quantidade_a
 * @property int|null $quantidade_utilizada
 * @property int|null $qt_restante_real
 * @property int|null $qt_restante
 * @property float|null $preco_unitario
 * @property float|null $custos_diretos
 * @property float|null $custos_indiretos
 * @property float|null $custo_total
 * @property float|null $custo_utilizado
 * @property float|null $saldo_restante
 * @property float|null $custo_real
 *
 * @property Contrato $contrato
 * @property Empreendimento[] $empreendimentos
 * @property ImpactoEmpreendimento[] $impactoEmpreendimentos
 * @property Produto $produto0
 */
class Impacto extends \yii\db\ActiveRecord
{
    /**
     * Superglobais e contadores
     */
    public $contaservicos = 0;
    public $x = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'impacto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contrato_id', 'produto', 'servico', 'unidade'], 'required'],
            [['contrato_id', 'produto_id', 'quantidade_a', 'quantidade_utilizada', 'qt_restante_real', 'qt_restante'], 'integer'],
            [['produto', 'servico'], 'string'], 
            [['preco_unitario', 'custos_diretos', 'custos_indiretos', 'custo_total', 'custo_utilizado', 'saldo_restante', 'custo_real'], 'number'],
            [['unidade'], 'string', 'max' => 300], 
            [['numeroitem'], 'string', 'max' => 10],
            [['contrato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::class, 'targetAttribute' => ['contrato_id' => 'id']],
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
            'contrato_id' => 'Contrato ID',
            'produto' => 'Produto',
            'servico' => 'Serviço',
            'numeroitem' => 'Número do Ítem (Serviço)',
            'produto_id' => 'Produto ID',
            'unidade' => 'Unidade',
            'quantidade_a' => 'Qt. Total do Contrato',
            'quantidade_utilizada' => 'Qt. Utilizada',
            'qt_restante_real' => 'Qt. Restante Real (OSE)',
            'qt_restante' => 'Qt. Restante',
            'preco_unitario' => 'Preço Unitário',
            'custos_diretos' => 'Custos Diretos',
            'custos_indiretos' => 'Custos Indiretos',
            'custo_total' => 'Custo Total',
            'custo_utilizado' => 'Custo Utilizado',
            'saldo_restante' => 'Saldo Restante',
            'custo_real' => 'Custo Real',
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
     * Gets query for [[Empreendimentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpreendimentos()
    {
        return $this->hasMany(Empreendimento::class, ['id' => 'empreendimento_id'])->viaTable('impacto_empreendimento', ['impacto_id' => 'id']);
    }

    /**
     * Gets query for [[ImpactoEmpreendimentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImpactoEmpreendimentos()
    {
        return $this->hasMany(ImpactoEmpreendimento::class, ['impacto_id' => 'id']);
    }

    /**
     * Gets query for [[Produto0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto0()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }
}
