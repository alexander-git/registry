<?php
    $this->beginContent(
        '//layouts/adminTwoColumns', 
        array(
            'sideMenuTitle' => 'Управление',
            'sideMenu' => $this->manageMenu,
        )
    ); 
?>
    <?php echo $content; ?> 
<?php $this->endContent(); 

