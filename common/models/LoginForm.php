<?php
namespace common\models;

use backend\models\AdminSession;
use backend\models\LoginLog;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $errmsg='';
    private $_user;
    public $mode;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError('username', Yii::t('app', 'Username does not exist.'));
                return false;
            }elseif($user->password_hash=='-'||$user->password_hash=='')
            {
                $this->addError('password', '您没有设置密码，请使用社交账号登录');
                return false;
            } elseif (!$user->validatePassword($this->password)) {
                $this->errmsg="错误的密码";
                $this->addError('password', Yii::t('app', 'Incorrect password.'));
                return false;
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login(){
        if ($this->validate()) {
            $this->errmsg= 123;
            $user = $this->getUser();
           // print_r($user);
            $loginlog=new LoginLog;
            $loginlog->user_id=$this->getUser()->id;
            $loginlog->date=time();
            $loginlog->ip= Yii::$app->request->userIP;
            $loginlog->save();

            $id = $loginlog->user_id;     //登录用户的ID
            $username = $this->username; //登录账号
            $ip = Yii::$app->request->userIP; //登录用户主机IP
            $token = md5(sprintf("%s&%s&%s",$_SERVER['HTTP_USER_AGENT'],$id,$ip));  //将用户登录时的时间、用户ID和IP联合加密成token存入表
            $session = Yii::$app->session;
            $session->set(md5(sprintf("%s&%s",$id,$username)),$token);  //将token存到session变量中
            //？存session token值没必要取键名为$id&$username ,目的是标识用户登录token的键，$id或$username就可以
            //  $client = $_SERVER['HTTP_USER_AGENT'];
            $this->insertSession($id,$token);//将token存到tbl_admin_session
            /*
            if($this->mode!='aaaa'&&($user->authrole=='超级管理员'||$user->authrole=='编辑')){
                $this->errmsg="找不到此账号";
                return false;
            }
            if($user->expire_at>0&&strtotime($user->expire_at)<time())
            {
                //    $name='微信登陆错误';
                $this->errmsg="您的账号已过期，如有需要，请联系18618350803（手机或微信）申请延期。";
                return false;
            }
            */
          //  print_r($this->getUser());

             $state =  Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24  : 0);

             return $state;
               /*
                 print_r(Yii::$app->user->identity);
                var_dump(Yii::$app->user->isGuest);
                exit;
                * */
        }else{
            $this->errmsg= 321;
            return false;
        }
    }
    public function insertSession($id,$sessionToken)
    {
        $loginAdmin = AdminSession::findOne(['id' => $id]); //查询admin_session表中是否有用户的登录记录
        if(!$loginAdmin){ //如果没有记录则新建此记录
            $sessionModel = new AdminSession();
            $sessionModel->id = $id;
            $sessionModel->session_token = $sessionToken;
            $result = $sessionModel->save();
        }else{          //如果存在记录（则说明用户之前登录过）则更新用户登录token
            $loginAdmin->session_token = $sessionToken;
            $result = $loginAdmin->update();
        }
        return $result;
    }
    public function login2()
    {
        if ($this->validate()) {
            print_r($this->getUser());
            exit;
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
