<?php

namespace bmte\duallistbox;

use yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * This is just an example.
 */
class Widget extends InputWidget
{
    /**
     * model对应的属性名称
     * @var
     */
    public $attribute;

    /**
     * 用来存放原始所有的数据，数组类型
     * exp: [['id'=>1,'name'=>'test1'],['id'=>2,'name'=>'test2']]
     * @var
     */
    public $data;

    /**
     * 设置对应原始数据的键名的名称
     * @var
     */
    public $data_id;

    /**
     * 设置对应原始数据键值的名称
     * @var
     */
    public $data_value;

    /*******************************************属性设置 start*****************************************************/
    /**
     * 设置尺寸
     * @var
     */
    public  $size=10;

    /**
     * 是否点击选中
     * @var bool
     */
    public $moveOnSelect=true;

    /**
     * 是否启用过滤
     * @var
     */
    public $showFilterInputs=true;

    /**
     * 选项最小高度
     * @var int
     */
    public $selectorMinimalHeight=100;

    private $messageCategory = 'dual-list-box';
    /*******************************************属性设置 end*****************************************************/

    /**
     * 根据值过滤还是html过滤
     * @var
     */
    public $filterOnValues=true;

    public function init()
    {
        Yii::$app->language='zh-CN';
        parent::init();
        if (!array_key_exists($this->messageCategory, Yii::$app->i18n->translations)) {
            Yii::$app->i18n->translations[$this->messageCategory] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath'=>'@vendor/ben-tech/yii2-dual-list-box/messages',
                'fileMap'=>[
                    $this->messageCategory=>'widget.php'
                ],
            ];
        }
    }

    public function run()
    {
        $this->data_id= isset($this->data_id)?$this->data_id:'id';
        $this->data_value= isset($this->data_id)?$this->data_id:'text';
        $this->data=is_array($this->data)?$this->data:[];
        $view=$this->getView();
        Asset::register($view);
        $js="$('#{$this->options['id']}').bootstrapDualListbox({
                  nonSelectedListLabel: '".Yii::t($this->messageCategory,'dual list non selected')."',
                  selectedListLabel: 'Selected',
                  preserveSelectionOnMove: 'moved',
                  moveOnSelect: '{$this->moveOnSelect}',
                  selectorMinimalHeight:'{$this->selectorMinimalHeight}',
                  showFilterInputs:'{$this->showFilterInputs}',
                  filterOnValues:'{$this->filterOnValues}',
                  infoText:'".Yii::t($this->messageCategory,'dual list info text').":{0}',
                  filterTextClear:'".Yii::t($this->messageCategory,'dual list filter text clear')."',
                  infoTextFiltered:'<span class=\"label label-warning\">".Yii::t($this->messageCategory,'dual list filtered')."</span> {0} ".Yii::t($this->messageCategory,'dual list from')." {1}',
                  filterPlaceHolder:'".Yii::t($this->messageCategory,'dual list filter placeholder')."',
                  moveSelectedLabel:'".Yii::t($this->messageCategory,'dual list move selected label')."',
                  moveAllLabel:'".Yii::t($this->messageCategory,'dual list move all label')."',
                  removeSelectedLabel:'".Yii::t($this->messageCategory,'dual list remove selected label')."',
                  infoTextEmpty:'".Yii::t($this->messageCategory,'dual list info text empty')."',
                  selectedListLabel:'".Yii::t($this->messageCategory,'dual list selected list label')."',
                  removeAllLabel:'".Yii::t($this->messageCategory,'dual list remove all label')."',
                });";
        $css='.buttons{width:100%;}
       .removeall,.moveall{width:40%;}
       .remove,.move{width:60%;}
        ';
        $view->registerCss($css);
        $view->registerJs($js);
        return Html::activeListBox($this->model,$this->attribute,$this->data,['multiple'=>'multiple','size'=>$this->size]);
    }

}
