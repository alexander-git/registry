(function() {
 
    function fullDoctorNameFilter() {
        return function(doctor) {
            var result = doctor.surname;
            if (doctor.firstname !== '') {
                result += ' ' + doctor.firstname;
            }
            if (doctor.patronymic !== '') {
                result += ' ' + doctor.patronymic;
            }

            return result;
        };
    }
    
    function shortDoctorNameFilter() {
        return function(doctor) {
            var result = doctor.surname;
            if (doctor.firstname !== '') {
                result += ' ' + doctor.firstname[0] + '.';
            }
            if (doctor.patronymic !== '') {
                result += ' ' + doctor.patronymic[0] + '.';
            }

            return result;
        };
    }
    
    function dateSepartatedByDotsFilter() {
        return function(dateText) {
            var result = dateText;
            if (dateText[0] === '0') {
                result = dateText.substr(1);
            }
            result = result.replace(/\-/g, '.');
            return result;
        };
    }
    
    angular.module('common').filter('fullDoctorName', fullDoctorNameFilter);
    angular.module('common').filter('shortDoctorName', shortDoctorNameFilter);
    angular.module('common').filter('dateSeparatedByDots', dateSepartatedByDotsFilter);
})();