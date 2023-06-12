<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property int $id
 * @property int|null $ordensdeservico_id
 * @property string|null $numero
 * @property string $datacadastro
 * @property string|null $dataedicao
 * @property string|null $data_validade
 * @property string|null $data_renovacao
 * @property string|null $descricao
 * @property int|null $empreendimento_id
 * @property string|null $fase
 * @property int|null $produto_id
 *
 * @property Arquivo[] $arquivos
 * @property Empreendimento $empreendimento
 * @property Ordensdeservico $ordensdeservico
 * @property Produto $produto
 * @property Produto[] $produtos
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ordensdeservico_id', 'empreendimento_id', 'produto_id'], 'integer'],
            [['descricao'], 'string'],
            [['numero', 'datacadastro', 'dataedicao', 'data_validade', 'data_renovacao'], 'string', 'max' => 45],
            [['fase'], 'string', 'max' => 150],
            [['ordensdeservico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ordensdeservico::class, 'targetAttribute' => ['ordensdeservico_id' => 'id']],
            [['empreendimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empreendimento::class, 'targetAttribute' => ['empreendimento_id' => 'id']],
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
            'ordensdeservico_id' => 'Ordensdeservico ID',
            'numero' => 'Numero',
            'datacadastro' => 'Datacadastro',
            'dataedicao' => 'Dataedicao',
            'data_validade' => 'Data Validade',
            'data_renovacao' => 'Data Renovacao',
            'descricao' => 'Descricao',
            'empreendimento_id' => 'Empreendimento ID',
            'fase' => 'Fase',
            'produto_id' => 'Produto ID',
        ];
    }

    /**
     * Gets query for [[Arquivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArquivos()
    {
        return $this->hasMany(Arquivo::class, ['produto_id' => 'id']);
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
     * Gets query for [[Ordensdeservico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrdensdeservico()
    {
        return $this->hasOne(Ordensdeservico::class, ['id' => 'ordensdeservico_id']);
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

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['produto_id' => 'id']);
    }
}
