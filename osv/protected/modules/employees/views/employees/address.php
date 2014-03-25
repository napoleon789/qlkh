<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$model->id,
);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
 <?php $this->renderPartial('profileleft');?>
    
    </td>
    <td valign="top">
    <div class="emp_right">
<h1 style="margin-top:.67em;">Employee Profile : <?php echo $model->first_name.'&nbsp;'.$model->last_name; ?><br /></h1>
<div class="edit_bttns">
    <ul>
    <li><?php echo CHtml::link('Edit', array('update', 'id'=>$_REQUEST['id']),array('class'=>'edit last')); ?><!--<a class=" edit last" href="">Edit</a>--></li>
    </ul>
    </div>
    
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
    <div class="emp_tab_nav">
    <ul style="width:698px;">
    <li><?php echo CHtml::link('Profile', array('view', 'id'=>$_REQUEST['id'])); ?></li>
    <li><?php echo CHtml::link('Address', array('address', 'id'=>$_REQUEST['id']),array('class'=>'active')); ?></li>
    <li><?php echo CHtml::link('Contact', array('contact', 'id'=>$_REQUEST['id'])); ?></li>
     <li><?php echo CHtml::link('Additional Info', array('addinfo', 'id'=>$_REQUEST['id'])); ?></li>
    </ul>
    </div>
    <div class="clear"></div>
 <div class="emp_cntntbx">
    <div class="table_listbx">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="listbxtop_hdng">
    <td>Address</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="listbx_subhdng">Home Address Line 1</td>
    <td class="subhdng_nrmal"><?php echo $model->home_address_line1; ?></td>
    <td class="listbx_subhdng">Office Address Line 1</td>
    <td class="subhdng_nrmal"><?php echo $model->office_address_line1; ?></td>
  </tr>

  <tr>
    <td class="listbx_subhdng">Home Address Line 2</td>
    <td class="subhdng_nrmal"><?php echo $model->home_address_line2; ?></td>
    <td class="listbx_subhdng">Office Address Line 2</td>
    <td class="subhdng_nrmal"><?php echo $model->office_address_line2; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng">Home City </td>
    <td class="subhdng_nrmal"><?php echo $model->home_city; ?></td>
    <td class="listbx_subhdng">Office City </td>
    <td class="subhdng_nrmal"><?php echo $model->office_city; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng">Home state</td>
    <td class="subhdng_nrmal"><?php echo $model->home_state; ?></td>
    <td class="listbx_subhdng">Office state</td>
    <td class="subhdng_nrmal"><?php echo $model->office_state;?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng">Home Country</td>
    <td class="subhdng_nrmal"><?php 
	$count = Countries::model()->findByAttributes(array('id'=>$model->home_country_id));
	if(count($count)!=0)
	echo $count->name; ?></td>
    <td class="listbx_subhdng">Office Country</td>
    <td class="subhdng_nrmal"><?php
		$count_1 = Countries::model()->findByAttributes(array('id'=>$model->office_country_id));
	if(count($count_1)!=0)	
	 echo $count_1->name; ?>
	</td>
  </tr>
  <tr>
    <td class="listbx_subhdng">Home PIN</td>
    <td class="subhdng_nrmal"><?php echo $model->home_pin_code; ?></td>
    <td class="listbx_subhdng">Office PIN</td>
    <td class="subhdng_nrmal"><?php echo $model->office_pin_code; ?></td>
  </tr>
  </table>
  <div class="ea_pdf" style="top:4px; right:6px;"><?php //echo CHtml::link('<img src="images/pdf-but.png">', array('Employees/pdf','id'=>$_REQUEST['id'])); ?></div>
   
 </div>
 
 </div>
</div>
</div>
</div>
    
    </td>
  </tr>
</table>