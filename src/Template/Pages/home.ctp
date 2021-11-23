<!-- <div class="wraper">
            <div class="HomeSlider">                
                <div id="video-carousel-example2" class="carousel slide carousel-fade" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                     


                <?php 
                    if(!empty($banner_data)){
                        $i = 1; 
                        foreach ($banner_data as $key => $value) {                          

                ?>
                   <div class="carousel-item <?php echo $i == 1 ? 'active' : '' ?> ">
                            <div class="view">
                                <img src="<?php echo WEBROOT.'img/'.$value->image ?>">
                            </div>
                            <div class="carousel-caption">
                                <div class="container">
                                    <div class="animated fadeInLeft">
                                        <article>
                                            <h3 class="h3-responsive"><?php echo $value->banner_title;  ?></h3>
                                            <p><?php echo $value->banner_text;  ?></p>
                                            <a target="_blank" href="<?php echo $value->banner_url;  ?>" class="btn"><?php echo $value->url_text;  ?></a>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php 
                           $i++; 
                        }
                    }
                    ?>                          
                    </div>          
                </div>
            </div>          
            <div class="AboutHome section-padding">
                <img src="<?php echo WEBROOT.'images/shape1.svg' ?>" class="ScrollElements" data-rellax-speed="6">
                <img src="<?php echo WEBROOT.'images/shape1.svg' ?>" class="ScrollElements ScrollElements1" data-rellax-speed="3">
                <img src="<?php echo WEBROOT.'images/shape1.svg' ?>" class="ScrollElements ScrollElements2" data-rellax-speed="4">
                <div class="container">
                    <div class="TitleHead">
                        <h3><?php echo $homepagedata->homepage_sec2_maintitle ?></h3>
                        <div class="seprator"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <figure>
                                <img src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec2_img ?>">
                            </figure>
                        </div>
                        <div class="col-md-7">
                            <div class="AboutHeadLine">
                           <?php echo $homepagedata->homepage_sec2_subtitle ?>
                       </div>
                        <?php echo $homepagedata->homepage_sec2_content ?>
                        </div>
                    </div>        
        
                </div>
                <?php if(!empty($homepagedata->homepage_embed_video_url) && (filter_var($homepagedata->homepage_embed_video_url, FILTER_VALIDATE_URL) !== FALSE)) { ?>
                <div class="AboutVideo">
                    <div class="container">
                        <div class="VideoFrame">
                            <iframe width="100%" height="400" src="<?php echo $homepagedata->homepage_embed_video_url ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>

<div class="HowItWorks section-padding">
                <div class="container">
                    <div class="TitleHead">
                        <h3><?php echo $homepagedata->homepage_sec1_main_title ?></h3>
                        <div class="seprator"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <article>
                                <figure>
                                    <img src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec1_img1 ?>">
                                </figure>
                                <figcaption>
                                    <h4><?php echo $homepagedata->homepage_sec1_subtitle1 ?></h4>
                                   <?php echo $homepagedata->homepage_sec1_content1 ?>
                                </figcaption>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article>
                                <figure>
                                    <img src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec1_img2 ?>">
                                </figure>
                                <figcaption>
                                    <h4><?php echo $homepagedata->homepage_sec1_subtitle2 ?> </h4>
                                   <?php echo $homepagedata->homepage_sec1_content2 ?> 
                                </figcaption>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article>
                                <figure>
                                    <img src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec1_img3 ?>">
                                </figure>
                                <figcaption>
                                    <h4><?php echo $homepagedata->homepage_sec1_subtitle3 ?></h4>
                                   <?php echo $homepagedata->homepage_sec1_content3 ?>
                                </figcaption>
                            </article>
                        </div>
                    </div>
                </div>
            </div>


            <div class="ResultSec section-padding">
                <img src="<?php echo WEBROOT.'images/shape2.svg' ?>" class="ScrollElements" data-rellax-speed="2">
                <img src="<?php echo WEBROOT.'images/shape3.svg' ?>" class="ScrollElements2" data-rellax-speed="5">
                <div class="container">
                    <div class="TitleHead">
                        <h3><?php echo $homepagedata->homepage_sec3_maintitle ?></h3>
                        <div class="seprator"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="ResultAccordian">
                                <div class="accordion" id="accordionEx" role="tablist" aria-multiselectable="true">


                <?php 
                    if(!empty($value_props_data)){
                    $i = 1;
                        foreach ($value_props_data as $key => $value) {

                          ?>

                                    <div class="card">
                                        <div class="card-header" role="tab" id="heading<?php echo $i ;  ?>">
                                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapse<?php echo $i ;  ?>" aria-expanded=" <?php echo $i == 1 ? 'true' : 'false' ?> " aria-controls="collapse<?php echo $i ;  ?>">
                                                <h5 class="mb-0">
                                                    <img src="<?php echo WEBROOT.'img/'.$value->image ?>">  <?php echo $value->heading ?><i class="fa fa-angle-down rotate-icon"></i>
                                                </h5>
                                            </a>
                                        </div>
                                        <div id="collapse<?php echo $i ;  ?>" class="collapse <?php echo $i == 1 ? 'show' : '' ?> " role="tabpanel" aria-labelledby="heading<?php echo $i ;  ?>" data-parent="#accordionEx">
                                            <div class="card-body">
                                               <?php echo $value->description ?>
                                            </div>
                                        </div>
                                    </div>


                    <?php 
                    $i++; 
                                            }

                    }

                    ?>                                  
                                  
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <article>
                                <img src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec3_image ?>">
                            </article>
                        </div>
                    </div>
                </div>
            </div>
            <div class="HelthcareSec section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 HelthcareLeft">
                            <div class="ProBox">
                                <h5><?php echo $homepagedata->homepage_sec4_maintitle ?></h5>
                                <div class="BullteList">
                                   <?php echo $homepagedata->homepage_sec4_content ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 HelthcareRight">
                            <div class="AlleviaTabel">
                                <figure>
                                    <img src="<?php echo WEBROOT.'images/logo-tm.png' ?>">
                                </figure>
                                <table>
                                    <?php 
                                    if(!empty($homepagedata->homepage_sec4_tabletext)){
                $homepagedata->homepage_sec4_tabletext = explode('###', $homepagedata->homepage_sec4_tabletext);
                $homepagedata->homepage_sec4_tabletext = array_filter($homepagedata->homepage_sec4_tabletext) ; 

                foreach ($homepagedata->homepage_sec4_tabletext as $key => $value) {
       
   
                                    ?>
                                    <tr>
                                        <td><?php echo $value ; ?></td>
                                        <td>
                                            <img src="<?php echo WEBROOT.'images/checked.svg' ?>">
                                        </td>
                                    </tr>


<?php 
             }
                                    }
          ?>                                    
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="OurPartner section-padding">
                <div class="container">
                    <div class="TitleHead">
                        <h3><?= $allsettings['our_partners_heading'] ?></h3>
                        <div class="seprator"></div>
                    </div>
                    <div class="OurPartnerSlider owl-carousel owl-theme">

                <?php 
                foreach ($our_partners_data as $key => $value) {
                ?>
                    <div class="item">
                            <a href="javascript:;">
                                <article>
                                    <img src="<?php echo WEBROOT.'img/'.$value->image ?>">
                                </article>
                            </a>
                        </div>

                <?php
                }
                ?>
                    </div>
                </div>
            </div>

        </div>
<style type="text/css">
.HowItWorks.section-padding {
    padding-top: 0;
}
</style> -->     

      <div class="site-wraper">
        <section class="home-banner">
          <div class="container">
            <div class="row">
              <div class="col-md-5">
                  <div class="banner-ai-info">
                      <div class="line-close-tx">
                       <h6>Say Hello to</h6>
                       <h5>AlleviaMD</h5>
                       <p>Your virtual medical assistant</p>
                      </div>
                     <div class="banner-rw-ai">
                        <a href="<?= SITE_URL.'users/preceding_signup' ?>" class="btn btn-blue">Sign Up</a>
                        <a href="javascript:;" class="btn btn-blue">Learn More</a>
                     </div>
                  </div>
              </div>
              <div class="col-md-7">
                  <div class="banner-ai" data-aos="zoom-in" data-aos-duration="1600">                     
                     <img src="<?php echo WEBROOT.'images/banner-ai.svg' ?>">
                  </div>
              </div>
            </div>
          </div>
        </section>

        <section class="how-it-sec">
          <div class="container">
            <div class="row first">
              <div class="col-md-12 required-bx">
                  <h5>Skip the appointments. Get care to your doorstep in minutes. <br> No doctor visits required.</h5>
                  <p>AlleviaMD is a healthcare service powered by state of the art automation technology. It’s a new kind of care - one that’s on your time, your terms, and tailored to you.</p>
              </div>
            </div>
            <div class="row second">
               <div class="col-md-12">
                 <div class="main-head"><h2>HOW IT WORKS</h2></div>
               </div>
               <div class="col-md-4">
                  <div class="article-work-sec">
                    <figure><img src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec1_img1 ?>"></figure>
                    <h4><?php echo $homepagedata->homepage_sec1_subtitle1 ?></h4>
                    <p><?php echo $homepagedata->homepage_sec1_content1 ?></p>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="article-work-sec">
                    <figure><img src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec1_img2 ?>"></figure>
                    <h4><?php echo $homepagedata->homepage_sec1_subtitle2 ?></h4>
                    <p><?php echo $homepagedata->homepage_sec1_content2 ?></p>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="article-work-sec">
                    <figure><img src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec1_img3 ?>"></figure>
                    <h4><?php echo $homepagedata->homepage_sec1_subtitle3 ?></h4>
                    <p><?php echo $homepagedata->homepage_sec1_content3 ?></p>
                  </div>
               </div>
            </div>
          </div>
        </section>

        <section class="the-perks-sec">
          <div class="container">
            <div class="main-head"><h2>The Perks</h2></div>
            <div class="row">
              <div class="col-md-6">
                 <div class="perks-box">
                    <figure><img src="images/perks-icon-1.svg"></figure>
                    <figcaption>
                        <h4>No health insurance required</h4>
                        <p>You don’t pay for an oil change with car insurance. The same concept should apply to healthcare.</p>
                    </figcaption>
                 </div>
              </div>
              <div class="col-md-6">
                 <div class="perks-box">
                    <figure><img src="images/perks-icon-2.svg"></figure>
                    <figcaption>
                        <h4>Always affordable.</h4>
                        <p>Your personalized Care Packages & services are always less than $30.</p>
                    </figcaption>
                 </div>
              </div>
              <div class="col-md-6">
                 <div class="perks-box">
                    <figure><img src="images/perks-icon-3.svg"></figure>
                    <figcaption>
                        <h4>Access a doctor, if you want to</h4>
                        <p>If you’re still not feeling better or just because, a doctor is available. It’s your call.</p>
                    </figcaption>
                 </div>
              </div>
              <div class="col-md-6">
                 <div class="perks-box">
                    <figure><img src="images/perks-icon-4.svg"></figure>
                    <figcaption>
                        <h4>Speedy delivery guaranteed</h4>
                        <p>Get relief to your doorstep in less than 3 hours - or it’s on the house!</p>
                    </figcaption>
                 </div>
              </div>
            </div>
          </div>
        </section>

        <section class="help-with-sec">
          <div class="container">
              <div class="row">
                 <div class="col-md-6">
                    <div class="alle-help" data-aos="fade-right" data-aos-duration="1600">
                       <img src="images/alle-help.svg">
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="help-with-text">
                      <h5>AlleviaMD can help with:</h5>
                      <ul>
                          <li>Cold & Allergy Symptoms</li>
                          <li>Back Pain</li>
                          <li>Headaches</li>
                          <li>Heartburn & Indigestion</li>
                          <li>Covid Testing</li>
                      </ul>
                    </div>
                 </div>
              </div>
          </div>
        </section>

        <section class="sign-up-sec">
            <div class="container">
              <div class="row">
                  <div class="col-md-6">
                      <div class="sign-in-head">
                          <h6>Sign up for updates when <br> <strong>AlleviaMD</strong> is available near you.</h6>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <form class="row blue-form">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <input type="Zipcode" class="form-control" id="exampleInputPassword1" placeholder="Zipcode">
                          </div>
                        </div>
                        <div class="col-sm-12">
                          <button type="submit" class="btn gb-white">Submit</button>
                        </div>
                      </form>
                  </div>
              </div>
            </div>
        </section>

      </div>   