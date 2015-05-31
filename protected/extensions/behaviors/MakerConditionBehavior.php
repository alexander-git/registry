<?php


class MakerConditionBehavior extends CBehavior {
   
    const DEFAULT_ENABLED_GET_VAR_NAME = 'enabled';
    const DEFAULT_ID_GROUP_GET_VAR_NAME = 'idGroup';
    const DEFAULT_ORDER_PROCESSED_GET_VAR_NAME = 'processed';
    const DEFAULT_ORDER_STATE_GET_VAR_NAME = 'state';
    
    public $enabledGetVarName = self::DEFAULT_ENABLED_GET_VAR_NAME;
    public $idGroupGetVarName = self::DEFAULT_ID_GROUP_GET_VAR_NAME;
    public $orderProcessedGetVarName = self::DEFAULT_ORDER_PROCESSED_GET_VAR_NAME;
    public $orderStateGetVarName = self::DEFAULT_ORDER_STATE_GET_VAR_NAME;
    
    public function prepareEnableConditionOnGetVariable($tableAlias = '') {
        $prefix = $this->createPrefixOnTableAlias($tableAlias);
       
        $condition = '';
        if ((isset($_GET[$this->enabledGetVarName])) && ($_GET[$this->enabledGetVarName] !== '') ) {
            $enabled = $_GET[$this->enabledGetVarName];
            
            if ($enabled === 'enabled') {
                $condition = $prefix.'enabled = TRUE';
            } elseif ($enabled === 'disabled') {
                $condition = $prefix.'enabled = FALSE';
            }   
        }
        return $condition;
    }
       
    public function prepareIdGroupConditionOnGetVariable($tableAlias = '') {
        $prefix = $this->createPrefixOnTableAlias($tableAlias);
        
        $condition = '';
        if ((isset($_GET[$this->idGroupGetVarName])) && ($_GET[$this->idGroupGetVarName] !== '') ) {
            $idGroup = $_GET[$this->idGroupGetVarName];
            
            if ($idGroup === 'all') {
                $condition = '';
            } elseif ($idGroup === 'null') {
                $condition = $prefix.'idGroup IS NULL';
            } else {
                $condition = $prefix.'idGroup = '.$idGroup;
            }
        }
        
        return $condition;
    }
    
    public function prepareOrderProcessedConditionOnGetVariable($tableAlias = '') {
        $prefix = $this->createPrefixOnTableAlias($tableAlias);
        
        $condition = '';
        if ((isset($_GET[$this->orderProcessedGetVarName])) && ($_GET[$this->orderProcessedGetVarName] !== '') ) {
            $processed = $_GET[$this->orderProcessedGetVarName];
            
            if ($processed === 'all') {
                $condition = '';
            } else if ($processed === 'true') {
                $condition = $prefix.'processed = TRUE';
            } else if ($processed === 'false') {
                $condition = $prefix.'processed = FALSE';
            }
        }
        
        return $condition;
    }
    
     public function prepareOrderStateConditionOnGetVariable($tableAlias = '') {
        $prefix = $this->createPrefixOnTableAlias($tableAlias);
        
        $condition = '';
        if ((isset($_GET[$this->orderStateGetVarName])) && ($_GET[$this->orderStateGetVarName] !== '') ) {
            $state = $_GET[$this->orderStateGetVarName];
            
            if ($state  === 'all') {
                $condition = '';
            } else if ($state  === Order::STATE_NOT_DEFINED) {
                $condition = $prefix."state = '".Order::STATE_NOT_DEFINED."'";
            } else if ($state === Order::STATE_RESOLVED) {
                $condition = $prefix."state = '".Order::STATE_RESOLVED."'";
            } else if ($state === Order::STATE_REJECTED) {
                $condition = $prefix."state = '".Order::STATE_REJECTED."'";
            }
        }
        
        return $condition;
    }
    
    
    
    public function andConditions($conditionA ='', $conditionB ='') {
        if ($conditionA === '') {
            return $conditionB;
        } elseif ($conditionB === '') {
            return $conditionA;
        } else {
            return $conditionA.' AND '.$conditionB;
        }
    }
    
    private function createPrefixOnTableAlias($tableAlias) {
        if ($tableAlias !== '') {
            $prefix = $tableAlias.'.';
        } else {
            $prefix = '';
        }
        return $prefix;
    }
      
    
}
