<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property int $id
 * @property int|null $contrato_id
 * @property int|null $produto_id
 * @property int|null $empreendimento_id
 * @property int|null $ordensdeservico_id
 * @property string|null $numero
 * @property string|null $subproduto
 * @property string $datacadastro
 * @property string|null $data_validade
 * @property string|null $data_renovacao
 * @property string|null $data_entrega
 * @property string|null $fase
 * @property string|null $entrega
 * @property string|null $servico
 * @property string|null $descricao
 * @property string|null $aprov_data
 * @property int|null $aprov_tempo_ultima_revisao
 * @property int|null $aprov_tempo_total
 * @property string|null $aprov_versao
 * @property string|null $diretorio_texto
 * @property string|null $diretorio_link
 *
 * @property Contrato $contrato 
 * @property Arquivo[] $arquivos
 * @property Empreendimento $empreendimento
 * @property Ordensdeservico $ordensdeservico
 * @property Produto $produto
 * @property Produto[] $produtos
 * @property Revisao[] $revisaos
 * @property Impacto[] $revisaos
 */
class Produto extends \yii\db\ActiveRecord
{
    public $numero_sei;
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
            [['contrato_id', 'produto_id', 'empreendimento_id', 'ordensdeservico_id', 'aprov_tempo_ultima_revisao', 'aprov_tempo_total'], 'integer'],
            [['datacadastro', 'data_validade', 'data_renovacao', 'data_entrega', 'aprov_data'], 'safe'],
            [['entrega', 'servico', 'subproduto', 'descricao', 'diretorio_link'], 'string'],
            [['numero', 'aprov_versao'], 'string', 'max' => 45],
            [['fase'], 'string', 'max' => 150],
            [['diretorio_texto'], 'string', 'max' => 250],
            [['ordensdeservico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ordensdeservico::class, 'targetAttribute' => ['ordensdeservico_id' => 'id']],
            [['contrato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::class, 'targetAttribute' => ['contrato_id' => 'id']], 
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
            'produto_id' => 'Produto',
            'empreendimento_id' => 'Empreendimento',
            'ordensdeservico_id' => 'Ordem de serviço',
            'numero' => 'SEI (Revisões)',
            'datacadastro' => 'Data de registro',
            'data_validade' => 'Data de Validade',
            'data_renovacao' => 'Data de Renovação',
            'data_entrega' => 'Entregue em',
            'fase' => 'Fase',
            'entrega' => 'Entrega',
            'servico' => 'Serviço',
            'descricao' => 'Descrição',
            'aprov_data' => 'Aprovado em',
            'aprov_tempo_ultima_revisao' => 'Tempo da última aprovação',
            'aprov_tempo_total' => 'Tempo total',
            'aprov_versao' => 'Versão de Aprovação',
            'diretorio_texto' => 'Diretório: Texto',
            'diretorio_link' => 'Diretório: Link',
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

    /**
     * Gets query for [[Revisaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRevisaos()
    {
        return $this->hasMany(Revisao::class, ['produto_id' => 'id']);
    }
    
    /**
     * Gets query for [[Impacto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImpacto()
    {
        return $this->hasOne(Impacto::class, ['produto_id' => 'id']);
    }
}
