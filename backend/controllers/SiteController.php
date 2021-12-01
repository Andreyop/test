<?php

namespace backend\controllers;

use common\models\Form;
use common\models\Post;
use common\models\SendEmail;
use common\models\LoginForm;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private $_transaction;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
//    public function actions()
//    {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//                'view' => '@backend/views/Form/error.php'
//            ],
//        ];
//    }



//    public function actionError()
//    {
//        $exception = Yii::$app->errorHandler->exception;
//        if ($exception !== null) {
//            return $this->render('error', ['exception' => $exception]);
//        }
//    }

    public function actionView() {

        $this->view->title = 'Связанные данные в таблицах';
        $posts = Form::find()->with('postsQueues')->all();
        $email = User::find()->select(['email'])->where('username = :username', [':username' => 'admin'])->asArray()->one();
        $admin_email = $email['email'];

        $id = 101;
        $sender = Form::find()->with('postsQueues')->with('descriptivePost')->with('contactPost')->where('id = :id', [':id' => $id])->one();

        return $this->render('view', compact('posts', 'sender', 'admin_email'));
    }


    public function actionValidate(){
        $model = new Form();

        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Form();


        $model->load(Yii::$app->request->post());


        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->validate()) {
                //добавление начато
                $post_model = Yii::$app->request->post();

                $model->contact_name = $post_model['contact_name'];
                $model->contact_email = $post_model['contact_email'];

                $model->position_description = $post_model['position_description'];
                $model->salary = $post_model['salary'];
                $model->dateStart = $post_model['dateStart'];
                $model->dateEnd = $post_model['dateEnd'];

                $model->datePostAt = $post_model['datePostAt'];
                //добавление оконченно
                $this->_transaction = Yii::$app->db->beginTransaction();
                $model->save();
                $exception = Yii::$app->errorHandler->exception;
                if ($exception !== null) {
                    $this->_transaction->rollBack();
                } else {
                    $this->_transaction->commit();
                    Yii::$app->session->setFlash('success', 'Данные успешно отправлены через Ajax и сохранены');
                }
                if ($model->datePostAt === date('d.m.Y')) {
                    Yii::$app->queue->push(new SendEmail([
                        'post_id' => $model->id,
                    ]));
//                    $res = $model->sendMail($model->id);
//                    if ($res) {
//
//                        Yii::$app->session->setFlash('success', 'Данные успешно сохранены и отправлены на почту');
//                    }
                } else {
                    $delaySend = strtotime($model->datePostAt) - strtotime('now');
                    Yii::$app->queue->delay($delaySend)->push(new SendEmail([
                        'post_id' => $model->id,
                    ]));

                }

                $model = new Form();
            } else {
                Yii::$app->session->setFlash('danger', 'Данные не отправлены');
                var_dump($model->getErrors());
                return ActiveForm::validate($model);
            }

        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }


    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
