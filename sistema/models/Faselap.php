<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fase_lap".
 *
 * @property int $id
 * @property string|null $st_descricao
 * @property int|null $orgao
 * @property int|null $bl_ativo
 *
 * @property Fase[] $fases
 */
class Faselap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fase_lap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orgao', 'bl_ativo'], 'integer'],
            [['st_descricao'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'st_descricao' => 'St Descricao',
            'orgao' => 'Orgao',
            'bl_ativo' => 'Bl Ativo',
        ];
    }

    /**
     * Gets query for [[Fases]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFases()
    {
        return $this->hasMany(Fase::class, ['fase_lap_id' => 'id']);
    }
}
