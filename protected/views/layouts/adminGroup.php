<?php
    $this->beginContent(
        '//layouts/adminTwoColumns', 
        array(
            'sideMenuTitle' => 'Группы',
            'sideMenu' => $this->groupMenu,
        )
    ); 
?>
    <?php echo $content; ?> 
<?php $this->endContent(); 

