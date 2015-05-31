<?php

Yii::import('managers.SaveResult');
Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.ConvertHelper');

class VisitorScheduleManager {
    
    const ANY_WORK_TIME_STATE  = 'anyTimeState';
    
    public function __construct() {
    
    }
    
    public function getWorkDaysForSchedule($beginDate, $endDate, $idSpecialization, $idDoctor) {
        $beginDateDBView = DateFormatHelper::getDateDBView($beginDate);
        $endDateDBView = DateFormatHelper::getDateDBView($endDate);
        
        $criteria = new CDbCriteria();
        $criteria->addCondition("date >= '$beginDateDBView' AND date <= '$endDateDBView'");
        $criteria->addCondition("idSpecialization = $idSpecialization", "AND");
        if ($idDoctor === null) {
            $criteria->addCondition("idDoctor is NULL", "AND"); 
        } else {
            $criteria->addCondition("idDoctor = $idDoctor", "AND");   
        }
        $criteria->addCondition("published = TRUE");
        $criteria->order = "date ASC";

        
        $workDays = WorkDay::model()->findAll($criteria);
        return $workDays;
    }
    
    public function getCountsOfAllWorkTimeForSchedule($beginDate, $endDate, $idSpecialization, $idDoctor) {
        return $this->getCountsOfWorkTimeForSchedule($beginDate, $endDate, $idSpecialization, $idDoctor, self::ANY_WORK_TIME_STATE);
    }
    
    public function getCountsOfFreeWorkTimeForSchedule($beginDate, $endDate, $idSpecialization, $idDoctor) {
        return $this->getCountsOfWorkTimeForSchedule($beginDate, $endDate, $idSpecialization, $idDoctor, WorkTime::STATE_FREE);
    }
    
    public function getWorkDayWithTimeByAttribres($idSpecialization, $idDoctor, $date) {
        $dateDBView = DateFormatHelper::getDateDBView($date);
        if ($idDoctor === null) {
            $doctorCondition = "wd.idDoctor is NULL";
        } else {
            $doctorCondition = "wd.idDoctor = $idDoctor";
        }
        
        $criteria = new CDbCriteria();
        $criteria->alias = "wd";
        $criteria->with = array(
            'time' => array(
                'alias' => 'wt',
                'order' => 'wt.time ASC'
            )
        );
        $criteria->condition = "wd.date = '$dateDBView' AND wd.idSpecialization = $idSpecialization AND $doctorCondition";
        
        $workDay = WorkDay::model()->find($criteria);
        if($workDay === null) {
            throw new RowIsNotExistsException();
        }
        return $workDay;
    }
    
    
    // Возвращает массив(список) массивов с ключами id, date, count
    // Где id - id рабочего дня из таблицы {{workDay}}, 
    // date - его дата, а count - количство элементов WorkTime.
    // Если нужно то указывается $timeState - для выбора количества элементов WorkTime 
    // с определённым  состоянием
    /*
    // Пример запроса, который нужно получить
    SELECT wd.id, wd.date, COUNT(wt.id) 
        FROM rcptn_workDay wd LEFT JOIN rcptn_workTime wt 
        ON wd.id = wt.idWorkDay AND wt.state = 'free
        WHERE  wd.published = TRUE AND
    	   wd.idSpecialization = 16 AND
           wd.idDoctor = 10 AND
           wd.date >= '2015-02-10' AND wd.date <= '2015-02-15'
        GROUP BY wd.id, wd.date
        ORDER BY wd.date ASC
    */
    private function getCountsOfWorkTimeForSchedule($beginDate, $endDate, $idSpecialization, $idDoctor, $timeState = self::ANY_WORK_TIME_STATE) {
        $beginDateDBView = DateFormatHelper::getDateDBView($beginDate);
        $endDateDBView = DateFormatHelper::getDateDBView($endDate);
        
        $idDoctorCondition = "";
        if ($idDoctor === null) {
            $idDoctorCondition = "wd.idDoctor IS NULL";
        } else {
            $idDoctorCondition = "wd.idDoctor = $idDoctor";
        }
        
        $timeStateCondition = "";
        if ($timeState !== self::ANY_WORK_TIME_STATE) {
            $timeStateCondition = "AND wt.state = '$timeState'";
            
        }
        
        $sql =  "SELECT wd.id, wd.date, COUNT(wt.id) AS count ".
                    "FROM {{workDay}} AS wd LEFT JOIN {{workTime}} wt ".
                    "ON wd.id = wt.idWorkDay $timeStateCondition ".
                    "WHERE wd.idSpecialization = $idSpecialization AND $idDoctorCondition AND ".
                        "wd.published = TRUE AND ".
                        "wd.date >= '$beginDateDBView' AND wd.date <= '$endDateDBView' ".
                    "GROUP BY wd.id, wd.date ".
                    "ORDER BY wd.date ASC";
        
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader->readAll();
    }

}
