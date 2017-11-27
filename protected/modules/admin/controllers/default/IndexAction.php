<?php
/**
 *  后台菜单
 * 
 * @author        Sim Zhao <326196998@qq.com>
 * @copyright     Copyright (c) 2015. All rights reserved.
 */

class IndexAction extends CAction
{	
	public function run(){
        
        $this->controller->layout = false;
		$this->controller->pageTitle = Yii::t('common','Admin Manage');

        $model = new AdminMenu();
        $model = new AdminMenu();
        $first_data=$model->findAll('parentid=0 AND display=1 ORDER BY id asc');
        //后台头部一级菜单
        foreach ($first_data as $k =>$v){
            $FirstMenus[$k]['url']='';
            $FirstMenus[$k]['name']=$v['title'];
            $FirstMenus[$k]['id']=$v['id'];
        }
        //后台左侧二级菜单
        $second_data=$model->findAll('parentid>0 AND display=1 ORDER BY id DESC');
        foreach ($second_data as $k =>$v){
            $module_action=$v['module'].'/'.$v['action'];
            $SecMenus[$v['parentid']][$k]['url']=$this->controller->createUrl($module_action);
            $SecMenus[$v['parentid']][$k]['name']=$v['title'];
            $SecMenus[$v['parentid']][$k]['pid']=$v['parentid'];
        }


		//取左侧菜单第一个菜单作为头部菜单的链接
		foreach($FirstMenus as $key=>$val){
            if(isset($SecMenus[$val['id']]) && $SecMenus[$val['id']]) {
                $firstUrl=reset($SecMenus[$val['id']]);
                $FirstMenus[$key]['url'] = $firstUrl['url'];
            }
		}

		//二级菜单重新排序
        foreach ($FirstMenus as $k=>$v){
            $new_SecMenus[$k]=$SecMenus[$v['id']];
        }
		$this->controller->render('index', array('FirstMenus' => $FirstMenus, 'SecMenus' => $new_SecMenus));
	}
}