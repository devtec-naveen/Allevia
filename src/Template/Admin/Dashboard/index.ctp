<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a style="text-decoration: none; cursor: pointer;" href="<?php echo ADMIN_SITE_URL; ?>organizations/doctors">

                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">healing</i>
                        </div>
                        <div class="content">
                            <div class="text"><h5><?php echo $tot_doc_count ; ?> Doctors</h5></div>
                            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    </a>
                </div>
                 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a style="text-decoration: none; cursor: pointer;"  href="<?php echo ADMIN_SITE_URL; ?>users">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person</i>
                        </div>
                        <div class="content">
                            <div class="text"><h5><?php echo $tot_user_count ; ?> Patients</h5></div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                   <a style="text-decoration: none; cursor: pointer;"  href="<?php echo ADMIN_SITE_URL; ?>organizations">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">work</i>
                        </div>
                        <div class="content">
                            <div class="text"><h5><?php echo $tot_org_count ; ?> Clinics</h5></div>
                            <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a style="text-decoration: none; cursor: pointer;"  href="<?php echo ADMIN_SITE_URL; ?>appointments">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">timer</i>
                        </div>
                        <div class="content">
                            <div class="text"><h5><?php echo $tot_app_count ; ?> Appointments</h5></div>
                            <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    </a>
                </div> 

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



            </div>
            <!-- #END# Widgets -->
        </div>
    </section>




<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


<script>
  var seeker = new Array();
  var dealer = new Array();
  var shop = new Array();
  var monthname = new Array();
  </script>
<?php 

foreach($datearr as $val){
if(!empty($val['usrcnt'])){
  ?>

<script>
seeker.push(<?php echo isset($val['usrcnt'][1]) ? $val['usrcnt'][1] : 0 ?>);
dealer.push(<?php echo isset($val['usrcnt'][2]) ? $val['usrcnt'][2] : 0 ?>);
shop.push(<?php echo isset($val['usrcnt'][3]) ? $val['usrcnt'][3] : 0 ?>);
</script>

  <?php 
}


  ?>
<script>
 monthname.push("<?php echo $monthname[$val['month']]?>");
</script>
  <?php 

}
?>


    <script>
// alert(monthname); 
for (i = 0; i < 10; i++) {
  if(!seeker[i]) seeker[i] = 0 ; 
  if(!dealer[i]) dealer[i] = 0 ; 
  if(!shop[i]) shop[i] = 0 ; 

}
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Patients,Doctors,Clinics Registration Graph'
    },
    subtitle: {
        text: 'Trend for last 1 Year'
    },
    xAxis: {
        // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
categories:   monthname      
    },
    yAxis: {
        title: {
            text: 'Number of User'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Doctors',
        // data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        data: seeker
    }, {
        name: 'Patients',
        // data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        data: dealer
    }, {
        name: 'Clinics',
        // data: [9.9, 8.2, 5.7, 9.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        data: shop
    }]
});
</script>
<style type="text/css">
    .info-box{ cursor: pointer; }
</style>