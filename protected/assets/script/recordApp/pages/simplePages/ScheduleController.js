(function() {
    
    var injectParams = ['$scope', '$routeParams', '$sce', 'scheduleData'];
    
    var Day = function(workDay, freeCount, allCount) {
        this.workDay = workDay;
        this.freeCount = freeCount;
        this.allCount = allCount;
    };
    
    function createDayOffsetsObject(currentDayOffset, scheduleData) {
        var numberOfDays = scheduleData.dateHeads.length;
        var startingDayOffset = currentDayOffset;
        var dayOffsets = [];
        for (var i = 0; i < numberOfDays; i++) {
            dayOffsets.push(startingDayOffset + i);
        }
        
        var prevButtonDayOffset = startingDayOffset - numberOfDays;
        if (prevButtonDayOffset < 0) {
            prevButtonDayOffset = 0;
        }
        var nextButtonDayOffset = startingDayOffset + numberOfDays; 
        
        return {
            'startingDayOffset' : startingDayOffset,
            'dayOffsets' : dayOffsets,
            'prevButtonDayOffset' : prevButtonDayOffset,
            'nextButtonDayOffset' : nextButtonDayOffset
        };
    }
    
    function createDayArray(scheduleData) {
        var dayArray = [];
        var workDays = scheduleData.workDays;
        var freeTimeCounts = scheduleData.freeTimeCounts;
        var allTimeCounts = scheduleData.allTimeCounts;
        for (var i = 0; i <  workDays.length; i++) {
            if (workDays[i] !== null) {
                dayArray.push(new Day(workDays[i], freeTimeCounts[i], allTimeCounts[i]) );
            } else {
                dayArray.push(null);
            }
        }
        return dayArray;
    }
    
    var ScheduleController = function($scope, $routeParams, $sce, scheduleData) {
        $scope.$routeParams = $routeParams;
        $scope.workAreaCaption = "Выберите дату";
        
        var currentDayOffset = parseInt($routeParams.dayOffset);
        var offsets = createDayOffsetsObject(currentDayOffset, scheduleData);
        
        $scope.startingDayOffset = offsets.startingDayOffset;
        $scope.dayOffsets = offsets.dayOffsets;
        $scope.prevButtonDayOffset = offsets.prevButtonDayOffset;
        $scope.nextButtonDayOffset = offsets.nextButtonDayOffset;
                
        $scope.interval = $sce.trustAsHtml(scheduleData.intervalHtmlView);
        $scope.dateHeads = scheduleData.dateHeads;
        
        $scope.days = createDayArray(scheduleData);
        
        $scope.workAreaContentUrl = '/recordAppViews/schedule.html';
    };
    
    ScheduleController.$inject = injectParams;
    
    
    angular.module('simplePages').controller('ScheduleController', ScheduleController);
    
})(); 
 
