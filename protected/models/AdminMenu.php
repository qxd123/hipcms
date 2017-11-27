<?php
/**
 * "{{admin_menu}}" 数据表模型类.
 *
 *
 * @author zhao jinhan <326196998@qq.com>
 * @link
 *
 */

class  AdminMenu extends CActiveRecord
{
    public $verifyCode;
    /**
     * @return string 相关的数据库表的名称
     */
    public function tableName()
    {
        return '{{admin_menu}}';
    }

    /**
     * @return array 对模型的属性验证规则.
     */
    public function rules()
    {
        return array(
            array('id, title, parentid, module, action, data, listorder, display, safe, settings', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array 关联规则.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'post'=>array(self::BELONGS_TO, 'Post', 'post_id',  'select'=>'id,title'),
        );
    }

    /**
     * @return array 自定义属性标签 (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'id',
            'title' => '标题',
            'parentid' => '父类',
            'module' => '模块',
            'action' => '动作',
            'data' => '数据',
            'listorder' => '排序',
            'settings' => '设置',
            'safe' => 'safe',
        );
    }


    /**
     * 返回指定的AR类的静态模型.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PostComment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    public  function getList($params = array(), $field = null){
        $data = array();
        $params['condition'] = isset($params['condition'])?$params['condition']:'';
        $params['order']     = isset($params['order'])?$params['order']:'';

        //组合条件
        $criteria = new CDbCriteria();
        $criteria->condition = 'display=:display';
        $params['condition'] && $criteria->condition .= $params['condition'];
        $criteria->order = $params['order']?$params['order']:'id DESC,listorder desc';

        $criteria->params = array(':display'=> '1');

        $res = self::model()->findAll($criteria);
        if($res) {
            $data = $res;
        }
        return $data;
    }


}
