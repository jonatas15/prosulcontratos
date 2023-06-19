<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "arquivo".
 *
 * @property int $id
 * @property string $tipo
 * @property string $datacadastro
 * @property string $src
 * @property int|null $contrato_id
 * @property int|null $oficio_id
 * @property int|null $ordensdeservico_id
 * @property int|null $empreendimento_id
 * @property int|null $produto_id
 * @property int|null $licenciamento_id
 * @property string|null $pasta
 * @property string|null $ref
 *
 * @property Contrato $contrato
 * @property Empreendimento $empreendimento
 * @property Licenciamento $licenciamento
 * @property Oficio $oficio
 * @property Ordensdeservico $ordensdeservico
 * @property Produto $produto
 */
class Arquivo extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arquivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'src'], 'required'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 
                'extensions' => 'png, jpg, jpeg, tif, doc, pdf, odt, docx, xls, xlsx',
                'maxFiles' => 5
            ],
            [['tipo', 'src'], 'string'],
            [['datacadastro'], 'safe'],
            [['contrato_id', 'oficio_id', 'ordensdeservico_id', 'empreendimento_id', 'produto_id', 'licenciamento_id'], 'integer'],
            [['pasta'], 'string', 'max' => 45],
            [['ref'], 'string', 'max' => 250],
            [['contrato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::class, 'targetAttribute' => ['contrato_id' => 'id']],
            [['empreendimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empreendimento::class, 'targetAttribute' => ['empreendimento_id' => 'id']],
            [['licenciamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Licenciamento::class, 'targetAttribute' => ['licenciamento_id' => 'id']],
            [['oficio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Oficio::class, 'targetAttribute' => ['oficio_id' => 'id']],
            [['ordensdeservico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ordensdeservico::class, 'targetAttribute' => ['ordensdeservico_id' => 'id']],
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
            'tipo' => 'Tipo',
            'datacadastro' => 'Datacadastro',
            'src' => 'Src',
            'contrato_id' => 'Contrato ID',
            'oficio_id' => 'Oficio ID',
            'ordensdeservico_id' => 'Ordensdeservico ID',
            'empreendimento_id' => 'Empreendimento ID',
            'produto_id' => 'Produto ID',
            'licenciamento_id' => 'Licenciamento ID',
            'pasta' => 'Pasta',
            'ref' => 'Ref',
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
     * Gets query for [[Empreendimento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpreendimento()
    {
        return $this->hasOne(Empreendimento::class, ['id' => 'empreendimento_id']);
    }

    /**
     * Gets query for [[Licenciamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLicenciamento()
    {
        return $this->hasOne(Licenciamento::class, ['id' => 'licenciamento_id']);
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
     * Uploads de Arquivos
     */
    public function upload()
    {
        // $model = Arquivo::findOne(['id' => $id]);
        if ($this->validate()) { 
            foreach ($this->imageFiles as $file) {
                $file->saveAs('arquivos/' . $this->clean($file->baseName) . '.' . $this->clean($file->extension));
            }
            return true;
        } else {
            return false;
        }
    }
    protected function clean($string) {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string = preg_replace('/-+/', '_', $string); // Replaces multiple hyphens with single one.
        $string = strtolower($string);
        return $string;
     }
}
