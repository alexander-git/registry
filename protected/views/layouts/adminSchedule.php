<?php
    $this->beginContent(
        '//layouts/adminTwoColumns', 
        array(
            'sideMenuTitle' => 'Расписание',
            'sideMenu' => $this->scheduleMenu,
        )
    ); 
?>
    <?php echo $content; ?> 
<?php $this->endContent(); 

