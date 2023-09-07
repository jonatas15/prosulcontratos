<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "licenciamento".
 *
 * @property int $id
 * @property int|null $contrato_id
 * @property int|null $empreendimento_id
 * @property int|null $ordensdeservico_id
 * @property string|null $numero
 * @property string $datacadastro
 * @property string|null $dataedicao
 * @property string|null $data_validade
 * @property string|null $data_renovacao
 * @property string|null $descricao
 *
 * @property Arquivo[] $arquivos
 * @property Empreendimento $empreendimento
 * @property Ordensdeservico $ordensdeservico
 * @property Contrato $contrato
 */
class Licenciamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'licenciamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ordensdeservico_id', 'empreendimento_id', 'contrato_id'], 'integer'],
            [['descricao'], 'string'],
            [['numero', 'datacadastro', 'dataedicao', 'data_validade', 'data_renovacao'], 'string', 'max' => 45],
            [['contrato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::class, 'targetAttribute' => ['contrato_id' => 'id']],
            [['empreendimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empreendimento::class, 'targetAttribute' => ['empreendimento_id' => 'id']],
            [['ordensdeservico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ordensdeservico::class, 'targetAttribute' => ['ordensdeservico_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ordensdeservico_id' => 'O.Serviço',
            'numero' => 'Licenciamento',
            'datacadastro' => 'Registro',
            'dataedicao' => 'Edição',
            'data_validade' => 'Validade',
            'data_renovacao' => 'Renovação',
            'descricao' => 'Descrição',
            'empreendimento_id' => 'Empreendimento',
        ];
    }

    /**
     * Gets query for [[Arquivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArquivos()
    {
        return $this->hasMany(Arquivo::class, ['licenciamento_id' => 'id']);
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
     * Gets query for [[Contrato]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */ 
   public function getContrato() 
   { 
       return $this->hasOne(Contrato::class, ['id' => 'contrato_id']); 
   }
   /**
     * Gets query for [[Licenciamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFases()
    {
        return $this->hasMany(Fase::class, ['licenciamento_id' => 'id']);
    }
}
