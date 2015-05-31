<?php
    $this->beginContent(
        '//layouts/adminTwoColumns', 
        array(
            'sideMenuTitle' => 'Врачи',
            'sideMenu' => $this->doctorMenu,
        )
    ); 
?>
    <?php echo $content; ?> 
<?php $this->endContent(); 

