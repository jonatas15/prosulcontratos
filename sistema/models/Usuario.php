<?php
/**
 * 
 Tentativa
 Mudar campos para username e password
 */
 
namespace app\models;

use Yii;

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
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    /**
     * {@inheritdoc}
     */
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
            [['nivel'], 'string'],
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
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }

        return null;
    }

    

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        // foreach (self::$users as $user) {
        //     if (strcasecmp($user['login'], $username) === 0) {
        //         return new static($user);
        //     }
        // }

        // return null;
        return self::findOne(['login' => $username]);
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
        // return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        // return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->senha === $password;
    }
}
