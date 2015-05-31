<?php
/* @var $this OrderController */
/* @var $data Order */

Yii::import('constant.view.OrderViewConst');
Yii::import('constant.view.SpecializationViewConst');
Yii::import('constant.view.DoctorViewConst');
Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.TimeFormatHelper');
Yii::import('helpers.DateTimeFormatHelper');

?>
<div class="orderList__listItem -cyan -cyan--linkDecoration -roundedCorners">
    <div class="-floatRight">
        <span class="orderList__orderDateTime">
            <?php 
                $dateTime = DateTimeFormatHelper::getDateTimeFromDBView($data->orderDateTime);
                $dateTextView = DateFormatHelper::getDayRussianMounthYearDateTextView($dateTime);
                $timeCommonTextView = TimeFormatHelper::getTimeCommonTextiew($dateTime);
            ?>
            <?php echo $dateTextView.' '.$timeCommonTextView; ?>
        </span>
    </div>


    <div>
        <span class="orderList__name">
            <?php echo CHtml::encode(OrderViewConst::getNameTextView($data->firstname, $data->surname, $data->patronymic) ); ?>
        </span> 
        &nbsp;|&nbsp;
        <span class="orderList__phone">
            тел. <?php echo CHtml::encode($data->phone); ?>
        </span>
    </div>

    <div class="orderList__row -marginTop10">
        <span class="orderList__specialization">
                <?php 
                $specializationName = SpecializationViewConst::getSpecializationTextView(
                    $data->specialization->name, 
                    $data->specialization->additional
                );
                echo CHtml::link(
                    CHtml::encode($specializationName),
                    array('admin/schedule/specialization', 
                          'idSpecialization' =>$data->idSpecialization,
                    ),
                    array(
                        'class' => 'link',
                        'title' => 'Смотреть расписание'
                    )
                );
            ?>
        </span>
    </div>
  
    <?php if ($data->idDoctor !== null) : ?>
         <div class="orderList__row">
             <span class="orderList__doctor">
                 <?php 
                     $doctorName = DoctorViewConst::getDoctorTextView(
                         $data->doctor->firstname, 
                         $data->doctor->surname,
                         $data->doctor->patronymic,
                         $data->doctor->additional
                     );
                     echo CHtml::link(
                         CHtml::encode($doctorName),
                         array('admin/schedule/doctor', 
                               'idDoctor' =>$data->idDoctor,
                         ),
                         array(
                             'class' => 'link',
                             'title' => 'Смотреть расписание'
                         )
                     );
                 ?>
             </span>
         </div>
    <?php endif; ?>     
   
    <div class="orderList__row">
        <span class="orderList__date"> 
            <?php echo CHtml::encode(DateFormatHelper::dateDBViewToDateCommonTextView($data->date) ); ?>
        </span>
        |
        <span class="orderList__time">
            <?php echo CHtml::encode(TimeFormatHelper::timeDBViewToTimeShortTextView($data->time) ); ?>
        </span>  
    </div>
    
    
    <table class="orderList__bottom -marginTop5">
        <tr>
            <td class="orderList__processedAndState">
                <span class="orderList__processed">
                   <?php $processedText = OrderViewConst::getProcessedTextView($data->processed); ?>
                   <?php if ($data->processed) :?>
                        <span class="-pear">
                           <?php echo $processedText; ?>
                        </span>    
                    <?php else : ?>
                        <span class="-blue">
                            <?php echo $processedText; ?>
                        </span>
                    <?php endif; ?>
                </span>
                &nbsp;|&nbsp;
                <span class="orderList__state">
                    <?php echo OrderViewConst::getStateTextView($data->state); ?>
                </span>
            </td>      
            <td class="orderList__mainControl">
                <div class="-floatRight">
                    <?php
                        echo CHtml::link(
                            CHtml::image(
                                Yii::app()->request->baseUrl.'/images/grayBlueMagnifier.gif',
                                'Просмотр',
                                array('style' => 'height : 25px;')
                            ),
                            array('admin/order/view', 
                                  'id' =>$data->id,
                            ),
                            array(
                                'class' => 'link',
                                'title' => 'Просмотр'
                            )
                        );
                    ?> 
                    <?php if ($this->isUserCanModifyOrders) : ?>
                        &nbsp;
                        <?php
                            echo CHtml::link(
                                CHtml::image(
                                    Yii::app()->request->baseUrl.'/images/grayBluePencil.gif',
                                    'Измененить',
                                    array('style' => 'height : 25px;')
                                ),
                                array('admin/order/update', 
                                      'id' =>$data->id,
                                ),
                                array(
                                    'class' => 'link',
                                    'title' => 'Измененить'
                                )
                            );
                        ?> 
                        &nbsp;
                        <?php
                            echo CHtml::link(
                                CHtml::image(
                                    Yii::app()->request->baseUrl.'/images/grayBlueDelete.gif',
                                    'Удалить',
                                    array('style' => 'height : 25px;')
                                ),
                                array('admin/order/delete', 
                                      'id' =>$data->id,
                                ),
                                array(
                                    'class' => 'link -jsListItemAjaxDeleteLink',
                                    'title' => 'Удалить'
                                )
                            );
                        ?> 
                    <?php endif; ?>
                </div>
                <?php if ($this->isUserCanModifySchedule) : ?>
                    <div class="orderInfoStore -floatRight -marginRight10 -paddingRight10 -blueRightBorder2">
                        <?php $this->renderPartial('_orderInfoStoreDataContainer', array('order' => $data) ); ?>
                        <?php
                            echo CHtml::image(
                                Yii::app()->request->baseUrl.'/images/grayBlueDaySchedule.gif',
                                'Изменить время',
                                array(
                                    'style' => 'height : 25px;',
                                    'class' => '-jsSafeModifyDayDialogButton -cursorPointer',
                                    'title' => 'Изменить время'
                                )
                            );
                        ?>
                    </div>
                <?php endif; ?>
                <div class="-stopFloat"></div>
            </td>
        </tr>
    </table>

</div>
