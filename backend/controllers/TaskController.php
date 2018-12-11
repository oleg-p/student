<?php

namespace backend\controllers;

use common\dictionaries\Status;
use Yii;
use common\models\Task;
use common\models\searchies\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\helpers\AppHelper;
use yii\web\UploadedFile;
use backend\models\UploadDocument;
use yii\helpers\Json;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post', 'take'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'pdf', 'take', 'upload-document'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Назначение задания исполнителю
     * @param integer $id
     * @return mixed
     */
    public function actionTake($id)
    {
        $model = $this->findModel($id);
        if($model->setExecuter()){
            Yii::$app->session->setFlash('success', 'Задание "' . $model->name .'" назначено пользователю: ' . AppHelper::getModelUser()->username);
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка назначения задания');
        }

        return $this->redirect('index');
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!AppHelper::isManager()){
            $this->redirect(['/site/index']);
        }

        $model = new Task();
        $model->scenario = Task::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Задание "' . $model->name .'"" создано');
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!AppHelper::isExecutor()){
            $this->redirect(['/site/index']);
        }


        $model = $this->findModel($id);
        $model->scenario = Task::SCENARIO_LINK_RESULT;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Результат прикреплён');
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUploadDocument()
    {
        $file = UploadedFile::getInstanceByName(Yii::$app->request->post('nameImageField'));

        $model = new UploadDocument([]);
        $prefixNameFile = 'document';

        if($file !== null) {
            $model->uploadedFile = $file;
            $model->nameFile = $prefixNameFile . '_' . rand(1, 100000) . '.' . $file->getExtension();
            if ($model->upload()) {
                return Json::encode([
                    'nameFile' => $model->nameFile,
                    'originNameFile' => $file->name,
                    'nameInputField' => $model->nameFile,
                ]);
            }
        }

        return Json::encode([
            'error' => $model->getErrorUpload(),
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!AppHelper::isManager()){
            $this->redirect(['/site/index']);
        }

        $model = $this->findModel($id);
        if($model->status === Status::STATUS_NEW && AppHelper::isManager()){
            $model->delete();
            Yii::$app->session->setFlash('success', 'Задание "' . $model->name .'" удалено');
        } else {
            Yii::$app->session->setFlash('error', 'Нельзя удалить задание');
        }

        return $this->redirect(['index']);
    }
    
    /**
     * 
     * Export Task information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => \Yii::$app->name],
            'methods' => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    
    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
