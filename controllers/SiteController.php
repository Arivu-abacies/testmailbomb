<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;
use app\models\AppList;

use  yii\web\Session;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /* @Description:Landing Page Before Login
     * If user seesion it will display this page else Home.    
     * @Created: 23-June-2017
    */
    public function actionIndex()
    { 
        if(Yii::$app->user->isGuest){
		    $this->layout = 'beforeLogin';
            return $this->render('login');
		} else{
          return $this->render('index');
        }
    }

    
    public function actionLogin()
    {
        if (Yii::$app->request->isAjax) {
            if(Yii::$app->request->post('username')!==null){
                $params = array();
                $params['username'] = Yii::$app->request->post('username');
                $params['password'] = Yii::$app->request->post('userpass');
                $params['_csrf'] = Yii::$app->request->post('_csrf');
                $params['rememberme'] = True;            
                $model = new LoginForm();
                if ($model->setUserLogin($params)){                                     
                    echo "success";
                } else{
                    echo "error";
                }
            }
        }
    }

    public function actionLogout()
    {        
        Yii::$app->user->logout();
        $session = Yii::$app->session;
        $session->close();
        $session->destroy();
        return $this->goHome();
    }

    public function actionHome()
    {        
        if(Yii::$app->user->isGuest){
		    $this->layout = 'beforeLogin';
            return $this->render('login');
		} else{
            $userIdentity = Yii::$app->user->identity;
		    $checkdata = AppList::find()->all();
		    return $this->render('dashboard',[ 'checkdata' => $checkdata ]);
        }        
    }      
}

?>