<?php

class StudentsController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','manage','Website','savesearch','events','attentance','Assesments','DisplaySavedImage','Fees','Payfees','Pdf','Printpdf','Remove','Search','inactive','active'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','batch','add'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		//$this->layout='';
		//header("Content-type: image/jpeg");
		//echo $model->photo_data;
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionPrintpdf()
	{
		//$this->layout='';
		//header("Content-type: image/jpeg");
		//echo $model->photo_data;
		$this->render('printpdf',array(
			'model'=>$this->loadModel($_REQUEST['id']),
		));
	}
	 public function actionPdf()
    {
        
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();

        $html2pdf->WriteHTML($this->renderPartial('printpdf', array('model'=>$this->loadModel($_REQUEST['id'])), true));
        $html2pdf->Output();
 
        ////////////////////////////////////////////////////////////////////////////////////
	}
	public function actionDisplaySavedImage()
		{
			$model=$this->loadModel($_GET['id']);
		 
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Transfer-Encoding: binary');
			header('Content-length: '.$model->photo_file_size);
			header('Content-Type: '.$model->photo_content_type);
			header('Content-Disposition: attachment; filename='.$model->photo_file_name);
		 
				//echo '<img src="'.base64_decode($model->photo_data).'" />';
				echo $model->photo_data;
		}
	public function actionRemove()
	{
		$model = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$model->saveAttributes(array('photo_file_name'=>'','photo_data'=>''));
		$this->redirect(array('update','id'=>$_REQUEST['id']));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Students;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Students']))
		{

			$model->attributes=$_POST['Students'];
			$list = $_POST['Students'];
			if($model->admission_date)
			$model->admission_date=date('Y-m-d',strtotime($model->admission_date));
			if($model->date_of_birth)
			$model->date_of_birth=date('Y-m-d',strtotime($model->date_of_birth));
			 //$model->photo_data=CUploadedFile::getInstance($model,'photo_data');
			 
			if($file=CUploadedFile::getInstance($model,'photo_data'))
       		 {
            $model->photo_file_name=$file->name;
            $model->photo_content_type=$file->type;
            $model->photo_file_size=$file->size;
            $model->photo_data=file_get_contents($file->tempName);
      		  }
 
			 
			
			if($model->save())
				$this->redirect(array('guardians/create','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Students']))
		{
			$model->attributes=$_POST['Students'];
			if($model->admission_date)
			$model->admission_date=date('Y-m-d',strtotime($model->admission_date));
			if($model->date_of_birth)
			$model->date_of_birth=date('Y-m-d',strtotime($model->date_of_birth));
			if($file=CUploadedFile::getInstance($model,'photo_data'))
       		 {
            $model->photo_file_name=$file->name;
            $model->photo_content_type=$file->type;
            $model->photo_file_size=$file->size;
            $model->photo_data=file_get_contents($file->tempName);
      		  }
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionAssesments()
	{
		$model=new Students;
			$this->render('assesments',array(
			'model'=>$this->loadModel($_REQUEST['id']),
		));

	}
	public function actionAttentance()
	{
		$model=new Students;
		$this->render('attentance',array(
			'model'=>$this->loadModel($_REQUEST['id']),
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Performs the Advance search.
	 * By Rajith
	 */
	 public function actionManage()
	 {
		 
		$model=new Students;
		$criteria = new CDbCriteria;
		$criteria->compare('is_deleted',0);  // normal DB field
		if(isset($_REQUEST['val']))
		{
		 $criteria->condition='first_name LIKE :match';
		 $criteria->params = array(':match' => $_REQUEST['val'].'%');
		}
		
		if(isset($_REQUEST['name']) and $_REQUEST['name']!=NULL)
		{
		 $criteria->condition=$criteria->condition.' and '.'first_name LIKE :name';
		 $criteria->params[':name'] = $_REQUEST['name'].'%';
		}
		
		if(isset($_REQUEST['admissionnumber']) and $_REQUEST['admissionnumber']!=NULL)
		{
		 $criteria->condition=$criteria->condition.' and '.'admission_no LIKE :admissionnumber';
		 $criteria->params[':admissionnumber'] = $_REQUEST['admissionnumber'].'%';
		}
		
		if(isset($_REQUEST['Students']['batch_id']) and $_REQUEST['Students']['batch_id']!=NULL)
		{
			$model->batch_id = $_REQUEST['Students']['batch_id'];
			$criteria->condition=$criteria->condition.' and '.'batch_id = :batch_id';
		    $criteria->params[':batch_id'] = $_REQUEST['Students']['batch_id'];
		}
		
		if(isset($_REQUEST['Students']['gender']) and $_REQUEST['Students']['gender']!=NULL)
		{
			$model->gender = $_REQUEST['Students']['gender'];
			$criteria->condition=$criteria->condition.' and '.'gender = :gender';
		    $criteria->params[':gender'] = $_REQUEST['Students']['gender'];
		}
		
		if(isset($_REQUEST['Students']['blood_group']) and $_REQUEST['Students']['blood_group']!=NULL)
		{
			$model->blood_group = $_REQUEST['Students']['blood_group'];
			$criteria->condition=$criteria->condition.' and '.'blood_group = :blood_group';
		    $criteria->params[':blood_group'] = $_REQUEST['Students']['blood_group'];
		}
		
		if(isset($_REQUEST['Students']['nationality_id']) and $_REQUEST['Students']['nationality_id']!=NULL)
		{
			$model->nationality_id = $_REQUEST['Students']['nationality_id'];
			$criteria->condition=$criteria->condition.' and '.'nationality_id = :nationality_id';
		    $criteria->params[':nationality_id'] = $_REQUEST['Students']['nationality_id'];
		}
		
		
		if(isset($_REQUEST['Students']['dobrange']) and $_REQUEST['Students']['dobrange']!=NULL)
		{
			  
			  $model->dobrange = $_REQUEST['Students']['dobrange'] ;
			  if(isset($_REQUEST['Students']['date_of_birth']) and $_REQUEST['Students']['date_of_birth']!=NULL)
			  {
				  if($_REQUEST['Students']['dobrange']=='2')
				  {  
					  $model->date_of_birth = $_REQUEST['Students']['date_of_birth'];
					  $criteria->condition=$criteria->condition.' and '.'date_of_birth = :date_of_birth';
					  $criteria->params[':date_of_birth'] = date('Y-m-d',strtotime($_REQUEST['Students']['date_of_birth']));
				  }
				  if($_REQUEST['Students']['dobrange']=='1')
				  {  
				  
					  $model->date_of_birth = $_REQUEST['Students']['date_of_birth'];
					  $criteria->condition=$criteria->condition.' and '.'date_of_birth < :date_of_birth';
					  $criteria->params[':date_of_birth'] = date('Y-m-d',strtotime($_REQUEST['Students']['date_of_birth']));
				  }
				  if($_REQUEST['Students']['dobrange']=='3')
				  {  
					  $model->date_of_birth = $_REQUEST['Students']['date_of_birth'];
					  $criteria->condition=$criteria->condition.' and '.'date_of_birth > :date_of_birth';
					  $criteria->params[':date_of_birth'] = date('Y-m-d',strtotime($_REQUEST['Students']['date_of_birth']));
				  }
				  
			  }
		}
		elseif(isset($_REQUEST['Students']['dobrange']) and $_REQUEST['Students']['dobrange']==NULL)
		{
			  if(isset($_REQUEST['Students']['date_of_birth']) and $_REQUEST['Students']['date_of_birth']!=NULL)
			  {
				  $model->date_of_birth = $_REQUEST['Students']['date_of_birth'];
				  $criteria->condition=$criteria->condition.' and '.'date_of_birth = :date_of_birth';
				  $criteria->params[':date_of_birth'] = date('Y-m-d',strtotime($_REQUEST['Students']['date_of_birth']));
			  }
		}
		
		
		if(isset($_REQUEST['Students']['admissionrange']) and $_REQUEST['Students']['admissionrange']!=NULL)
		{
			  
			  $model->admissionrange = $_REQUEST['Students']['admissionrange'] ;
			  if(isset($_REQUEST['Students']['admission_date']) and $_REQUEST['Students']['admission_date']!=NULL)
			  {
				  if($_REQUEST['Students']['admissionrange']=='2')
				  {  
					  $model->admission_date = $_REQUEST['Students']['admission_date'];
					  $criteria->condition=$criteria->condition.' and '.'admission_date = :admission_date';
					  $criteria->params[':admission_date'] = date('Y-m-d',strtotime($_REQUEST['Students']['admission_date']));
				  }
				  if($_REQUEST['Students']['admissionrange']=='1')
				  {  
				  
					  $model->admission_date = $_REQUEST['Students']['admission_date'];
					  $criteria->condition=$criteria->condition.' and '.'admission_date < :admission_date';
					  $criteria->params[':admission_date'] = date('Y-m-d',strtotime($_REQUEST['Students']['admission_date']));
				  }
				  if($_REQUEST['Students']['admissionrange']=='3')
				  {  
					  $model->admission_date = $_REQUEST['Students']['admission_date'];
					  $criteria->condition=$criteria->condition.' and '.'admission_date > :admission_date';
					  $criteria->params[':admission_date'] = date('Y-m-d',strtotime($_REQUEST['Students']['admission_date']));
				  }
				  
			  }
		}
		elseif(isset($_REQUEST['Students']['admissionrange']) and $_REQUEST['Students']['admissionrange']==NULL)
		{
			  if(isset($_REQUEST['Students']['admission_date']) and $_REQUEST['Students']['admission_date']!=NULL)
			  {
				  $model->admission_date = $_REQUEST['Students']['admission_date'];
				  $criteria->condition=$criteria->condition.' and '.'admission_date = :admission_date';
				  $criteria->params[':admission_date'] = date('Y-m-d',strtotime($_REQUEST['Students']['admission_date']));
			  }
		}
		
		if(isset($_REQUEST['Students']['status']) and $_REQUEST['Students']['status']!=NULL)
		{
			$model->status = $_REQUEST['Students']['status'];
			$criteria->condition=$criteria->condition.' and '.'is_active = :status';
		    $criteria->params[':status'] = $_REQUEST['Students']['status'];
		}
		
		
		$criteria->order = 'first_name ASC';
		
		$total = Students::model()->count($criteria);
		$pages = new CPagination($total);
        $pages->setPageSize(Yii::app()->params['listPerPage']);
        $pages->applyLimit($criteria);  // the trick is here!
		$posts = Students::model()->findAll($criteria);
		
		 
		$this->render('manage',array('model'=>$model,
		'list'=>$posts,
		'pages' => $pages,
		'item_count'=>$total,
		'page_size'=>Yii::app()->params['listPerPage'],)) ;
	 }
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('is_deleted',0);
		$total = Students::model()->count($criteria);
		$criteria->order = 'id DESC';
		$criteria->limit = '10';
		$posts = Students::model()->findAll($criteria);
		
		
		$this->render('index',array(
			'total'=>$total,'list'=>$posts
		));
	}
	
	public function actionSavesearch()
	{
		$dataProvider=new CActiveDataProvider('Students');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	
	public function actionPayfees()
	{
		$list  = FinanceFees::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$list->is_paid = 1;
		$list->save();
			$this->redirect(array('fees','id'=>$list->student_id));
	}
	public function actionFees($id)
	{
		//$model= new Students;
		$this->render('fees',array(
			'model'=>$this->loadModel($id),
		));
		//$this->render('fees',array('model'=>$model));
	}
	public function actionEvents()
	{
		$this->render('events');
	}
	
	public function actionAdd() {
		
		if (isset($_POST['title'])) {
			$data[MENU_TITLE] = trim($_POST['title']);
			if (!empty($data[MENU_TITLE])) {
				$data[MENU_URL] = $_POST['url'];
				$data[MENU_CLASS] = $_POST['class'];
				$data[MENU_GROUP] = $_POST['group_id'];
				$data[MENU_POSITION] = Menu::model()->get_last_position($_POST['group_id']);
				$data[MENU_POSITION] = $data[MENU_POSITION]+1;
				if (Menu::model()->insert(MENU_TABLE, $data)) {
					$data[MENU_ID] = $this->db->Insert_ID();
					$response['status'] = 1;
					$li_id = 'menu-'.$data[MENU_ID];
					$response['li'] = '<li id="'.$li_id.'" class="sortable">'.Menu::model()->get_label($data).'</li>';
					$response['li_id'] = $li_id;
				} else {
					$response['status'] = 2;
					$response['msg'] = 'Add menu error.';
				}
			} else {
				$response['status'] = 3;
			}
			echo 'eee';
			header('Content-type: application/json');
			echo json_encode($response);
		}
	}
	public function actionWebsite()
	{
		$group_id = 1;
		if (isset($_GET['group_id'])) {
			$group_id = (int)$_GET['group_id'];
		}
		$menu = Menu::model()->get_menu($group_id);
		$data['menu_ul'] = '<ul id="easymm"></ul>';
		if ($menu) {

			include 'includes/tree.php';
			$tree = new Tree;

			foreach ($menu as $row) {
				$tree->add_row(
					$row[MENU_ID],
					$row[MENU_PARENT],
					' id="menu-'.$row[MENU_ID].'" class="sortable"',
					Menu::model()->get_label($row)
				);
			}

			$data['menu_ul'] = $tree->generate_list('id="easymm"');
		}
		$data['group_id'] = $group_id;
		$data['group_title'] = Menu::model()->get_menu_group_title($group_id);
		$data['menu_groups'] = Menu::model()->get_menu_groups();
		//$this->view('menu', $data);
		$this->render('website',$data);
	}
	
	public function actionBatch()
	{
		
		
		$data=Batches::model()->findAll('course_id=:id', 
                  array(':id'=>(int) $_POST['cid']));
				  
		echo CHtml::tag('option', array('value' => 0), CHtml::encode('-Select-'), true);
 
         $data=CHtml::listData($data,'id','name');
		  foreach($data as $value=>$name)
		  {
			  echo CHtml::tag('option',
						 array('value'=>$value),CHtml::encode($name),true);
		  }
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Students('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Students']))
			$model->attributes=$_GET['Students'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Students::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function actionSearch()
	{
	
		$model=new Students;
		$criteria = new CDbCriteria;
		 $criteria->condition='first_name LIKE :match or middle_name LIKE :match or last_name LIKE :match';
		 $criteria->params = array(':match' => $_POST['char'].'%');
		  $criteria->order = 'first_name ASC';
		 $total = Students::model()->count($criteria);
		$pages = new CPagination($total);
        $pages->setPageSize(Yii::app()->params['listPerPage']);
        $pages->applyLimit($criteria);  // the trick is here!
		$posts = Students::model()->findAll($criteria);
		
		$emp=new Employees;
		$criteria_1 = new CDbCriteria;
		 $criteria_1->condition='first_name LIKE :match or middle_name LIKE :match or last_name LIKE :match';
		 $criteria_1->params = array(':match' => $_POST['char'].'%');
		 $criteria_1->order = 'first_name ASC';
		 $tot = Employees::model()->count($criteria_1);
		$pages_1 = new CPagination($total);
        $pages_1->setPageSize(Yii::app()->params['listPerPage']);
        $pages_1->applyLimit($criteria_1);  // the trick is here!
		$posts_1 = Employees::model()->findAll($criteria_1);
		
		 
		$this->render('search',array('model'=>$model,
		'list'=>$posts,
		'posts'=>$posts_1,
		'pages' => $pages,
		'item_count'=>$total,
		'page_size'=>10,)) ;
		
			
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='students-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionInactive()
	{
		$model = Students::model()->findByAttributes(array('id'=>$_REQUEST['sid']));
		$model->saveAttributes(array('is_active'=>'0'));
		$this->redirect(array('/courses/batches/batchstudents','id'=>$_REQUEST['id']));
	}
	
	public function actionActive()
	{
		$model = Students::model()->findByAttributes(array('id'=>$_REQUEST['sid']));
		$model->saveAttributes(array('is_active'=>'1'));
		$this->redirect(array('/courses/batches/batchstudents','id'=>$_REQUEST['id']));
	}
}
