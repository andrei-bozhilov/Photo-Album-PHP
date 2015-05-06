var Dom = (function () {
    var mainContainer = $("#album-list");

    function averageOfArray(arr) {
        return arr.reduce(function (pv, cv) { return parseInt(pv) + parseInt(cv); }, 0) / arr.length;
    }

    function formatDate(obj) {

        var months = ['01', '02', '03', '04', '05', '06',
            '07', '08', '09', '10', '11', '12'
        ];

        return obj.getDate() + '.' + months[obj.getMonth()] +
            '.' + obj.getFullYear();
    }
    /*
     * element is element from dom that holds information
     * changeElement is Dom element inside element
     */
    function changeRating(element, changeElement, value, textPrefix) {
        var ratingArr = $(element).data('rating');
        var newValue = parseInt(value);

        if (ratingArr == "undefined" || ratingArr == undefined) {
            var arr = [];
            arr.push(newValue);
            $(element).data('rating', arr);
        } else {
            ratingArr.push(newValue);
            $(element).data('rating', ratingArr);
        }

        var newRating = averageOfArray($(element).data('rating'));
        $(changeElement).text(textPrefix + newRating.toFixed(0) + ' / 10');
    }

    return {
        averageOfArray: averageOfArray,
        changeRating: changeRating
    }
})();