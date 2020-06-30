<?php
namespace common\components;
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers:x-requested-with,content-type,Access-token');
header("Access-Control-Allow-Methods: POST,GET，OPTIONS");
use Yii;
use yii\web\Controller;
use backend\modules\editor\models\UserLog;
use backend\modules\topuser\models\Topuser;
use backend\models\AdminSession;
use yii\web\Cookie;
use yii\helpers\Url;
use yii\web\HttpException;
class BaseController extends Controller
{
    
public $enableCsrfValidation = false;
	public function init()
    {
        $this->setLanguage();

        if (!\Yii::$app->user->isGuest) {

        }

//        $str = Yii::$app->request->getUrl();
//        echo $str;
//        $useStr = parse_url($str);
//        $useS = ltrim($useStr['path'], '/');
//        $addressArr = explode('/', $useS);
//        $addressArr = array_values($addressArr);
//        print_r($addressArr);
//        exit;
    }
    /**
     * @inheritdoc
     */

    public function beforeAction($action){
        //var_dump(Yii::$app->user->isGuest);
//        if(Yii::$app->user->isGuest){
//            return $this->redirect("/site/login")->send();
//            return $this->goHome();
//        }
//        if (parent::beforeAction($action)) {
//            $actionID = $action->id;
//        }
        if (Yii::$app->user->isGuest ) {

            if(Yii::$app->controller->action->id=='login'|| Yii::$app->controller->action->id=='logout'){
          //      return $this->redirect("/site/login")->send();


                return true;
            }else{
                return $this->redirect("/site/login")->send();
            }

        }else{

            $id = Yii::$app->user->id;
            $session = Yii::$app->session;
            $username = Yii::$app->user->identity->username;

            $tokenSES = $session->get(md5(sprintf("%s&%s",$id,$username))); //取出session中的用户登录token
            $sessionTBL = AdminSession::findOne(['id' => $id]);
            $id = Yii::$app->user->id;
            $session = Yii::$app->session;
            $username = Yii::$app->user->identity->username;

            $tokenSES = $session->get(md5(sprintf("%s&%s",$id,$username))); //取出session中的用户登录token
            $sessionTBL = AdminSession::findOne(['id' => $id]);
            if(!$tokenSES)
            {   $ip = Yii::$app->request->userIP;
                $tokenSES = md5(sprintf("%s&%s&%s",$_SERVER['HTTP_USER_AGENT'],$id,$ip));  //将用户登录时的时间、用户ID和IP联合加密成token存入表
                $session->set(md5(sprintf("%s&%s",$id,$username)),$tokenSES);
            }
            if($sessionTBL ){
                $tokenTBL = $sessionTBL->session_token;
               // if(!Yii::$app->user->can('编辑')){
                    if($tokenSES != $tokenTBL)  //如果用户登录在 session中token不同于数据表中token
                    {
                        $this->redirect(array('/site/logout'));
                        #  Yii::$app->user->logout(); //执行登出操作
                        # Yii::$app->run();
                        return false;
                    }
             //   }
            }
            return true;
        }
    }
        /*
    public function beforeAction($action)
    {
        if(isset($_GET['test33'])){
        var_dump(Yii::$app->user->identity);
        exit;
        }

        if (parent::beforeAction($action)) {
                $actionID = $action->id;


           if(!Yii::$app->user->isGuest && $actionID != 'logout'&& $actionID != 'login') {
        $test_hosts=[ 'testdb.topcdb.com','testdb2.topcdb.com','testdb1.topcdb.com'];


        if(in_array($_SERVER['SERVER_NAME'],$test_hosts)){
            //是否有测试网址的权限
            if(Yii::$app->user->can('测试网址')){

            }elseif(Yii::$app->user->identity->company=='拓普'){

            }else{
                header("Location:http://db.topcdb.com");
                exit;

            }
        }

                if($this->id=='bo'||$this->id=='top'||$this->id=='api' )
                {
                    $pass=(Yii::$app->user->identity->expire_at>0&&strtotime(Yii::$app->user->identity->expire_at)<time())?true:false;
                    if($pass&&$this->id=='top' ){
                      Yii::$app->getSession()->setFlash('error',"您的账号已过期，如需继续访问请联系客服人员：18618350803（手机或微信）。");
                     # $this->redirect(array('/top/top123'));
                           # throw new HttpException('SOME UNKNOWN ERROR HAPPENED','');
                        #    return true;
                    }

                }else{

     //   return True;
                    $pass=Yii::$app->user->identity->expire_at>0&&strtotime(Yii::$app->user->identity->expire_at)<time()?true:false;

                    if($pass){
                      Yii::$app->getSession()->setFlash('error',"您的账号已过期，如需继续访问请联系客服人员：18618350803（手机或微信）。");

                      $this->redirect(array('/top/top123'));
                           # throw new HttpException('SOME UNKNOWN ERROR HAPPENED','');
                            return false;
                    }
                    $ul=new UserLog();
                    if(!$ul->setup()){
                       Yii::$app->getSession()->setFlash('error',"您今日的访问量已达上限，如需继续访问请联系客服人员：18618350803（手机或微信）。");
                      if(in_array($this->id,['advancedbo','cinema','movie' ]))
                      {

                          if($this->id=='top'&&$actionID=='top123'&&(!isset($_REQUEST['BoTotalDetail'])&&!isset($_REQUEST['page'])&&!isset($_REQUEST['export_type'])))
                          {
                            //  return true;
                          }else{
                            $this->redirect(array('/top/top123'));
                           # throw new HttpException('SOME UNKNOWN ERROR HAPPENED','');
                            return false;
                          }
                      }else{
                        $this->redirect(array('/top/top123'));
                           # throw new HttpException('SOME UNKNOWN ERROR HAPPENED','');
                            return false;
                      }
                   }else{
                        if (!\Yii::$app->user->isGuest&&(stripos($_SERVER['SERVER_NAME'],'localhost')===false)) {

                            if($this->id=='advancedbo'&&in_array($actionID,['get-brdlist','get-brd'])){

                            }else{
                            try{
                            if(!in_array($this->id,['api','bo' ])){
                             $ul->save();
                            }
                             }

                            //捕获异常
                            catch(Exception $e)
                             {

                             }
                            }
                        }
                    }
                }

                $id = Yii::$app->user->id;
                $session = Yii::$app->session;
                $username = Yii::$app->user->identity->username;

                $tokenSES = $session->get(md5(sprintf("%s&%s",$id,$username))); //取出session中的用户登录token
                $sessionTBL = AdminSession::findOne(['id' => $id]);
                if(!$tokenSES)
                {   $ip = Yii::$app->request->userIP;
                    $tokenSES = md5(sprintf("%s&%s&%s",$_SERVER['HTTP_USER_AGENT'],$id,$ip));  //将用户登录时的时间、用户ID和IP联合加密成token存入表
                    $session->set(md5(sprintf("%s&%s",$id,$username)),$tokenSES);
                }
                if($sessionTBL ){
                    $tokenTBL = $sessionTBL->session_token;
                      if(!Yii::$app->user->can('编辑')){
                        if($tokenSES != $tokenTBL)  //如果用户登录在 session中token不同于数据表中token
                        {
                            $this->redirect(array('/site/logout'));
                          #  Yii::$app->user->logout(); //执行登出操作
                           # Yii::$app->run();
                            return false;
                        }
                      }
                }
            }else{
                if(stripos($_SERVER['SERVER_NAME'],'localhost')===false){
                 $ul=new UserLog();
                 $ul->setnologin();
                }

            }
            return true;
        } else {
            return false;
        }
    }
*/
	public function renderjson($data) {
       // header("Content-type:json/application;charset=utf-8");
        echo json_encode($data);
		exit;
    }
    /** 
     * Set the language displayed on the current site
     */
    public function setLanguage()
    {
        if(isset($_GET['lang']) && $_GET['lang'] != "") {
            // By passing a parameter to change the language
            Yii::$app->language = htmlspecialchars($_GET['lang']);

            // get the cookie collection (yii\web\CookieCollection) from the "response" component
            $cookies = Yii::$app->response->cookies;
            // add a new cookie to the response to be sent
            $cookies->add(new \yii\web\Cookie([
                'name' => 'lang',
                'value' => htmlspecialchars($_GET['lang']),
                'expire' => time() + (365 * 24 * 60 * 60),
            ]));
        } elseif (isset(Yii::$app->request->cookies['lang']) && 
            Yii::$app->request->cookies['lang']->value != "") {
            // COOKIE in accordance with the language type to set the language
            Yii::$app->language = Yii::$app->request->cookies['lang']->value;
        }  else {
            Yii::$app->language = 'zh-CN';
        }
    }
    public function test(){
//        $addressArr= $topuser->handleUrl(Yii::$app->request->getUrl());
//        echo Yii::$app->request->getUrl();
//        print_r(parse_url(Yii::$app->request->getUrl()));
//        //print_r($addressArr);
//        $count=count($addressArr);
//        $post = Yii::$app->request->post();


        //            $res =$topuser->checkIntegral(Yii::$app->request->getUrl(),$post);
//            if(isset($res) && $res!=''){
//                if($res==1){
//                    if($addressArr[$count-1]!='usererror'){//��ֹ�ض���
//                        //  return   $this->redirect("@web/topuser/topuser/usererror");
//                        return Yii::$app->response->redirect( ['topuser/topuser/usererror']);
//                        exit;
//                    }
//                }
//            }
    }
}
