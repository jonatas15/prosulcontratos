<?php
/**
 * 
 Tentativa
 Mudar campos para username e password
 */
 
namespace app\models;

use Yii;

use yii\web\UploadedFile;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $telefone
 * @property string|null $email
 * @property string|null $cpf
 * @property string|null $nivel
 * @property string|null $login
 * @property string|null $senha
 *
 * @property Contrato[] $contratos
 * @property UsuarioHasContrato[] $usuarioHasContratos
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    // public $id;
    // public $username;
    // public $password;
    // public $authKey;
    // public $accessToken;
    /**
     * {@inheritdoc}
     */

    public $imageFile;

    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nivel', 'foto'], 'string'],
            [['nivel', 'nome', 'email', 'login', 'senha'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['nome', 'email'], 'string', 'max' => 200],
            [['telefone', 'cpf'], 'string', 'max' => 15],
            [['login'], 'string', 'max' => 20],
            [['senha'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'email' => 'Email',
            'cpf' => 'Cpf',
            'nivel' => 'Nivel',
            'login' => 'Login',
            'senha' => 'Senha',
            'imageFile' => 'Foto do Usuário (apenas *png e *.jpg)'
        ];
    }

    /**
     * Gets query for [[Contratos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasMany(Contrato::class, ['id' => 'contrato_id'])->viaTable('usuario_has_contrato', ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[UsuarioHasContratos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioHasContratos()
    {
        return $this->hasMany(UsuarioHasContrato::class, ['usuario_id' => 'id']);
    }
     /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new  yii\base\UnknownPropertyException();
    }
 
        /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
 
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        // throw new  yii\base\UnknownPropertyException();
    }


    public function validateAuthKey($authKey)
    {
        // throw new  yii\base\UnknownPropertyException();
    }


    public static function findByUsername($username){
        return self::findOne(['login'=>$username]);
    }
 
    public function validatePassword($password)
    {
        return $this->senha === $password;
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('usuarios/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

}
