 <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-style.css" />
<?php /*?><?php
$this->breadcrumbs=array(
	'Subjects'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Subjects', 'url'=>array('index')),
	array('label'=>'Manage Subjects', 'url'=>array('admin')),
);
?><?php */?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','<h2>Create Subjects</h2>'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'auto',
                    'height'=>'auto',
					'resizable'=>false,
                ),
                ));
				?>



<?php echo $this->renderPartial('_form', array('model'=>$model,'id'=>$id,'batch_id'=>$batch_id)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
