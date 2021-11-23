<footer>
          <div class="container">
            <div class="footer-main">
              <div class="row">
                <div class="col-md-4 footer-logo-box">
                  <a href="javascript:;" class="logo-footer">
                    <img src="<?php echo  WEBROOT."img/".$allsettings['footer_logo_image']; ?>">
                  </a>
                  <p><?= $allsettings['allevia_about_footer'] ?></p>
                </div>
                <div class="col-md-3">
                  <h4 class="footer-tit" >Company</h4>
                  <ul class="footer-link">
                    <li>
                      <a href="<?php echo SITE_URL ?>pages/cms/<?php echo $all_cms_page[1]->slug?>"><?php echo $all_cms_page[1]->menu_display_title?></a>
                    </li>
                    <li>
                      <a href="<?php echo SITE_URL ?>pages/cms/<?php echo $all_cms_page[3]->slug?>"><?php echo $all_cms_page[3]->menu_display_title?></a>
                    </li>
                  </ul>
                </div>
                <div class="col-md-3">
                  <h4 class="footer-tit" >Important links</h4>
                  <ul class="footer-link">
                    <li>
                      <a href="<?php echo SITE_URL ?>pages/cms/<?php echo $all_cms_page[2]->slug?>"><?php echo $all_cms_page[2]->menu_display_title?></a>
                    </li>
                    <li>
                      <a href="<?php echo SITE_URL ?>pages/cms/<?php echo $all_cms_page[0]->slug?>"><?php echo $all_cms_page[0]->menu_display_title?></a>
                    </li>
                    <li>
                      <a href="<?php echo SITE_URL ?>pages/cms/<?php echo $all_cms_page[8]->slug?>"><?php echo $all_cms_page[8]->menu_display_title?></a>
                    </li>
                    <li>
                      <a href="<?php echo SITE_URL ?>pages/cms/<?php echo $all_cms_page[9]->slug?>"><?php echo $all_cms_page[9]->menu_display_title?></a>
                    </li>
                    <li>
                      <a href="<?php echo SITE_URL ?>pages/cms/<?php echo $all_cms_page[10]->slug?>"><?php echo $all_cms_page[10]->menu_display_title?></a>
                    </li>
                     <li>
                      <a href="<?php echo SITE_URL ?>pages/cms/<?php echo $all_cms_page[11]->slug?>"><?php echo $all_cms_page[11]->menu_display_title?></a>
                    </li>
                  </ul>
                </div>
                <div class="col-md-2">
                  <h4 class="footer-tit" >Connect with us</h4>
                  <ul class="footer-social">
                    <li>
                      <a class="facebook-bg" href="<?= $allsettings['facebook'] ?>"><i class="ri-facebook-fill"></i></a>
                    </li>
                    <li>
                      <a class="linkedin-bg" href="<?= $allsettings['instagram'] ?>"><i class="ri-linkedin-fill"></i></a>
                    </li>
                    <li>
                      <a class="twitter-bg" href="<?= $allsettings['twitter'] ?>"><i class="ri-twitter-fill"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="copyright"><?php echo $allsettings['copyright_text']  ?></div>
      </footer>

