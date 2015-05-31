<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminController extends Controller
{
    public $layout='//layouts/admin';

    public $mainMenu = array();
    
     public function init() {
        parent::init();
           
        $this->attachBehavior(
            'checkAccessBehavior', 
            array(
                'class' => 'ext.behaviors.CheckAccessBehavior',
            )
        );
    }
    

    // Делает выбранным('active') пункт меню с заданным url
    // $menu должно быть в формате массива передаваемого виджету CMenu
    public function makeMenuItemActiveOnUrl(&$menu, $itemUrl) {
        foreach($menu as &$e) {
            if ($e['url'][0] === $itemUrl) {
                $e['active'] = true;
                break;
            }
        } 
    }
        
}