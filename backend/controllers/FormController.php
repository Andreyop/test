<?php

namespace backend\controllers;

use common\models\Form;
use backend\models\search\FormSearch;
use common\models\SendEmail;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * FormController implements the CRUD actions for Form model.
 */
class FormController extends Controller
{
    private $_transaction;
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@backend/views/form/error.php'
            ],
        ];
    }


    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }



    public function actionIndex()
    {
        $model = new Form();




        $model->load(Yii::$app->request->post());



        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->validate()) {
                //добавление начато
                $post_model = Yii::$app->request->post('Form');

                $model->contact_name = $post_model['contact_name'];
                $model->contact_email = $post_model['contact_email'];

                $model->position_description = $post_model['position_description'];
                $model->salary = $post_model['salary'];
                $model->dateStart = $post_model['dateStart'];
                $model->dateEnd = $post_model['dateEnd'];

                $model->datePostAt = $post_model['datePostAt'];
                //добавление оконченно
                $this->_transaction = Yii::$app->db->beginTransaction();
//                Yii::$app->mailer->compose('views/contact-html')
//                    ->setSubject('test subject')
//                    ->setFrom('kaktuasan777@gmail.com')
//                    ->setHtmlBody('views/contact-html')
//                    ->setTo('kaktuasan777@gmail.com')
//                    ->send();


                $model->save();
                if($model->save()){
                    $id = $model->id;
                    $sender = Form::find()->with('postsQueues')->with('descriptivePost')->with('contactPost')->where('id = :id', [':id' => $id])->limit(1)->one();
//                $email = User::find()->select(['email'])->where('username = :username', [':username' => 'admin'])->asArray()->one();

                    // Set layout params
                    Yii::$app->mailer->getView()->params['CompanyName'] = $sender->company_name;
                    $email = \common\models\Admin::find()->orderBy(['id' => SORT_DESC])->one();
                    $admin_email = $email->admin_email;
                    Yii::$app->mailer->compose(
                        'views/preview-html', ['sender' => $sender])->setTo($admin_email)
                        ->setSubject('Создано задание для размещения')->send();
                }

                $exception = Yii::$app->errorHandler->exception;
                if ($exception !== null) {
                    $this->_transaction->rollBack();
                } else {

                    $this->_transaction->commit();

                    Yii::$app->session->setFlash('success', 'Данные успешно сохранены и отправлены на почту '. $admin_email);
                }

                if ($model->datePostAt === date('d.m.Y H:i')) {
                    Yii::$app->queue->push(new SendEmail([
                        'post_id' => $model->id,
                    ]));
                } else {
                    $delaySend = strtotime($model->datePostAt) - strtotime('now');
                    Yii::$app->queue->delay($delaySend)->push(new SendEmail([
                        'post_id' => $model->id,
                    ]));

                }

                $model = new Form();
            } else {
                Yii::$app->session->setFlash('danger', 'Данные не отправлены');
              echo $model->getErrors();
                return ActiveForm::validate($model);
            }

        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
    /**
     * Displays a single Form model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */


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
//    /**
//     * Creates a new Form model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $model = new Form();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

//    /**
//     * Updates an existing Form model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param int $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }

//    /**
//     * Deletes an existing Form model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param int $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

//    /**
//     * Finds the Form model based on its primary key value.
//     * If the model is not found, a 404 HTTP exception will be thrown.
//     * @param int $id
//     * @return Form the loaded model
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    protected function findModel($id)
//    {
//        if (($model = Form::findOne($id)) !== null) {
//            return $model;
//        }
//
//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
//    }
}
