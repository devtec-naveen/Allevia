
<footer>
			<div class="FootBlue">
				<div class="container">
					<div class="row">
						<div class="col-md-10">
							<h6>Affordable, accessible, and effective healthcare for everyone</h6>
						</div>
						<div class="col-md-2">
							<a href="javascript:;" class="btn btn-white">Register Now</a>
						</div>
					</div>
				</div>
			</div>
			<div class="FooterMain">
				<div class="container">
					<div class="row">
						<div class="col-md-4 FooterLpart">
							<div class="FootLogoPart">
								<div class="FootLogo">
									<a href="javascript:;">
										<img src="images/logo-tm.png">
									</a>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								</div>
								<div class="FootAddress">
									<ul>
										<li>
											<a href="javascript:;">
												<span>
													<i class="fas fa-phone"></i>
												</span>
												<font>Call us: +1 800 833 9780</font>
											</a>
										</li>
										<li>
											<a href="javascript:;">
												<span>
													<i class="fas fa-map-marker-alt"></i>
												</span>
												<font>Example Road, 383</font>
											</a>
										</li>
										<li>
											<a href="javascript:;">
												<span>
													<i class="fas fa-envelope"></i>
												</span>
												<font>example@info.com</font>
											</a>
										</li>
									</ul>
								</div>

							</div>
						</div>
						<div class="col-md-8 FooterRight">
							<div class="row">
								<div class="col-md-6">
									<div class="FootLinkBox">
										<h5 class="FootHead">Useful Links</h5>
										<ul class="footLinks">
											<li><a href="javascript:;">About Us</a></li>
											<li><a href="javascript:;">Contact Us</a></li>
											<li><a href="javascript:;">Our Services</a></li>
											<li><a href="javascript:;">How It Works</a></li>
											<li><a href="javascript:;">Make Appoinment</a></li>
										</ul>
									</div>
								</div>
								<div class="col-md-6">
									<div class="FootLinkBox">
										<h5 class="FootHead">Connect with us</h5>
										<ul class="footSocial">
											<li><a href="javascript:;"><span><i class="fab fa-facebook-f"></i></span> Facebook</a></li>
											<li><a href="javascript:;"><span><i class="fab fa-twitter"></i></span> twitter</a></li>
											<li><a href="javascript:;"><span><i class="fab fa-instagram"></i> </span> instagram</a></li>
											<li><a href="javascript:;"><span><i class="fab fa-pinterest-p"></i></span> pinterest</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="FootCopyright">
				<div class="container text-center">
					<p>©  2018 Allevia. All rights reserved.</p>
				</div>
			</div>
		</footer>
	

</div>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>	
	<script type="text/javascript" src="js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="js/mdb.min.js"></script>	
	<script type="text/javascript" src="js/popper.min.js"></script>	
	<script type="text/javascript" src="js/rellax.min.js"></script>
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>

	<script>
		$(window).scroll(function(){
			var body = $('body'),
			scroll = $(window).scrollTop();

			if (scroll >= 5) body.addClass('fixed');
			else body.removeClass('fixed');
		});
	</script>
	<script type="text/javascript">
		var rellax = new Rellax('.ScrollElements'); 
	</script>
	<script type="text/javascript">
		$('.OurPartnerSlider').owlCarousel({
			loop:false,
			margin:0,
			nav:true,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:3
				},
				1000:{
					items:5
				}
			}
		})
	</script>
</body>	   
</html>
