<?php

Yii::import('system.web.widgets.pagers.CLinkPager');

class AdminLinkPager extends CLinkPager {
    
    public $header = '';
    public $footer = '';
    public $firstPageLabel = 'Первая';
    public $lastPageLabel = 'Последняя';
    public $nextPageLabel = 'Следующая';
    public $prevPageLabel = 'Предыдущая';
    public $maxButtonCount = 7;
    public $htmlOptions = array('class' => 'linkPager linkPager--blue');
    
    public function init() {
        
        if ($this->cssFile === null) {            
            $assetManager = Yii::app()->getAssetManager();
            $assetsDir = dirname(__FILE__).'/assets/adminLinkPager';
            $assetsUrl = $assetManager->publish($assetsDir);
            
           $this->cssFile = $assetsUrl.'/linkPager.css';    
        }

        parent::init();
    }
        
}


         
     
               