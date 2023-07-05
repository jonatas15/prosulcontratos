<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empreendimento".
 *
 * @property int $id
 * @property string $titulo
 * @property int|null $prazo
 * @property string $datacadastro
 * @property string|null $dataupdate
 * @property string|null $status
 * @property string|null $uf
 * @property string|null $segmento
 * @property float|null $extensao_km
 * @property string|null $tipo_obra
 * @property string|null $municipios_interceptados
 * @property string|null $orgao_licenciador
 * @property int|null $ordensdeservico_id
 * @property int|null $oficio_id
 *
 * @property Arquivo[] $arquivos
 * @property Licenciamento[] $licenciamentos
 * @property Oficio $oficio
 * @property Oficio[] $oficios
 * @property Ordensdeservico $ordensdeservico
 * @property Produto[] $produtos
 */
class Empreendimento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empreendimento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prazo', 'ordensdeservico_id', 'oficio_id'], 'integer'],
            [['datacadastro', 'dataupdate'], 'safe'],
            [['extensao_km'], 'number'],
            [['municipios_interceptados'], 'string'],
            [['status'], 'string', 'max' => 25],
            [['uf'], 'string', 'max' => 3],
            [['segmento'], 'string', 'max' => 100],
            [['titulo'], 'string', 'max' => 300],
            [['tipo_obra'], 'string', 'max' => 250],
            [['orgao_licenciador'], 'string', 'max' => 200],
            [['oficio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Oficio::class, 'targetAttribute' => ['oficio_id' => 'id']],
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
            'prazo' => 'Prazo',
            'datacadastro' => 'Data de Registro',
            'dataupdate' => 'Data de Atualização',
            'status' => 'Status',
            'uf' => 'UF',
            'segmento' => 'Segmento',
            'extensao_km' => 'Extensão (Km)',
            'tipo_obra' => 'Tipo de Obra',
            'municipios_interceptados' => 'Municípios Interceptados',
            'orgao_licenciador' => 'Órgao Licenciador',
            'ordensdeservico_id' => 'Ordem de servico',
            'oficio_id' => 'Ofício',
        ];
    }

    /**
     * Gets query for [[Arquivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArquivos()
    {
        return $this->hasMany(Arquivo::class, ['empreendimento_id' => 'id']);
    }

    /**
     * Gets query for [[Licenciamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLicenciamentos()
    {
        return $this->hasMany(Licenciamento::class, ['empreendimento_id' => 'id']);
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
        return $this->hasMany(Oficio::class, ['emprrendimento_id' => 'id']);
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
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['empreendimento_id' => 'id']);
    }
}
