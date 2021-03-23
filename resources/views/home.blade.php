{{-- A more complicated application or implementation would break
 out the functionality of this page in to multiple components --}}
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Weather By IP Tool</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
              integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu"
              crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="jumbotron"><h1>Weather By IP Tool</h1></div>
            <div class="alert alert-danger" role="alert" style="display:none;" id="errorDiv">
                <strong>Error:</strong> There was an error fetching your weather data.
            </div>
            <form id="weatherForm" name="weatherForm">
                <input type="text" name="ip_address" id="ip_address"  value="{{ request()->get('ip_address', request()->ip()) }}" placeholder="IP ADDRESS">
                <input type="button" id="submitButton" value="Submit">
            </form>
            <div id="location_display">
            </div>
            <div id="weather_display">
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"
                integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
                integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
                crossorigin="anonymous"></script>
        <script>
            var displayDiv = $('#weather_display');
            var locationDisplay = $('#location_display');
            var submitButton = $('#submitButton');
            submitButton.on('click', getWeather);

            function getWeather() {
                submitButton.prop('disabled', true);
                submitButton.val('Please Wait...');
                displayDiv.empty();
                locationDisplay.empty();
                var response = $.ajax({
                    type: "GET",
                    url: './weatherLookup',
                    data: {
                        ip_address: $('#ip_address').val()
                    },
                    success: function (data) {
                        var dayData = '';
                        $('#errorDiv').hide();
                        locationDisplay.html(data.locationName + ' 5 Day Weather (Current Temp ' + data.current + '&deg;)');
                        $.each(data.results, function (key, day) {
                            dayData = dayData +
                                '<tr>' +
                                '<td class="res-date">' + day.date + '</td>' +
                                '<td class="res-temps"> ' + day.high + '&deg;/' + day.low + '&deg;</td>' +
                                '<td class="res-conditions"><img src="' + day.image + '"/>' + day.description + '</td>' +
                                '</tr>'
                            ;
                        });
                        displayDiv.append('<table class="table table-bordered"><tbody>' + dayData + '</tbody></table>');
                    },
                    error: function(e){
                        $('#errorDiv').show();
                    },
                    complete: function(e){
                        submitButton.prop('disabled', false);
                        submitButton.val('Submit');
                    }
                });
            }
            $(document).ready(getWeather);
        </script>
    </body>
</html>
