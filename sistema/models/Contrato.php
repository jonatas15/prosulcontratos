<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contrato".
 *
 * @property int $id
 * @property string $titulo
 * @property string $datacadastro
 * @property string|null $dataupdate
 * @property string|null $icone
 * @property string|null $obs
 * @property string|null $lote
 * @property string|null $objeto
 * @property string|null $num_edital
 * @property string|null $empresa_executora
 * @property string|null $data_assinatura
 * @property string|null $data_final
 * @property float|null $saldo_prazo
 * @property float|null $valor_total
 * @property float|null $valor_faturado
 * @property float|null $saldo_contrato
 * @property float|null $valor_empenhado
 * @property float|null $saldo_empenho
 * @property string|null $data_base
 * @property string|null $vigencia
 *
 * @property Arquivo[] $arquivos
 * @property Oficio[] $oficios
 * @property Oficio[] $produtos
 * @property Ordensdeservico[] $ordensdeservicos
 * @property Placemark[] $placemarks
 */
class Contrato extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contrato';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['datacadastro', 'dataupdate', 'data_assinatura', 'data_final', 'data_base', 'vigencia'], 'safe'],
            [['icone', 'obs', 'lote'], 'string'],
            [['saldo_prazo', 'valor_total', 'valor_faturado', 'saldo_contrato', 'valor_empenhado', 'saldo_empenho'], 'number'],
            [['titulo'], 'string', 'max' => 45],
            [['objeto', 'num_edital'], 'string', 'max' => 250],
            [['empresa_executora'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'datacadastro' => 'Datacadastro',
            'dataupdate' => 'Dataupdate',
            'icone' => 'Icone',
            'obs' => 'Obs',
            'lote' => 'Lote',
            'objeto' => 'Objeto',
            'num_edital' => 'Num Edital',
            'empresa_executora' => 'Empresa Executora',
            'data_assinatura' => 'Data Assinatura',
            'data_final' => 'Data Final',
            'saldo_prazo' => 'Saldo Prazo',
            'valor_total' => 'Valor Total',
            'valor_faturado' => 'Valor Faturado',
            'saldo_contrato' => 'Saldo Contrato',
            'valor_empenhado' => 'Valor Empenhado',
            'saldo_empenho' => 'Saldo Empenho',
            'data_base' => 'Data Base',
            'vigencia' => 'Vigencia',
        ];
    }

    /**
     * Gets query for [[Arquivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArquivos()
    {
        return $this->hasMany(Arquivo::class, ['contrato_id' => 'id']);
    }

    /**
     * Gets query for [[Oficios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOficios()
    {
        return $this->hasMany(Oficio::class, ['contrato_id' => 'id']);
    }
    
    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['contrato_id' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImpacto()
    {
        return $this->hasMany(Impacto::class, ['contrato_id' => 'id']);
    }

    /**
     * Gets query for [[Ordensdeservicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrdensdeservicos()
    {
        return $this->hasMany(Ordensdeservico::class, ['contrato_id' => 'id']);
    }

    /**
     * Gets query for [[Placemarks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlacemarks()
    {
        return $this->hasMany(Placemark::class, ['contrato_id' => 'id']);
    }
}
