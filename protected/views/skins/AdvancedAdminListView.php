<?php

return array(
    'default' => array(
        
    ),
    
    'usingSorterPagerFilterPanel' => array (
        'ajaxUpdate' => true,
        'template' => '{filterPanel}{sorter}{pager}{items}{pager}',
              
        'sorterCssClass' => 'listView__sorter -azure -azure--hrefDecoration -roundedCorners',
        'sorterHeader' => 'Сортировка : ',   
        'sorterFooter' => '',
        'pagerCssClass' => 'listView__pager -azure -roundedCorners',
                 
        'pager' => array(
            'class' => 'AdminLinkPager',
            'htmlOptions' => array('class' => 'linkPager linkPager--blue'),
        ),
        
         // Настройка панели фильтрации         
        'filterPanelContainerHtmlOptions' => array('class' => 'listView__filterPanel listView__filterPanel--usingBlueInputItems -azure -roundedCorners'),
        'filterPanelElementTemplate' => '<span class="listView__filterPanelElement">'.
                                            '<span class="listView__filterPanelLabel">{label}</span>'.
                                            '<span class="selectWrapper">{select}</span>'.
                                        '</span>',
        'filterPanelSelectHtmlOptions' => array('class' => 'inputItem'),
        'filterPanelButtonHtmlOptions' => array('value' => 'Ok', 'class' => 'inputItem'),
        'filterPanelResetPage' => true
    ),
    
    'usingSorterPager' => array (
        'ajaxUpdate' => true,  
        'template' => '{sorter}{pager}{items}{pager}',
                   
        'sorterCssClass' => 'listView__sorter -azure -azure--hrefDecoration -roundedCorners',
        'sorterHeader' => 'Сортировка : ',   
        'sorterFooter' => '',
        'pagerCssClass' => 'listView__pager -azure -roundedCorners',

        'pager' => array(
            'class' => 'AdminLinkPager',
            'htmlOptions' => array('class' => 'linkPager linkPager--blue'),
        ), 
    ),
    
);