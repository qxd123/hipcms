<?php
/**
 *  添加
 * 
 * @author  Sim Zhao <326196998@qq.com>
 * @link    http://www.yiifcms.com/
 * @copyright   Copyright (c) 2014-2015. All rights reserved.
 */

class CreateAction extends CAction
{	
	public function run(){        
        $model = new AdPosition();
        if (isset($_POST['AdPosition'])) {            
            $model->attributes = $_POST['AdPosition'];            
            if ($model->save()) {               
                $this->controller->message('success',Yii::t('admin','Add Success'),$this->controller->createUrl('index'));
            }
        }        
        $this->controller->render('create', array ('model' => $model ));
	}
}