<?php
include_once dirname(__DIR__).'/required/config.php';
function generateAccount(){
    global $db;
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $stmt = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            extract($result->fetch_assoc());


            $html = <<<html
            <div class="card justify-content-center ">
            <!--Title-->
            <h4 class="card-title mb-0 mt-3">
                <div class="row">
                    <strong>My Account</strong>
                </div>
            </h4>
            <!-- Card content -->
            <div class="card-body">
                <div class="flex-row justify-content-between">
                    <div class="col-md-6">
                        Email: $email 
                    </div>
                    <div class="col-md-6">
                        First Name: $first_name
                    </div>
                    <div class="col-md-6">
                        First Name: $last_name
                    </div>
                    <div class="col-md-6">
                    Address: $address_l1 $address_l2 $postcode
                    </div>
                </div>
                <button onclick=deleteAccount()></button>
            </div>
    
    
            <!-- Editable table -->
            <div class="card">
                <h3 class="card-header text-center font-weight-bold text-uppercase py-4">Devices</h3>
                <div class="card-body">
                    <div id="table" class="table-editable">
                        <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
                        <table class="table table-bordered table-responsive-md table-striped text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Device</th>
                                    <th class="text-center">Room</th>
                                    <th class="text-center">Consumption</th>
                                    <th class="text-center">Remove</th>
                                </tr>
                                </thead>
                                <tbody>
html;
            $user_id = $_SESSION['user_id'];
            $stmt1 = $db->prepare("SELECT * FROM hub_users WHERE user_id = ?");
            $stmt1->bind_param("i", $user_id);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            //SELECT ALL HUBS FROM USERID
            if ($result1->num_rows > 0) {
                while($row = $result1->fetch_assoc()) {
                    $hub_id = $row['hub_id'];
                    $stmt2 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
                    $stmt2->bind_param("i", $hub_id);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    //SELECT ALL DEVICES FROM HUB_ID
                    if ($result2->num_rows > 0) {
                        while($row2 = $result2->fetch_assoc()) {
                            $device_name = $row2['device_name'];
                            $device_type = $row2['device_type'];

                            $html .= <<<device
                                <tr>
                                    <td class="pt-3-half" contenteditable="true">$device_type $device_name</td>
                                    <td class="pt-3-half" contenteditable="true">8w</td>
                                    <td class="pt-3-half">
                                        <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
                                        <span class="table-down"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
                                    </td>
                                    <td>
                                        <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                                    </td>
                                </tr>   
device;
                        }
                    }
                }
            }

            $html .= '    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>';
        
        $html .= '
        <script>
            const $tableID = $("#table");
            const $BTN = $("#export-btn");
            const $EXPORT = $("#export");
    
            const newTr = `
        <tr class="hide">
        <td class="pt-3-half" contenteditable="true">Example</td>
        <td class="pt-3-half" contenteditable="true">Example</td>
        <td class="pt-3-half" contenteditable="true">Example</td>
        <td class="pt-3-half" contenteditable="true">Example</td>
        <td class="pt-3-half" contenteditable="true">Example</td>
        <td class="pt-3-half">
            <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
            <span class="table-down"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
        </td>
        <td>
            <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Remove</button></span>
        </td>
        </tr>`;
    
            $(".table-add").on("click", "i", () => {
    
                const $clone = $tableID.find("tbody tr").last().clone(true).removeClass("hide table-line");
    
                if ($tableID.find("tbody tr").length === 0) {
    
                    $("tbody").append(newTr);
                }
    
                $tableID.find("table").append($clone);
            });
    
            $tableID.on("click", ".table-remove", function () {
    
                $(this).parents("tr").detach();
            });
    
            $tableID.on("click", ".table-up", function () {
    
                const $row = $(this).parents("tr");
    
                if ($row.index() === 1) {
                    return;
                }
    
                $row.prev().before($row.get(0));
            });
    
            $tableID.on("click", ".table-down", function () {
    
                const $row = $(this).parents("tr");
                $row.next().after($row.get(0));
            });
    
            // A few jQuery helpers for exporting only
            jQuery.fn.pop = [].pop;
            jQuery.fn.shift = [].shift;
    
            $BTN.on("click", () => {
    
                const $rows = $tableID.find("tr:not(:hidden)");
                const headers = [];
                const data = [];
    
                // Get the headers (add special header logic here)
                $($rows.shift()).find("th:not(:empty)").each(function () {
    
                    headers.push($(this).text().toLowerCase());
                });
    
                // Turn all existing rows into a loopable array
                $rows.each(function () {
                    const $td = $(this).find("td");
                    const h = {};
    
                    // Use the headers from earlier to name our hash keys
                    headers.forEach((header, i) => {
    
                        h[header] = $td.eq(i).text();
                    });
    
                    data.push(h);
                });
    
                // Output the result
                $EXPORT.text(JSON.stringify(data));
            });
        </script>
        ';
        }
    }

    return $html;

}
?>
