<?php
use Cake\Core\Configure;
$iframe_prefix = Configure::read('iframe_prefix');
  $url = $this->request->getParam('pass');
  $session_user = $this->request->getSession()->read('Auth.User');
  // pr($url);die;
  $schedule_data = null;
  //pr($url);
  if(!empty($url)){

    $schedule_id = base64_decode($url[1]);
    $schedule_data = $this->General->get_schedule($schedule_id);
  }

  $organization_data = null;
  if(!empty($schedule_data)){

    $organization_data = $this->General->get_organization_data($schedule_data['organization_id']);
  }
  if($allsettings['payment_mode'] == 2) {
            $publish_key = $allsettings['live_publish_key'];
          }else
          {
            $publish_key = $allsettings['test_publish_key'];
          } 

?>

<input type="hidden" class="timeinterval"/>
<link rel="stylesheet" type="text/css" href="<?= SITE_URL ?>css/jquery.datetimepicker.css"/>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="<?php echo WEBROOT.'frontend/css/new_appointment.css'; ?>" rel="stylesheet" type="text/css">
<!-- <script src="<?php //echo WEBROOT.'frontend/js/new_appointment.js'; ?>"></script> -->

<script src="<?= SITE_URL ?>js/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="global.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <!-- <script src="/client.js" defer></script> -->

<style type="text/css">

	.appointment_error{

		background: red;
	    padding: 15px;
	    margin-bottom: 10px
	}
</style>
<style type="text/css">

  /* Variables */
/** {
  box-sizing: border-box;
}*/

/*body {
  font-family: -apple-system, BlinkMacSystemFont, sans-serif;
  font-size: 16px;
  -webkit-font-smoothing: antialiased;
  display: flex;
  justify-content: center;
  align-content: center;
  height: 100vh;
  width: 100vw;
}*/

/*form {
  width: 30vw;
  min-width: 500px;
  align-self: center;
  box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
    0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
  border-radius: 7px;
  padding: 40px;
}*/

/*input {
  border-radius: 6px;
  margin-bottom: 6px;
  padding: 12px;
  border: 1px solid rgba(50, 50, 93, 0.1);
  height: 44px;
  font-size: 16px;
  width: 100%;
  background: white;
}*/

.result-message {
  line-height: 22px;
  font-size: 16px;
}

.result-message a {
  color: rgb(89, 111, 214);
  font-weight: 600;
  text-decoration: none;
}

.hidden {
  display: none;
}

#card-error {
  color: red;
  text-align: left;
  font-size: 14px;
  line-height: 17px;
  margin-top: 12px;
}

#card-element {
  border-radius: 4px 4px 0 0 ;
  padding: 12px;
  border: 1px solid rgba(50, 50, 93, 0.1);
  height: 44px;
  width: 100%;
  background: white;
}

#payment-request-button {
  margin-bottom: 32px;
}

/* Buttons and links */
button {
  background: #17358E;
  color: #ffffff;
  font-family: Arial, sans-serif;
  border-radius: 0 0 4px 4px;
  border: 0;
  padding: 12px 16px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  display: block;
  transition: all 0.2s ease;
  box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
  width: 100%;
}
button:hover {
  filter: contrast(115%);
}
button:disabled {
  opacity: 0.5;
  cursor: default;
}

/* spinner/processing state, errors */
.spinner,
.spinner:before,
.spinner:after {
  border-radius: 50%;
}
.spinner {
  color: #ffffff;
  font-size: 22px;
  text-indent: -99999px;
  margin: 0px auto;
  position: relative;
  width: 20px;
  height: 20px;
  box-shadow: inset 0 0 0 2px;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.spinner:before,
.spinner:after {
  position: absolute;
  content: "";
}
.spinner:before {
  width: 10.4px;
  height: 20.4px;
  background: #5469d4;
  border-radius: 20.4px 0 0 20.4px;
  top: -0.2px;
  left: -0.2px;
  -webkit-transform-origin: 10.4px 10.2px;
  transform-origin: 10.4px 10.2px;
  -webkit-animation: loading 2s infinite ease 1.5s;
  animation: loading 2s infinite ease 1.5s;
}
/*.spinner:after {
  width: 10.4px;
  height: 10.2px;
  background: #5469d4;
  border-radius: 0 10.2px 10.2px 0;
  top: -0.1px;
  left: 10.2px;
  -webkit-transform-origin: 0px 10.2px;
  transform-origin: 0px 10.2px;
  -webkit-animation: loading 2s infinite ease;
  animation: loading 2s infinite ease;
}*/

@-webkit-keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@media only screen and (max-width: 600px) {
  form {
    width: 80vw;
  }
}

</style>
<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
    <?php if(empty($iframe_prefix)){ ?>
     <div class="dashboard_menu ">
      <ul>
	 <?php if(!empty($session_user) && $session_user['role_id'] == 2){ ?>
	  <?php } ?>
	  </ul>
     </div>
    <?php } ?>

	 <div class="dashboard_content animated fadeInRight ">
	 <?= $this->Flash->render() ?>
	
	  <div class="dashboard_head">
	  	<h2>Payment Information</h2>
	   <!-- <h2 id="payment_heading">Copayment Responsibility</h2> -->
	  </div>
		<div class="errorHolder">
  </div>
  <?php 
  //session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
  ?>

	  <div class="dashboard_appointments_box">
	  	<div id="copayment_res">
	  		<?php if(!empty($payment_amount)){ ?>
	  		<p>Your copayment responsibility is $<?php echo number_format($payment_amount,2);?></p>
	  	<?php } ?>
	  	</div>
	   <div class="new_appointment_form">
		</div>
		<?php echo $this->Form->Create('paybucard' , array('autocomplete' => 'off',
			'inputDefaults' => array(
							'label' => false,
							'div' => false,
							),'enctype' => 'multipart/form-data', 'id' => 'payment-form')); ?>
							<input type="hidden" name="_csrfToken" autocomplete="off" value="<?php echo $token;?>">
		<div id="card-element"><!--Stripe.js injects the Card Element--></div>
      <button id="submit">
        <div class="spinner hidden" id="spinner"></div>
        <span id="button-text">Pay Now</span>
      </button>
      <p id="card-error" role="alert"></p>
      <p class="result-message hidden">
        Payment succeeded, see the result in your
        <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
      </p>
      <?php $this->Form->end(); ?>
			</ul>
		</div> 
	   </div>
	  </div>
	 </div>
   	</div>
   </div>
  </div>
 </div>
<script type="text/javascript">
$(document).ready(function(){
	if($(window).width() < 700){

		$("#dash_chnge").html('dashboard');
		$("#new_apt_chnge").html('appointment');
		$("#prev_apt_chnge").html('summaries');
		$("#med_his_chnge").html('medical history');

	}
$('#creditcard').keyup(function() {
  var foo = $(this).val().split("-").join(""); // remove hyphens
  if (foo.length > 0) {
    foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
  }
  $(this).val(foo);
});


});

  // A reference to Stripe.js initialized with a fake API key.
// Sign in to see examples pre-filled with your key.
var PUBLISH_KEY = '<?php echo $publish_key; ?>';
// alert(PUBLISH_KEY)
var stripe = Stripe(PUBLISH_KEY);
var csrfToken =document.querySelector('input[name=_csrfToken]').value;
var amount = '<?php echo $payment_amount;?>';
var schedule_id = '<?php echo $schedule_id;?>';
//alert(csrfToken)
// The items the customer wants to buy
var purchase = {
  items: [{ id: schedule_id }],
  data:{
    "amount":amount,
    "schedule_id":schedule_id
  }
};

// Disable the button until we have Stripe set up on the page

document.querySelector("button").disabled = true;
fetch("<?php echo SITE_URL.'users/paybycard'; ?>", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    'X-CSRF-Token': csrfToken
  },
  body: JSON.stringify(purchase)

})
  .then(function(result) {
    return result.json();
  })
  .then(function(data) {
    var elements = stripe.elements();

    var style = {
      base: {
        color: "#32325d",
        fontFamily: 'Arial, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
          color: "#32325d"
        }
      },
      invalid: {
        fontFamily: 'Arial, sans-serif',
        color: "#fa755a",
        iconColor: "#fa755a"
      }
    };

    var card = elements.create("card", { style: style });
    // Stripe injects an iframe into the DOM
    card.mount("#card-element");

    card.on("change", function (event) {
      // Disable the Pay button if there are no card details in the Element
      document.querySelector("button").disabled = event.empty;
      document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
    });

    var form = document.getElementById("payment-form");
    // var hiddenInput = document.createElement('input');
    // hiddenInput.setAttribute('type', 'hidden');
    // hiddenInput.setAttribute('name', 'description');
    // hiddenInput.setAttribute('value',"A demo of a card payment on Stripe");
    //alert(hiddenInput)
    // console.log(hiddenInput);
    // form.appendChild(hiddenInput);
    
    form.addEventListener("submit", function(event) {
      event.preventDefault();
      // Complete payment when the submit button is clicked
      payWithCard(stripe, card, data.clientSecret);
    });
  });

// Calls stripe.confirmCardPayment
// If the card requires authentication Stripe shows a pop-up modal to
// prompt the user to enter authentication details without leaving your page.
var payWithCard = function(stripe, card, clientSecret) {
  loading(true);
  stripe.confirmCardPayment(clientSecret, {
      payment_method: {
        card: card
      }
    })
    .then(function(result) {      
      if (result.error) {

        // Show error to your customer
        showError(result.error.message);
      } else {
        // The payment succeeded!
        orderComplete(result.paymentIntent.id,result);
      }
    });
};

/* ------- UI helpers ------- */

// Shows a success message when the payment is complete
searchRequest = null;
var orderComplete = function(paymentIntentId,result) {
  loading(false);
  result.schedule_id = schedule_id;
  if (searchRequest != null)
							searchRequest.abort();
						  searchRequest = $.ajax({
								type: "POST",
								url: "<?php echo SITE_URL; ?>"+"/users/transactionhistory",
								data: result,
								dataType: "json",
								success: function(msg){                
                  var response = JSON.parse(JSON.stringify(msg));
                  console.log(response.paymentIntent.status);
                  var paid_amount = (response.paymentIntent.amount/100).toFixed(2);
  									if(response.paymentIntent.status = 'succeeded')
  									{
  										showError("Payment amount $"+paid_amount+" has been done successfully");
  										$("#card-error").css("color",'green');
  										document.querySelector("button").disabled = true;
  									}
  									else
  									{
  										showError("Payment has been Failed");
  										document.querySelector("button").disabled = true;
  									}
  									
  								}
						});
  // document
  //   .querySelector(".result-message a")
  //   .setAttribute(
  //     "href",
  //     "https://dashboard.stripe.com/test/payments/" + paymentIntentId
  //   );
  // document.querySelector(".result-message").classList.remove("hidden");
  // document.querySelector("button").disabled = true;
};

// Show the customer the error from Stripe if their card fails to charge
var showError = function(errorMsgText) {
  loading(false);
  var errorMsg = document.querySelector("#card-error");
  errorMsg.textContent = errorMsgText;
  setTimeout(function() {
    errorMsg.textContent = "";
  }, 10000);
};


var loading = function(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("button").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("button").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
};


// Show a spinner on payment submission


</script>
