<!--
 * Ajax Crud Administration Form
 * FinanceFeeCategories *
 * InfoWebSphere {@link http://libkal.gr/infowebsphere}
 * @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.3
 -->
<div id="finance-fee-categories_form_con" class="client-val-form">
    <?php if ($model->isNewRecord) : ?>    <h3 id="create_header">Create New Fee Categories</h3>
    <?php  elseif (!$model->isNewRecord):  ?>    <h3 id="update_header">Update</h3>
    <?php   endif;  ?>
    <?php      $val_error_msg = 'Error.FinanceFeeCategories was not saved.';
    $val_success_message = ($model->isNewRecord) ?
            'Fee Categories was created successfuly.' :
            'Fee Categories  was updated successfuly.';
  ?>

    <div id="success-note" class="notification success png_bg"
         style="display:none;">
        <a href="#" class="close"><img
                src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
        <div>
            <?php   echo $val_success_message;  ?>        </div>
    </div>

    <div id="error-note" class="notification errorshow png_bg"
         style="display:none;">
        <a href="#" class="close"><img
                src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
        <div>
            <?php   echo $val_error_msg;  ?>        </div>
    </div>

    <div id="ajax-form"  class='form'>
<?php   $formId='finance-fee-categories-form';
   $actionUrl =
   ($model->isNewRecord)?CController::createUrl('financeFeeCategories/ajax_create')
                                                                 :CController::createUrl('financeFeeCategories/ajax_update');


    $form=$this->beginWidget('CActiveForm', array(
     'id'=>'finance-fee-categories-form',
    //  'htmlOptions' => array('enctype' => 'multipart/form-data'),
         'action' => $actionUrl,
    // 'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
     'focus'=>array($model,'name'),
     'errorMessageCssClass' => 'input-notification-error  error-simple png_bg',
     'clientOptions'=>array('validateOnSubmit'=>true,
                                        'validateOnType'=>false,
                                        'afterValidate'=>'$js_afterValidate',
                                        'errorCssClass' => 'err',
                                        'successCssClass' => 'suc',
                                        'afterValidate' => 'js:function(form,data,hasError){ $.js_afterValidate(form,data,hasError);  }',
                                         'errorCssClass' => 'err',
                                        'successCssClass' => 'suc',
                                        'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
                                                                                                 $.js_afterValidateAttribute(form, attribute, data, hasError);
                                                                                                                            }'
                                                                             ),
));

     ?>
    <?php echo $form->errorSummary($model, '
    <div style="font-weight:bold">Please correct these errors:</div>
    ', NULL, array('class' => 'errorsum notification errorshow png_bg')); ?>    <p class="note">Fields with <span class="required">*</span> are required.</p>


    <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
        <span id="success-FinanceFeeCategories_name"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'name'); ?>
    </div>

        <div class="row">
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
        <span id="success-FinanceFeeCategories_description"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'description'); ?>
    </div>

        <div class="row">
        <h3>Selectc Batches</h3>
            <?php $data = CHtml::listData(Batches::model()->findAll("is_active=:x", array(':x'=>1)), 'id', 'name');
     
                echo $form->checkBoxList($model,'batch_id', $data,array( 'htmlOption'=>'style=clear:both')); ?>
        <span id="success-FinanceFeeCategories_batch_id"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'batch_id'); ?>
    </div>

        <div class="row">
           <?php //echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->hiddenField($model,'is_deleted'); ?>
        <span id="success-FinanceFeeCategories_is_deleted"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'is_deleted'); ?>
    </div>

        <div class="row">
           <?php //echo $form->labelEx($model,'is_master'); ?>
		<?php echo $form->hiddenField($model,'is_master',array('value'=>1)); ?>
        <span id="success-FinanceFeeCategories_is_master"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'is_master'); ?>
    </div>

        <div class="row">
            <?php //echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->hiddenField($model,'created_at',array('value'=>date('Y-m-d'))); ?>
        <span id="success-FinanceFeeCategories_created_at"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'created_at'); ?>
    </div>

        <div class="row">
           <?php //echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d'))); ?>
        <span id="success-FinanceFeeCategories_updated_at"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'updated_at'); ?>
    </div>

    
    <input type="hidden" name="YII_CSRF_TOKEN"
           value="<?php echo Yii::app()->request->csrfToken; ?>"/>

    <?php  if (!$model->isNewRecord): ?>    <input type="hidden" name="update_id"
           value=" <?php echo $model->id; ?>"/>
    <?php endif; ?>
    <div class="row buttons" style="width:30%;">
        <?php   echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save',array('class' =>
        'formbut')); ?>    </div>

  <?php  $this->endWidget(); ?></div>
    <!-- form -->

</div>
<script type="text/javascript">

    //Close button:

    $(".close").click(
            function () {
                $(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
                    $(this).slideUp(600);
                });
                return false;
            }
    );


</script>


