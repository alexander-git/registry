<?php


class AdvancedAdminListView extends AdminListView {
    
    public $htmlOptions = array('class' => 'listView');
    public $template = '{sorter}{items}{pager}';
    

    ////////////////////////////////////////////////////////////////////////////
    // linkPanel
    public $linkPanelHeader = null;
    public $linkPanelFooter = null;
    public $linkPanelCssClass = 'listView__linkPanel';
    public $linkPanelActiveHrefCssClass = 'active';
    public $linkPanelHrefCssClass = null;
    public $linkPanelReferences = array();
    public $linkPanelInitialActiveReference  = null;
    public $linkPanelGetParameter = 'get';
    
    ////////////////////////////////////////////////////////////////////////////
    // filterPanel
    /*
    $filterPanelData - массив вида : 
    array( 
        array(
            'label' => 'Имя первого поля',
            'paremeterName' => 'Имя первого get-параметра',
            'options' => array(
                'value1' => 'name1'
                'value2' => 'name2',
            )
        ),
        array(
            'label' => 'Имя второго поля',
            'paremeterName' => 'Имя второго get-параметра',
            'options' => array(
                'value1' => 'name1'
                'value2' => 'name2',
            )
        ),
    )
    */
    
    public $filterPanelData = array();
    // Html(либо просто текст), который выводится перед панелью фильтрации
    public $filterPanelHeader = null;
    // Html(либо просто текст), который выводится после панели фильтрации
    public $filterPanelFooter = null;

    public $filterPanelContainerHtmlOptions = array();
    public $filterPanelElementTemplate = '{label}{select}';
    public $filterPanelSelectHtmlOptions = array();
    public $filterPanelButtonTemplate = '{button}';
    public $filterPanelButtonHtmlOptions = array();
    // Нужно ли при применении фильтрации(которая происходит при нажатии на кнопку)
    // переходить на первую страницу или оставаться на текущей.
    // Необходимо учитывать, что после фильтрации общеее количество страниц может измениться. 
    // Т.е. если их было три до фильтрации, то после может быть две. В этом случае
    // если изначально список был на третьей странице и $filterPanelResetPage === false
    // произойдёт переключение на послёднюю страцницу (т.е. вторую).
    public $filterPanelResetPage = true;

    // Классы панели фильтрации. Используются в js для формирования селекторов.
    // Они добавляются к элементам при отображении виджета автоматически -
    // т.е. это делается в коде виджета - нет необходимости задавать их в разметке или через свойства виджета.
    // Для настройки оформления по умолчаниию не используюся т.к. для этой цели
    // можно задать доп.классы в свойствах $filterPanelContainerHtmlOptions и $filterPanelButtonHtmlOptions. 
    const FILTER_PANEL_CLASS = 'filterPanel';
    const FILTER_PANEL_HIDDEN_HREF_CLASS  = 'filterPanel__hiddenHref';
    const FILTER_PANEL_FILTER_BUTTON_CLASS = 'filterPanel__filterButton';
    
    const DEFAULT_FILTER_PANEL_BUTTON_LABEL = 'Ok';
    
    public function init() {       
        parent::init();
        
        if ($this->isUseFilterPanel() ) {
            $this->registerScriptForFilterPanel();
        }
    }
    
    private function isUseFilterPanel() {
        if (preg_match('{filterPanel}', $this->template) ) {
            return true;
        } else {
            return false;
        }
    }

    public function renderAjaxInfo() {
        if (!$this->ajaxUpdate) {
            return;
        }    
        
        if ($this->ajaxInfoContent !== null) {
            echo $this->ajaxInfoContent ;
        }
    }

    
    ////////////////////////////////////////////////////////////////////////////
    // linkPanel
    public function renderLinkPanel() {
        $htmlOptions = array();
        if ($this->linkPanelCssClass !== null) {
            $htmlOptions['class'] = $this->linkPanelCssClass;        
        }

        echo CHtml::openTag('div', $htmlOptions)."\n";
        if ($this->linkPanelHeader !== null) {
            echo $this->linkPanelHeader;
        }

        if (!empty($this->linkPanelReferences) ) {
            $this->displayLinkPanelReferences();
        }

        if ($this->linkPanelFooter !== null) {
            echo $this->linkPanelFooter;
        }
        echo CHtml::closeTag('div')."\n";
    }
    
    private function displayLinkPanelReferences() {
        $needSetActive = $this->linkPanelActiveHrefCssClass !== null;
        $activeValue = $this->determineActiveValueInLinkPanel();     
     
        $links = array();
        foreach ($this->linkPanelReferences as $value => $linkText) {        
            $params = array_replace($_GET, array($this->linkPanelGetParameter => $value) );

            $setActive = ($needSetActive) && ($activeValue === $value); // Cсылка со этим значением $value явлется активной
            $htmlOptions = $this->prepareLinkHtmlOptionsInLinkPanel($setActive);
            
            $link = CHtml::link(
                $linkText, 
                Yii::app()->controller->createUrl('', $params),
                $htmlOptions
            );
              
            $links[] = $link;
        }  
        
        echo "<ul>\n";
        foreach($links as $link) {
            echo '<li>';
            echo $link;
            echo "</li>\n";
        }
        echo "<ul>";
    }
    
    private function determineActiveValueInLinkPanel() {
        $active = null;
        if (isset($_GET[$this->linkPanelGetParameter]) ) {
            $active = $_GET[$this->linkPanelGetParameter];
        } elseif ($this->linkPanelInitialActiveReference !== null) {
            $active = $this->linkPanelInitialActiveReference;
        }
        return $active;
    }
    
    private function prepareLinkHtmlOptionsInLinkPanel($setActive) {
        $htmlOptions = array();
        if ($this->linkPanelHrefCssClass !== null) {
            $htmlOptions['class'] = $this->linkPanelHrefCssClass;
        }
        if ($setActive) {
            $this->addActiveClassToHtmlOptions($htmlOptions);
        }
        return $htmlOptions;
    }
    
    private function addActiveClassToHtmlOptions(&$htmlOptions) {
         if (isset($htmlOptions['class']) ) { 
            $htmlOptions['class'] .= ' '.$this->linkPanelActiveHrefCssClass;
        } else {
            $htmlOptions['class'] = $this->linkPanelActiveHrefCssClass;
        }
    }
    
    ////////////////////////////////////////////////////////////////////////////
    // filterPanel 
    public function renderFilterPanel() {
        // Чтобы при обновлении страницы не сохранялись ранее выбранныеы значения
        $this->filterPanelSelectHtmlOptions['autocomplete'] = 'off';
        
        // Установка класса для панели фильтрации
        $this->addClassToHtmlOptions($this->filterPanelContainerHtmlOptions, self::FILTER_PANEL_CLASS);

        echo CHtml::openTag('div', $this->filterPanelContainerHtmlOptions)."\n";
            echo $this->prepareFilterPanelLink()."\n";
        
            // Вывод Header-а
            if ($this->filterPanelHeader !== '') {
                echo $this->filterPanelHeader;
            }
        
            foreach($this->filterPanelData as $dataElement) {
                $this->displayFilterPanelElement($dataElement);
            }
            echo "\n";
            $this->displayFilterPanelButton();
            
            // Вывод Footer-а
            if ($this->filterPanelFooter !== '') {
                echo $this->filterPanelFooter;
            }
        echo CHtml::closeTag('div')."\n";   
    }
    
    // Создаёт ссылку с адресом текущей страницы, но без
    // параметров панели фильтрации
    private function prepareFilterPanelLink() {
        $params = $_GET;
        foreach ($this->filterPanelData as $dataElement) {
            $paramterName = $dataElement['parameterName'];
            unset($params[$paramterName]);
        }
        
        //При применени фильтрации если нужно будем начинать с первой страницы
        if ($this->filterPanelResetPage) {
            $pageVar = $this->dataProvider->getPagination()->pageVar;
            unset($params[$pageVar]);
        }
        
        $link = CHtml::link(
                'hidden', 
                Yii::app()->controller->createUrl('', $params),
                array(
                    'style' => 'display : none;', 
                    'class' => self::FILTER_PANEL_HIDDEN_HREF_CLASS
                )
            );
            
        return $link;
    }
    
    private function displayFilterPanelElement($data) {
        $label = $data['label'];
        $name = $data['parameterName'];
        $selectOptions =  $data['options'];
        
        // Определяем установленно ли выбранное значение
        $selectedValue = null;
        if (isset($_GET[$name]) ) {
            $selectedValue = $_GET[$name];   
        }
        
        // Строка для вывода
        $out = $this->filterPanelElementTemplate;
        
        // Заменяем элемент {label}
        $out = preg_replace('/\{label\}/isu', $label, $out);
        
        // Формируем элемент select
        ob_start();
        echo CHtml::dropDownList(
            $name, 
            $selectedValue, 
            $selectOptions, 
            $this->filterPanelSelectHtmlOptions
        );
        $select = ob_get_contents();
        ob_end_clean();
        
        // Замена элемента {select}
        $out = preg_replace('/\{select\}/isu', $select, $out);
        
        // Вывод полученного элемента
        echo $out;
    }
    
    private function displayFilterPanelButton() {
        $out = $this->filterPanelButtonTemplate;
        
        // Установка класса для кнопки
        $this->addClassToHtmlOptions($this->filterPanelButtonHtmlOptions, self::FILTER_PANEL_FILTER_BUTTON_CLASS);
        
        $buttonLabel = '';
        if (!isset($this->filterPanelButtonHtmlOptions['value']) ) {
            $buttonLabel = self::DEFAULT_FILTER_PANEL_BUTTON_LABEL;
        }
        
        //Формируем элемент button
        ob_start();
        echo CHtml::button($buttonLabel, $this->filterPanelButtonHtmlOptions);
        $button = ob_get_contents();
        ob_end_clean();
        
        $out = preg_replace('/\{button\}/isu', $button, $out);
        echo $out;
    }
    
    private function registerScriptForFilterPanel() {
        $useAjax = $this->createStringForJSOnBooleanValue($this->ajaxUpdate);
        
        $filterPanelButtonFullSelector = 
            "#$this->id".
            " .".self::FILTER_PANEL_CLASS.
            " input[type=\"button\"].".self::FILTER_PANEL_FILTER_BUTTON_CLASS; 
        
        $scriptCode = 
        "
        $('$filterPanelButtonFullSelector').live('click', function(e) {
            ListViewHelper.filterPanelButtonClick(
                '$this->id',
                $useAjax
            );
        }); 
        ";   
        
        // Задаём уникальный id cкрипта
        $scriptId = 'filterPanelScript-'.$this->id;
        
        Yii::app()->clientScript->registerScript(
            $scriptId,
            $scriptCode,
            CClientScript::POS_HEAD
        );
    }
    
    private function createStringForJSOnBooleanValue($booleanValue) {
        if ($booleanValue) {
            return 'true';
        } else {
            return 'false';
        }
    }
    
    private function addClassToHtmlOptions(&$htmlOptions, $class) {
         if (isset($htmlOptions['class']) ) { 
            $htmlOptions['class'] .= ' '.$class;
        } else {
            $htmlOptions['class'] = $class;
        }
    }
    
}


