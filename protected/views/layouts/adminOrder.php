<?php
    $this->beginContent(
        '//layouts/adminTwoColumns', 
        array(
            'sideMenuTitle' => 'Заявки',
            'sideMenu' => $this->orderMenu,
        )
    ); 
?>
    <?php echo $content; ?> 
<?php $this->endContent(); 

