<?php
include_once dirname(__DIR__) . '/required/config.php';

function generateAdviceTab()
{
    global $db;
    $html = '<div class="accordion md-accordion z-depth-1-half weather-page" id="advice-encompass" role="tablist" aria-multiselectable="true">';

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        session_write_close();
        $stmt3 = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmt3->bind_param("i", $user_id);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        if ($result3->num_rows === 1) {
            extract($result3->fetch_assoc());
        }

        $stmt = $db->prepare("SELECT * FROM hub_users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hub_id = $row['hub_id'];
                $stmt1 = $db->prepare("SELECT * FROM hub_info WHERE hub_id = ?");
                $stmt1->bind_param("i", $hub_id);
                $stmt1->execute();
                $result1 = $stmt1->get_result();

                $temp = rand(280,303);

                if ($result1->num_rows === 1) {
                    $row1 = $result1->fetch_assoc();
                    $hub_name = $row1['hub_name'];
                    if (empty($hub_name)) {
                        $hub_name = "My Home";
                    }

                    $ip = $ip_address;
                    // $latlong = explode(",", file_get_contents('https://ipapi.co/' . $ip . '/latlong/'));
                    // $weather = file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat=' . $latlong[0] . '&lon=' . $latlong[1] . '&appid=f35e0bdca477a802831ce6202240dc8d');
                    // $current_weather = json_decode($weather,true);
                    // $temp = $current_weather['main']['temp'];

                    $temp = $temp - 273;
                    $temp_round = number_format($temp,1);
                    $bg = "";
                    $advice = "";

                    $weather_symbol = '';

                    if($temp >= 18) {
                        $weather_symbol = "<img class='weather_symbol_small' src='../img/sun.png'>";
                        $bg = "#5fb0ff";
                        $advice = "<table class='weather_table'>
                                    <tr>
                                        <th class='weather_analysis'>It's a nice, hot day!</th>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You should consider turning off all heaters to save energy</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Turn off your light bulbs, open your curtains wide, and let the natural light in</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>It's hot enough to dry your washing outside, save the cost of using the tumble dryer</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Open a window instead of using the air conditioner</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>The weather is glorious, go outside and get some fresh air</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Have a cold dinner and save energy from your oven</td>
                                    </tr></table>";
                    } else if($temp < 18 && $temp >= 14) {
                        $weather_symbol = "<img class='weather_symbol' src='../img/sun_cloud.png'>";
                        $bg = "#9ec7ee";
                        $advice = "<table class='weather_table'>
                                    <tr>
                                        <th class='weather_analysis'>It's a warm day!</th>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You should consider turning off all heaters to save energy</td>
                                    </tr><tr class='advice_point'>
                                        <td>Turn off your light bulbs, open your curtains wide, and let the natural light in</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>It's warm enough to dry your washing outside, save the cost of using the tumble dryer</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>The weather is nice, wouldn't it be nice to go outside for a bit? Turning all of your devices off of course...</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>A nice book in the sun sounds far more enjoyable than watching TV...</td>
                                    </tr></table>";
                    } else if($temp < 14 && $temp >= 9) {
                        $weather_symbol = "<img class='weather_symbol' src='../img/cloud.png'>";
                        $bg = "#b7c2cc";
                        $advice = "<table class='weather_table'>
                                    <tr>
                                        <th class='weather_analysis'>It's a mild day!</th>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You should consider keeping heaters on low to save energy</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Turn off your light bulbs in rooms that have enough natural light</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>It probably isn't warm enough to have fun outside... maybe a brisk walk?</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>If it gets any colder it might be an idea to get a blanket</td>
                                    </tr></table>";
                    } else if($temp < 9 && $temp >= 5) {
                        $weather_symbol = "<img class='weather_symbol' src='../img/dark_cloud.png'>";
                        $bg = "#bcbcbc";
                        $advice = "<table class='weather_table'>
                                    <tr>
                                        <th class='weather_analysis'>It's a chilly day!</th>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You should consider turning off all air conditioners to save energy</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Try to keep heaters on lower settings</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Cold drinks raise your body temperature, so forgo that hot cup of tea and keep the kettle off. This may be a myth actually...</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>What's your favourite quick, homely meal? Making a quick meal will use less energy</td>
                                    </tr></table>";
                    } else if ($temp < 5) {
                        $weather_symbol = "<i class='far fa-snowflake weather_symbol_large' style='color:white'></i>";
                        $bg = "rgb(100, 100, 100)";
                        $advice = "<table class='weather_table'>
                                    <tr>
                                        <th class='weather_analysis'>It's a very cold day!</th>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You should consider turning off all air conditioners to save energy</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Turn heaters up to keep warm, comfort is important too</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>This feels like a movie day, snuggle up in your duvets and settle to a movie. You might not even need the heaters...</tr>
                                    </td>
                                    <tr class='advice_point'>
                                        <td>Put a jumper on if you're cold</tr>
                                    </td>
                                    </table>";
                    }

                    $html .= <<<html
                    <div class="weather_bar" style="background-color:$bg">$weather_symbol&nbsp;$temp_round&#176;C</div>
                    <div class="weather_advice">
                        <div class="weather_advice_header"><h4 class="section-title">Advice</h4></div>
                        <div class="weather_advice_body">$advice</div>
                    </div>
html;
                }
                $stmt1->close();

            }
        }

        $stmt->close();
    }

    $html .= "</div>";

    return $html;

}

?>

