<?php 
    require_once '_header.php';
?>
<div class="layout__content layout__content--usingTwoColumns">
    <div class=layout__leftColumn>
        <div class="-padding10"> 
            <?php echo $content; ?>
        </div>
    </div>
    <div class="layout__rightColumn">
        <div class="-padding10"> 
            <div class="sideBlockHeader -pear -roundedCornersTop">
                <?php echo $sideMenuTitle; ?>
            </div>
            <div class="sideBlock -blue -roundedCornersBottom"> 
                <?php
                    $this->widget('zii.widgets.CMenu', array(
                            'items' => $sideMenu,
                            'htmlOptions'=>array(
                                'class'=>'sideBlock__menu -verticalMenu -azureList -azureList--hrefDecoration -azureList--hrefDecorationByImages'
                                ),
                            'activeCssClass' => 'active',
                            'activateItems' => true,
                            'itemCssClass' => '-roundedCorners',
                        )
                    );    
                ?>
            </div> 

        </div>
    </div>
    <div class="-stopFloat"></div>
</div>