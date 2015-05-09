var Actions = (function () {
    
       var sliderMargin = 0;
       
    function sliderNext() {
        if (sliderMargin <= 1800) {
            sliderMargin += 150;
        }
        else if (sliderMargin >= 750 && sliderMargin < 1800) {
            sliderMargin = 1800;
        }
        document.getElementById('carousel').style.marginLeft = "-"+sliderMargin+"px";
    }

    function sliderPrev() {
        if (sliderMargin >= 150) {
            sliderMargin -= 150;
        }
        else if (sliderMargin >= 0 && sliderMargin < 150) {
            sliderMargin = 0;
        }
        document.getElementById('carousel').style.marginLeft = "-"+sliderMargin+"px";
    }
   

    return {
        sliderNext: sliderNext,
        sliderPrev: sliderPrev
    }
}());