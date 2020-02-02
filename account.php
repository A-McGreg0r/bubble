<head>
    <title>Account </title>
</head>
<!--left-->

<div class="card justify-content-center ">
    <!--Title-->
    <h4 class="card-title"><a><strong>My Account</strong></a></h4>
    <!-- Card content -->
    <div class="card-body ">


        <div class="flex-row">
            e:mail
        </div>

        <div class="flex-row justify-content-between">
            <div class="col-md-6">
                firss name
            </div>
            <div class="col-md-6">
                surname
            </div>
        </div>
        <div class="flex-row">
            addr1
        </div>
        <div class="flex-row">
            addr2
        </div>
        <div class="flex-row">
            postcode:
        </div>

        <button onclick=deleteAccount()>


        </button>

    </div>


    <!-- Editable table -->
    <!-- TODO replace with mroe solid and less Editable ver  -->
    <div class="card">
        <h3 class="card-header text-center font-weight-bold text-uppercase py-4">Devices</h3>
        <div class="card-body">
            <div id="table" class="table-editable">
      <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i
                      class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
                <table class="table table-bordered table-responsive-md table-striped text-center">
                    <thead>
                    <tr>
                        <th class="text-center">device name</th>
                        <th class="text-center">type</th>
                        <th class="text-center">location</th>
                        <th class="text-center">consumption</th>
                        <th class="text-center">Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="pt-3-half" contenteditable="true">mylight</td>
                        <td class="pt-3-half" contenteditable="true">lightbulb</td>
                        <td class="pt-3-half" contenteditable="true">Deepends</td>
                        <td class="pt-3-half" contenteditable="true">8w</td>
                        <td class="pt-3-half">
              <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up"
                                                                         aria-hidden="true"></i></a></span>
                            <span class="table-down"><a href="#!" class="indigo-text"><i
                                            class="fas fa-long-arrow-alt-down"
                                            aria-hidden="true"></i></a></span>
                        </td>
                        <td>
              <span class="table-remove"><button type="button"
                                                 class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="true">mylight</td>
                        <td class="pt-3-half" contenteditable="true">lightbulb</td>
                        <td class="pt-3-half" contenteditable="true">Deepends</td>
                        <td class="pt-3-half" contenteditable="true">8w</td>
                        <td class="pt-3-half">
              <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up"
                                                                         aria-hidden="true"></i></a></span>
                            <span class="table-down"><a href="#!" class="indigo-text"><i
                                            class="fas fa-long-arrow-alt-down"
                                            aria-hidden="true"></i></a></span>
                        </td>
                        <td>
              <span class="table-remove"><button type="button"
                                                 class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="true">mylight</td>
                        <td class="pt-3-half" contenteditable="true">lightbulb</td>
                        <td class="pt-3-half" contenteditable="true">liveing room</td>
                        <td class="pt-3-half" contenteditable="true">8w</td>
                        <td class="pt-3-half">
              <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up"
                                                                         aria-hidden="true"></i></a></span>
                            <span class="table-down"><a href="#!" class="indigo-text"><i
                                            class="fas fa-long-arrow-alt-down"
                                            aria-hidden="true"></i></a></span>
                        </td>
                        <td>
              <span class="table-remove"><button type="button"
                                                 class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="true">mylight</td>
                        <td class="pt-3-half" contenteditable="true">lightbulb</td>
                        <td class="pt-3-half" contenteditable="true">liveing room</td>
                        <td class="pt-3-half" contenteditable="true">8w</td>
                        <td class="pt-3-half">
              <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up"
                                                                         aria-hidden="true"></i></a></span>
                            <span class="table-down"><a href="#!" class="indigo-text"><i
                                            class="fas fa-long-arrow-alt-down"
                                            aria-hidden="true"></i></a></span>
                        </td>
                        <td>
              <span class="table-remove"><button type="button"
                                                 class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="true">mylight</td>
                        <td class="pt-3-half" contenteditable="true">lightbulb</td>
                        <td class="pt-3-half" contenteditable="true">liveing room</td>
                        <td class="pt-3-half" contenteditable="true">8w</td>
                        <td class="pt-3-half">
              <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up"
                                                                         aria-hidden="true"></i></a></span>
                            <span class="table-down"><a href="#!" class="indigo-text"><i
                                            class="fas fa-long-arrow-alt-down"
                                            aria-hidden="true"></i></a></span>
                        </td>
                        <td>
              <span class="table-remove"><button type="button"
                                                 class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="true">mylight</td>
                        <td class="pt-3-half" contenteditable="true">lightbulb</td>
                        <td class="pt-3-half" contenteditable="true">liveing room</td>
                        <td class="pt-3-half" contenteditable="true">8w</td>
                        <td class="pt-3-half">
              <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up"
                                                                         aria-hidden="true"></i></a></span>
                            <span class="table-down"><a href="#!" class="indigo-text"><i
                                            class="fas fa-long-arrow-alt-down"
                                            aria-hidden="true"></i></a></span>
                        </td>
                        <td>
                                <span class="table-remove">
                                    <button type="button"
                                            class="btn btn-danger btn-rounded btn-sm my-0">Remove
                                    </button>
                                </span>
                        </td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Editable table -->


</div>

<!-- Card -->
<script>
    const $tableID = $('#table');
    const $BTN = $('#export-btn');
    const $EXPORT = $('#export');

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

    $('.table-add').on('click', 'i', () => {

        const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line');

        if ($tableID.find('tbody tr').length === 0) {

            $('tbody').append(newTr);
        }

        $tableID.find('table').append($clone);
    });

    $tableID.on('click', '.table-remove', function () {

        $(this).parents('tr').detach();
    });

    $tableID.on('click', '.table-up', function () {

        const $row = $(this).parents('tr');

        if ($row.index() === 1) {
            return;
        }

        $row.prev().before($row.get(0));
    });

    $tableID.on('click', '.table-down', function () {

        const $row = $(this).parents('tr');
        $row.next().after($row.get(0));
    });

    // A few jQuery helpers for exporting only
    jQuery.fn.pop = [].pop;
    jQuery.fn.shift = [].shift;

    $BTN.on('click', () => {

        const $rows = $tableID.find('tr:not(:hidden)');
        const headers = [];
        const data = [];

        // Get the headers (add special header logic here)
        $($rows.shift()).find('th:not(:empty)').each(function () {

            headers.push($(this).text().toLowerCase());
        });

        // Turn all existing rows into a loopable array
        $rows.each(function () {
            const $td = $(this).find('td');
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

