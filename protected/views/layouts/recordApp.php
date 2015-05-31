<?php header("Content-type: text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="ru" />

    <?php $assetsUrl = $this->assetsUrl; ?>
        
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/common/decoration.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/common/control.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/common/items.css" />
 
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/visitor/layout.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/visitor/items.css" />
    
    
    <title><?php echo CHtml::encode($this->pageTitle); ?></title> 
</head>
<body class="body">
    <div class="layout">
        <?php echo $content; ?>
    </div>
</body>
</html>
