<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
    *{
        margin: 0;
        padding: 0;
        outline: none;
        box-sizing: border-box;
        font-family: 'Open Sans', sans-serif;
    }
    .container{
        width: 1200px;
        margin: 50px auto;
    }
    .dates form {
        text-align: right;
    }
     .dates form input{
         display: inline-block;
     }
     table{
         margin-top: 40px;
     }
     table th{
         font-size: 1.2em;
         text-align: left;
     }
     thead,tbody{
         width: 100%;
     }
     table th, table td{
         padding: 10px;
         border-top: 1px solid black;
         border-left: 1px solid black;
     }
     table th:last-child{
         border-right: 1px solid black;
     }
     table tr td:last-child{
         border-right: 1px solid black;
     }
     table tbody tr:last-child td{
         border-bottom: 1px solid black;
     }
     .container .table, .container .chart{
        display: inline-block;
        width: 48%;
        vertical-align: top;
     }
     .table{
         width: 100%;
         padding:10px;
     }
     .container .chart{
         margin-top: 40px;
         padding: 10px;
     }
     table{
         width: 100%;
     }
    </style>
</head>
<body>
    <div class="container">
        <div class="dates">
            <?php
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            
            ?>
            <form action="/" method="get">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <input type="date" name="from">
                <input type="date" name="to">
                <input type="submit" value="Update">
            </form>
        </div>
        <h2>List of all customers and # of leads</h2>
        <div>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Number of Leads</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($leads as $lead){
                        ?>
                        <tr>
                            <td><?= $lead->customer_name ?></td>
                            <td><?= $lead->number_of_leads ?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
           
            <div class="chart">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div>
        </div>
        
    </div>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <script>
        window.onload = function () {

         var leads = <?php echo json_encode($leads); ?>;
         var datas = [];
        leads.forEach(function(i){
            var data = {
                y: parseInt(i.number_of_leads),
                label:i.customer_name
            };
            datas.push(data);
        });
      

        var options = {
            title: {
                text: "Customer and number of new leads"
            },
            animationEnabled: true,
            data: [{
                type: "pie",
                startAngle: 40,
                toolTipContent: "<b>{label}</b>: {y}%",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - {y}%",
                dataPoints: datas
            }]
        };
        $("#chartContainer").CanvasJSChart(options);

        }
    </script>
</body>
</html>