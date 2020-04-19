<?php
include_once dirname(__DIR__) . '/required/config.php';

function generateAdviceTab()
{
    global $db;
    $html = '<div class="accordion md-accordion z-depth-1-half weather-page" id="advice-encompass" role="tablist" aria-multiselectable="true">';

    $hour = date('H') + 1;
    if($hour == 24) {
        $hour = "00";
    } else if($hour < 10) {
        $hour = "0$hour";
    }
    $minute = date('i');
    $day = date('d');
    $month = date('m');
    $year = date('Y');

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $hub_id = $_SESSION['hub_id'];
        $ip_address = "";

        session_write_close();
        $stmt3 = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmt3->bind_param("i", $user_id);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        if ($result3->num_rows === 1) {
            extract($result3->fetch_assoc());
        }

        $stmt = $db->prepare("SELECT * FROM hub_users WHERE hub_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $hub_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $stmt1 = $db->prepare("SELECT * FROM hub_info WHERE hub_id = ?");
                $stmt1->bind_param("i", $hub_id);
                $stmt1->execute();
                $result1 = $stmt1->get_result();

                $temp = rand(273,303);

                if ($result1->num_rows === 1) {
                    $row1 = $result1->fetch_assoc();
                    $hub_name = $row1['hub_name'];
                    $ip_address = $row1['hub_public_adr'];
                    if (empty($hub_name)) {
                        $hub_name = "My Home";
                    }

                    $latlong = explode(",", file_get_contents('https://ipapi.co/' . $ip_address . '/latlong/'));
                    $weather = file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat=' . $latlong[0] . '&lon=' . $latlong[1] . '&appid=f35e0bdca477a802831ce6202240dc8d');
                    $current_weather = json_decode($weather,true);
                    $temp = $current_weather['main']['temp'];
                    $location = $current_weather['name'];

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
                                        <td>You should consider turning off all heaters to save energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Turn off your light bulbs, open your curtains wide, and let the natural light in.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>It's hot enough to dry your washing outside, save the cost of using the tumble dryer.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Open a window instead of using the air conditioner.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>The weather is glorious, go outside and get some fresh air.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Have a cold dinner and save energy from your oven.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You could close your window blinds and curtains during the day to keep the temperature down.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Take a shorter and cooler shower.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Ensure the boiler is set to a lower setting as water will heat up much faster on a hot day.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Try and limit hairdryer use and let it dry naturally.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep the fridge full. An empty fridge wastes far more energy than a full one as when food is compacted together it keeps cooler longer and easier.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>.</td>
                                    </tr></table>";
                    } else if($temp < 18 && $temp >= 14) {
                        $weather_symbol = "<img class='weather_symbol' src='../img/sun_cloud.png'>";
                        $bg = "#9ec7ee";
                        $advice = "<table class='weather_table'>
                                    <tr>
                                        <th class='weather_analysis'>It's a warm day!</th>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You should consider turning off all heaters to save energy.</td>
                                    </tr><tr class='advice_point'>
                                        <td>Turn off your light bulbs, open your curtains wide, and let the natural light in.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>It's warm enough to dry your washing outside, save the cost of using the tumble dryer.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>The weather is nice, wouldn't it be nice to go outside for a bit? Turning all of your devices off of course...</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>A nice book in the sun sounds far more enjoyable than watching TV...</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You can close your window blinds and curtains during the day to keep the temperature down.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Washing clothes at 30-40 degrees will save energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Take a shorter and cooler shower.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep the fridge full. An empty fridge wastes far more energy than a full one as when food is compacted together it keeps cooler longer and easier.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Ensure the boiler is set to a lower setting as water will heat up much faster on a warm day.</td>
                                    </tr></table>";
                    } else if($temp < 14 && $temp >= 9) {
                        $weather_symbol = "<img class='weather_symbol' src='../img/cloud.png'>";
                        $bg = "#b7c2cc";
                        $advice = "<table class='weather_table'>
                                    <tr>
                                        <th class='weather_analysis'>It's a mild day!</th>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You should consider keeping heaters on low to save energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Turn off your light bulbs in rooms that have enough natural light.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>It probably isn't warm enough to have fun outside... maybe a brisk walk?</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>If it gets any colder it might be an idea to get a blanket.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Washing clothes at 30-40 degrees will save energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep your heating at a consistent level, as turning it off and on uses more energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Drop the pressure of your shower and try make it short.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep the oven door open after cooking a meal, let the heat spread through your kitchen.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep the fridge full. An empty fridge wastes far more energy than a full one as when food is compacted together it keeps cooler longer and easier.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Drawing the curtains will keep a substantial amount of heat in.</td>
                                    </tr>
                                    </table>";
                    } else if($temp < 9 && $temp >= 5) {
                        $weather_symbol = "<img class='weather_symbol' src='../img/dark_cloud.png'>";
                        $bg = "#bcbcbc";
                        $advice = "<table class='weather_table'>
                                    <tr>
                                        <th class='weather_analysis'>It's a chilly day!</th>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You should consider turning off all air conditioners to save energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Try to keep heaters on lower settings.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Cold drinks raise your body temperature, so forgo that hot cup of tea and keep the kettle off. This may be a myth actually...</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>What's your favourite quick, homely meal? Making a quick meal will use less energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Washing clothes at 30-40 degrees will save energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Ensure all windows are sealed tightly to prevent draught.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Wear warm clothing, you could save up to £60 per year by turning your thermostat down by just 1 degree!</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep your heating at a consistent level, as turning it off and on uses more energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep the oven door open after cooking a meal, let the heat spread through your kitchen.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep the fridge full. An empty fridge wastes far more energy than a full one as when food is compacted together it keeps cooler longer and easier.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Don't place anything in front of the radiator that will block the heat.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Drawing the curtains will keep a substantial amount of heat in.</td>
                                    </tr></table>";

                    } else if ($temp < 5) {
                        $weather_symbol = "<i class='far fa-snowflake weather_symbol_large' style='color:white'></i>";
                        $bg = "rgb(100, 100, 100)";
                        $advice = "<table class='weather_table'>
                                    <tr>
                                        <th class='weather_analysis'>It's a very cold day!</th>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>You should consider turning off all air conditioners to save energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Turn heaters up to keep warm, comfort is important too.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>This feels like a movie day, snuggle up in your duvets and settle to a movie. You might not even need the heaters...</tr>
                                    .</td>
                                    <tr class='advice_point'>
                                        <td>Put a jumper on if you're cold</tr>
                                    .</td>
                                    <tr class='advice_point'>
                                        <td>Washing clothes at 30-40 degrees will save energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Ensure all windows are sealed tightly to prevent draught.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Wear warm clothing, you could save up to £60 per year by turning your thermostat down by just 1 degree!</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep your heating at a consistent level, as turning it off and on uses more energy.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep the oven door open after cooking a meal, let the heat spread through your kitchen.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Keep the fridge full. An empty fridge wastes far more energy than a full one as when food is compacted together it keeps cooler longer and easier.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Don't place anything in front of the radiator that will block the heat.</td>
                                    </tr>
                                    <tr class='advice_point'>
                                        <td>Drawing the curtains will keep a substantial amount of heat in.</td>
                                    </tr>
                                    </table>";
                    }

                    $html .= <<<html
                    <div class="weather_bar" style="background-color:$bg">$weather_symbol<table style="width:100%"><tr><td style="font-weight:700;width:50%;font-size:40px!important;text-align:right;">&nbsp;$temp_round&#176;C&nbsp;</td><td style="line-height:12px;width:50%;text-align:left;"><strong style="font-size:12px">&nbsp;Time: $hour:$minute<br>&nbsp;Date: $day/$month/$year<br>&nbsp;Location: $location</strong></td></tr></table></div>
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

