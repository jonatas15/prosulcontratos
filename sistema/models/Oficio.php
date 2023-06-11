<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oficio".
 *
 * @property int $id
 * @property int $contrato_id
 * @property int|null $emprrendimento_id
 * @property string|null $tipo
 * @property string|null $emprrendimento_desc
 * @property string $datacadastro
 * @property string|null $data
 * @property string|null $fluxo
 * @property string|null $emissor
 * @property string|null $receptor
 * @property string|null $num_processo
 * @property string|null $num_protocolo
 * @property string|null $Num_sei
 * @property string|null $assunto
 * @property string|null $diretorio
 * @property string|null $status
 *
 * @property Arquivo[] $arquivos
 * @property Contrato $contrato
 * @property Empreendimento[] $empreendimentos
 * @property Empreendimento $emprrendimento
 * @property Ordensdeservico[] $ordensdeservicos
 */
class Oficio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oficio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contrato_id'], 'required'],
            [['contrato_id', 'emprrendimento_id'], 'integer'],
            [['datacadastro', 'data'], 'safe'],
            [['assunto'], 'string'],
            [['tipo'], 'string', 'max' => 45],
            [['emprrendimento_desc'], 'string', 'max' => 150],
            [['fluxo', 'emissor', 'receptor', 'num_processo', 'num_protocolo', 'Num_sei'], 'string', 'max' => 200],
            [['diretorio'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 30],
            [['contrato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::class, 'targetAttribute' => ['contrato_id' => 'id']],
            [['emprrendimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empreendimento::class, 'targetAttribute' => ['emprrendimento_id' => 'id']],
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
            'emprrendimento_id' => 'Emprrendimento ID',
            'tipo' => 'Tipo',
            'emprrendimento_desc' => 'Emprrendimento Desc',
            'datacadastro' => 'Datacadastro',
            'data' => 'Data',
            'fluxo' => 'Fluxo',
            'emissor' => 'Emissor',
            'receptor' => 'Receptor',
            'num_processo' => 'Num Processo',
            'num_protocolo' => 'Num Protocolo',
            'Num_sei' => 'Num Sei',
            'assunto' => 'Assunto',
            'diretorio' => 'Diretorio',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Arquivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArquivos()
    {
        return $this->hasMany(Arquivo::class, ['oficio_id' => 'id']);
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
        return $this->hasMany(Empreendimento::class, ['oficio_id' => 'id']);
    }

    /**
     * Gets query for [[Emprrendimento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmprrendimento()
    {
        return $this->hasOne(Empreendimento::class, ['id' => 'emprrendimento_id']);
    }

    /**
     * Gets query for [[Ordensdeservicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrdensdeservicos()
    {
        return $this->hasMany(Ordensdeservico::class, ['oficio_id' => 'id']);
    }
}
