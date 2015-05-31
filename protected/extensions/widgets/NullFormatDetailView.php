<?php

Yii::import('zii.widgets.CDetailView');

// Отправляет Formater-y установленному для DetailView значение на обработку
// даже если оно равно null(стандартный CDetailView этого не делает - вместо этого
// он выводит значение свойства nullDisplay)
class NullFormatDetailView extends CDetailView {
    
    public function run()
    {
            $formatter=$this->getFormatter();
            if ($this->tagName!==null)
                    echo CHtml::openTag($this->tagName,$this->htmlOptions);

            $i=0;
            $n=is_array($this->itemCssClass) ? count($this->itemCssClass) : 0;

            foreach($this->attributes as $attribute)
            {
                    if(is_string($attribute))
                    {
                            if(!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/',$attribute,$matches))
                                    throw new CException(Yii::t('zii','The attribute must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
                            $attribute=array(
                                    'name'=>$matches[1],
                                    'type'=>isset($matches[3]) ? $matches[3] : 'text',
                            );
                            if(isset($matches[5]))
                                    $attribute['label']=$matches[5];
                    }

                    if(isset($attribute['visible']) && !$attribute['visible'])
                            continue;

                    $tr=array('{label}'=>'', '{class}'=>$n ? $this->itemCssClass[$i%$n] : '');
                    if(isset($attribute['cssClass']))
                            $tr['{class}']=$attribute['cssClass'].' '.($n ? $tr['{class}'] : '');

                    if(isset($attribute['label']))
                            $tr['{label}']=$attribute['label'];
                    elseif(isset($attribute['name']))
                    {
                            if($this->data instanceof CModel)
                                    $tr['{label}']=$this->data->getAttributeLabel($attribute['name']);
                            else
                                    $tr['{label}']=ucwords(trim(strtolower(str_replace(array('-','_','.'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $attribute['name'])))));
                    }

                    if(!isset($attribute['type']))
                            $attribute['type']='text';
                    if(isset($attribute['value']))
                            $value=is_object($attribute['value']) && get_class($attribute['value']) === 'Closure' ? call_user_func($attribute['value'],$this->data) : $attribute['value'];
                    elseif(isset($attribute['name']))
                            $value=CHtml::value($this->data,$attribute['name']);
                    else
                            $value=null;
                    
                    // Изначальный код
                    //$tr['{value}']=$value===null ? $this->nullDisplay : $formatter->format($value,$attribute['type']);
                    
                    // Изменённый код 
                    // Будем применять formatter в любом случае
                    $tr['{value}']=  $formatter->format($value,$attribute['type']);
                   
                    
                    
                    $this->renderItem($attribute, $tr);

                    $i++;
            }

            if ($this->tagName!==null)
                    echo CHtml::closeTag($this->tagName);
    }
    
    
}
