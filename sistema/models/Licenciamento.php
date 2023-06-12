<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "licenciamento".
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
 *
 * @property Arquivo[] $arquivos
 * @property Empreendimento $empreendimento
 * @property Ordensdeservico $ordensdeservico
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
            [['ordensdeservico_id', 'empreendimento_id'], 'integer'],
            [['descricao'], 'string'],
            [['numero', 'datacadastro', 'dataedicao', 'data_validade', 'data_renovacao'], 'string', 'max' => 45],
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
            'ordensdeservico_id' => 'Ordensdeservico ID',
            'numero' => 'Numero',
            'datacadastro' => 'Datacadastro',
            'dataedicao' => 'Dataedicao',
            'data_validade' => 'Data Validade',
            'data_renovacao' => 'Data Renovacao',
            'descricao' => 'Descricao',
            'empreendimento_id' => 'Empreendimento ID',
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
}
