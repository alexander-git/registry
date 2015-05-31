<?php
    $this->beginContent(
        '//layouts/adminTwoColumns', 
        array(
            'sideMenuTitle' => 'Пользователи',
            'sideMenu' => $this->userMenu,
        )
    ); 
?>
    <?php echo $content; ?> 
<?php $this->endContent(); 

