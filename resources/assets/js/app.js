// *************************************************************************
// *************************************************************************
// *************************************************************************


require('./bootstrap');

// #OFF CANVAS
// =========================================================================

var offCanvasTrigger = document.querySelector('.off-canvas__trigger');
var offCanvas = document.querySelector('.off-canvas');

if (offCanvasTrigger) {
    offCanvasTrigger.addEventListener('click', function () {
        offCanvas.classList.add('is--open');
        overlay.classList.add('is--active');
    });
}

// #OVERLAY
// =========================================================================

var overlay = document.querySelector('.overlay');

if (overlay) {
    overlay.addEventListener('click', function () {
        this.classList.remove('is--active');
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        offCanvas.classList.remove('is--open');
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        modal.classList.remove('is--open');
    });
}



$("#submit").on("click", function(){

    if ($('#website').val().length > 0)
    {
        var str = $('#website').val();

      if (str.indexOf("http://") >= 0 || str.indexOf("https://") >= 0) {

        if ($('#email').val().length > 0) {

            $(".loading-screen").addClass("loading");

        } else {
            console.log('no email value');
        }

      } else {
        console.log("invalid website");
      }

    } else {
        console.log("no website value");
    }
});

$("#results-submit").on("click", function(){

    if ($('#results-website').val().length > 0)
    {
        var str = $('#results-website').val();

      if (str.indexOf("http://") >= 0 || str.indexOf("https://") >= 0) {

        $(".loading-screen").addClass("loading");

      } else {
        console.log("invalid website");
      }

    } else {
        console.log("no website value");
    }
});

var optimized = $('.graph').data("optimized");
optimized = Math.round($('.graph').data("optimized"));

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Images", "CSS", "JavaScript", "HTML"],
        datasets: [{
            label: 'Optimized (KB)',
            data: $('.graph').data("optimized"),
            backgroundColor: [
                'rgba(254, 211, 80, 0.2)'
            ],
            borderColor: [
                'rgba(254, 211, 80, 1)'
            ],
            borderWidth: 1
        }, {
            label: 'Unoptimized (KB)',
            data: $('.graph').data("unoptimized"),
            backgroundColor: [
                'rgba(61, 81, 139, 0.2)'
            ],
            borderColor: [
                'rgba(61, 81, 139, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            labels: {
                defaultFontFamily: 'Montserrat'
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                },
                scaleLabel: {
                    display: true,
                    labelString: 'File Size in KB'
                  }
            }],
            xAxes: [{
              scaleLabel: {
                display: true,
                labelString: 'File Type'
              }
            }]
        }
    }
});