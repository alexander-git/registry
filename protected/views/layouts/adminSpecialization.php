<?php
    $this->beginContent(
        '//layouts/adminTwoColumns', 
        array(
            'sideMenuTitle' => 'Специализации',
            'sideMenu' => $this->specializationMenu,
        )
    ); 
?>
    <?php echo $content; ?> 
<?php $this->endContent(); 

