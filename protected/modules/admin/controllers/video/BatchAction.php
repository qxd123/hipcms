<?php
/**
 * 批量操作
 * 
 * @author        Sim Zhao <326196998@qq.com>
 * @copyright     Copyright (c) 2015. All rights reserved.
 */

class BatchAction extends CAction
{	
	public function run(){		
        $ids = Yii::app()->request->getParam('id');
        $command = Yii::app()->request->getParam('command');
        empty( $ids ) && $this->controller->message( 'error', Yii::t('admin','No Select') );
        if(!is_array($ids)) {
            $ids = array($ids);
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $ids);
        switch ( $command ) {
            case 'delete':      
                //删除                
                foreach((array)$ids as $id){
                    $model = Soft::model()->with('content')->findByPk($id);                    
                    if($model){ 
                        Uploader::deleteFile($model->cover_image);
                        Uploader::deleteFile($model->content->video_file);
                        $model->delete();
                        $model->content->delete();
                    }
                }                
                break;       
            case 'show':     
                //显示
                Video::model()->updateAll(array('status' => 'Y'), $criteria);
                break;
            case 'hidden':     
                //隐藏      
                Video::model()->updateAll(array('status' => 'N'), $criteria);
                break;            
            default:
                $this->controller->message('error', Yii::t('admin','Error Operation'));                
        }
        $this->controller->message('success', Yii::t('admin','Batch Operate Success'));    	
	}
}