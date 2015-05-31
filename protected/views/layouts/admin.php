<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="ru" />
        
    <?php $assetsUrl = $this->assetsUrl; ?>
    
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/common/decoration.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/common/control.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/common/items.css" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/admin/admin.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/css/admin/layout.css" />
    
    <title><?php echo CHtml::encode($this->pageTitle); ?></title> 
</head>
<body class="body">
    <div class="layout">
        <?php if ($this->additionalLayout !== null ) : ?>
            <?php $this->beginContent("//layouts/$this->additionalLayout"); ?>
                <?php echo $content; ?> 
            <?php $this->endContent(); ?>
        <?php else : ?>
            <div>
                <?php echo $content; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
