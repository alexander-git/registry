<?php
    $this->beginContent(
        '//layouts/adminTwoColumns',
        array(
            'sideMenuTitle' => 'Шаблоны',
            'sideMenu' => $this->templateWorkDayMenu,
        )
    ); 
?>
    <?php echo $content; ?> 
<?php $this->endContent(); 

