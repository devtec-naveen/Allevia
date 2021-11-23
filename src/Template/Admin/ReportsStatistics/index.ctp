
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>



  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Reports and Statistics 
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Reports and Statistics </li>
                            </ol>
                        </div>
   <div class="header">
          <?php //  echo  $this->Form->control('dob', ['type' => 'text', 'value' => (isset($user->dob)? $user->dob->i18nFormat('dd-MM-yyyy') : '') , 'class' => 'form-control', 'placeholder' => 'DOB', 'label' => false,  'id'=>'datetimepicker1', 'autocomplete' => 'off', 'required' => 'required']); ?>
   <?php echo $this->Form->create(null , array(   'autocomplete' => 'off', 'id' => 'datefilter', 
                                        
                            'inputDefaults' => array(
                            'label' => false,
                            'div' => false,
                                            
                            ),'enctype' => 'multipart/form-data')); ?>
                                           
    <input type="text" value="<?php echo isset($filter_start_date)? $filter_start_date->i18nFormat('MM-dd-yyyy') : '' ?>" name="start_date"  id='datetimepicker1' placeholder="Start Date">
    <input type="text" value="<?php echo isset($filter_end_date)? $filter_end_date->i18nFormat('MM-dd-yyyy') : '' ?>" name="end_date"  id='datetimepicker2' placeholder="End Date">  
    <input type="submit" class="btn btn-info" name="Filter" value="Filter">           
  <?php $this->Form->end(); ?>  
  <div class="filtererr" style="color: red;"></div>

   <script>

jQuery.validator.addMethod("greaterThan", 
function(value, element, params) {

 var end_date = moment(value, "MM-DD-YYYY"); // DD-MM-YYYY
    if (!/Invalid|NaN/.test(end_date)) {
       
var start_date = moment($("#datetimepicker1").val(), "MM-DD-YYYY"); // DD-MM-YYYY

        return end_date > start_date;
    }

    return isNaN(value) && isNaN($(params).val()) 
        || (Number(value) > Number($(params).val())); 
},'End Date must be greater than start date.');


jQuery.validator.addMethod("lessThan", 
function(value, element, params) {

 var start_date  = moment(value, "MM-DD-YYYY"); // DD-MM-YYYY
    if (!/Invalid|NaN/.test(end_date)) {
       
var end_date = moment($("#datetimepicker2").val(), "MM-DD-YYYY"); // DD-MM-YYYY

        return end_date > start_date;
    }

    return isNaN(value) && isNaN($(params).val()) 
        || (Number(value) > Number($(params).val())); 
},'Start Date must be less than end date.');

$("#datefilter").validate({
    rules: {
        end_date: { greaterThan: "#start_date" },
        start_date: { lessThan: "#end_date"}
    },
    showErrors: function(errorMap, errorList) {
        if(errorList.length > 0 )
            $('.filtererr').html('End Date must be greater than start date.'); 

    }
});


  $( function() {
    $( "#datetimepicker1" ).datepicker({
            changeMonth: true, 

    changeYear: true, 

  dateFormat: "mm-dd-yy" // "dd-mm-yy"
});

    $( "#datetimepicker2" ).datepicker({
            changeMonth: true, 

    changeYear: true, 

  dateFormat: "mm-dd-yy" // "dd-mm-yy"
});

  } );




  </script>
</div>

                        <div class="header">
<a href="<?php echo  ADMIN_SITE_URL ?>reports-statistics/index/1" class="btn btn-primary">Daily</a>
<a href="<?php echo ADMIN_SITE_URL ?>reports-statistics/index/2" class="btn btn-primary">Weekly</a>
<a href="<?php echo ADMIN_SITE_URL ?>reports-statistics/index/3" class="btn btn-primary">Monthly</a>
<a href="<?php echo ADMIN_SITE_URL ?>reports-statistics/index/4" class="btn btn-primary">Yearly</a>                            
                        </div>
                        <div class="body">

<?php 
// pr($max_date); 
// pr($user_count); die; 
?>                            


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>



<script type="text/javascript">
   

   var date_str =  '<?php echo $max_date->i18nFormat('yyyy/MM/dd'); ?>';  
    var max_date = new Date(date_str)

 var date_str1 =  '<?php echo $start_date->i18nFormat('yyyy/MM/dd'); ?>';  
    var min_date = new Date(date_str1)
var title = 'Appointmens/Registration trend' ; 
var subtitle = 'on the website';
 var pt_interval = parseInt('<?php echo $chart_type ?>') ; 

var ticknterval = 0 ; 
 if(pt_interval == 1){
    pt_interval = 24 * 3600 * 1000; 
    var ticknterval =  24 * 3600 * 1000; 
 title = 'Daily Appointments/User Registrations' ;  subtitle = 'Trend shows daily acitvity';
 }else if(pt_interval == 2){

    pt_interval = 7 * 24 * 3600 * 1000; 
    var ticknterval = 7 * 24 * 3600 * 1000; 
 title = 'Weekly Appointments/User Registrations' ;  subtitle = 'Trend shows weekly acitvity';    
 }else if(pt_interval == 3){
    pt_interval = 30 * 24 * 3600 * 1000; 
    var ticknterval = 30 * 24 * 3600 * 1000; 
 title = 'Monthly Appointments/User Registrations' ;  subtitle = 'Trend shows Monthly acitvity';
 }else if(pt_interval == 4){
    pt_interval = 12 * 30 * 24 * 3600 * 1000; 
    var ticknterval = 12 * 30 * 24 * 3600 * 1000; 
 title = 'Yearly Appointments/User Registrations' ;  subtitle = 'Trend shows Yearly acitvity';    
}

   var arrdata = [];
   <?php foreach ($user_count as $item) : ?>
   arrdata.push(parseFloat('<?php echo $item ; ?>'));
   <?php endforeach; ?>



   var apt_arrdata = [];
   <?php foreach ($apt_count as $item) : ?>
   apt_arrdata.push(parseFloat('<?php echo $item ; ?>'));
   <?php endforeach; ?>


// Data retrieved from http://vikjavev.no/ver/index.php?spenn=2d&sluttid=16.06.2015.
// alert(tickInterval) ; 

Highcharts.chart('container', {
    chart: {
        type: 'spline',
        scrollablePlotArea: {
            minWidth: 600,
            scrollPositionX: 1
        }
    },
    title: {
        text:  title // 'Appointmens/Registration trend'
    },
    subtitle: {
        text: subtitle // 'on the website'
    },
    xAxis: {
        type: 'datetime',
min:  Date.UTC(min_date.getUTCFullYear(), min_date.getUTCMonth(), min_date.getUTCDate()+1), //  new Date('2018/01/01').getTime(),
        max: Date.UTC(max_date.getUTCFullYear(), max_date.getUTCMonth(), max_date.getUTCDate()+1), //  new Date('2018/12/13').getTime(),        
        // labels: {
        //     overflow: 'justify'
        // },
      "tickInterval": ticknterval, // 365 * 24 * 3600 * 1000,
 labels: {
      format: '{value:%Y-%b-%e}'
    }       
    },

    yAxis: {
        title: {
            text: 'Count'
        },
        minorGridLineWidth: 0,
        gridLineWidth: 0,
        alternateGridColor: null,
  /*      plotBands: [{ // Light air
            from: 0.3,
            to: 1.5,
            color: 'rgba(68, 170, 213, 0.1)',
            label: {
                text: 'Light air',
                style: {
                    color: '#606060'
                }
            }
        }, { // Light breeze
            from: 1.5,
            to: 3.3,
            color: 'rgba(0, 0, 0, 0)',
            label: {
                text: 'Light breeze',
                style: {
                    color: '#606060'
                }
            }
        }, { // Gentle breeze
            from: 3.3,
            to: 5.5,
            color: 'rgba(68, 170, 213, 0.1)',
            label: {
                text: 'Gentle breeze',
                style: {
                    color: '#606060'
                }
            }
        }, { // Moderate breeze
            from: 5.5,
            to: 8,
            color: 'rgba(0, 0, 0, 0)',
            label: {
                text: 'Moderate breeze',
                style: {
                    color: '#606060'
                }
            }
        }, { // Fresh breeze
            from: 8,
            to: 11,
            color: 'rgba(68, 170, 213, 0.1)',
            label: {
                text: 'Fresh breeze',
                style: {
                    color: '#606060'
                }
            }
        }, { // Strong breeze
            from: 11,
            to: 14,
            color: 'rgba(0, 0, 0, 0)',
            label: {
                text: 'Strong breeze',
                style: {
                    color: '#606060'
                }
            }
        }, { // High wind
            from: 14,
            to: 15,
            color: 'rgba(68, 170, 213, 0.1)',
            label: {
                text: 'High wind',
                style: {
                    color: '#606060'
                }
            }
        }] */
    },
    tooltip: {
        valueSuffix: ' '
    },
    plotOptions: {
        spline: {
            lineWidth: 4,
            states: {
                hover: {
                    lineWidth: 5
                }
            },
            marker: {
                enabled: false
            },
            pointInterval: pt_interval, // 3600000*24, // one hour
            pointStart: Date.UTC(min_date.getUTCFullYear(), min_date.getUTCMonth(), min_date.getUTCDate()+1) // Date.UTC(2018, 8, 12, 0, 0, 0)
        }
    },
    series: [{
        name: 'User',
        data: arrdata
    }
    , {
        name: 'Appointment',
        data: apt_arrdata
    }


    ],
    navigation: {
        menuItemStyle: {
            fontSize: '10px'
        }
    }
});





</script>    