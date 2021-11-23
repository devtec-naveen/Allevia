<!-- <section class="content">
        <div class="container-fluid">                 
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               View Email and Text Template
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= SITE_URL.'providers/dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= SITE_URL.'providers/email-templates'  ?>">Email and Text Templates</a></li>
                                <li class="active">View</li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped results">
                              <tbody>
                                  <tr>
                                      <td>
                                          <strong>Name</strong>
                                      </td>
                                      <td>
                                          <?=$emailtemplates->name?>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <strong> Subject </strong>
                                      </td>
                                      <td>
                                          <?=$emailtemplates->subject?>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="2">
                                          <strong>Email Template Description</strong>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="2">
                                          <?php echo (strip_tags($emailtemplates->description, "<p>, <strong>, <br>,<ul>,<li>")); ?>
                                      </td>
                                  </tr>

                                   <tr>
                                      <td colspan="2">
                                          <strong>Text Message Description</strong>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="2">
                                          <?php echo (strip_tags($emailtemplates->text_message, "<p>, <strong>, <br>,<ul>,<li>")); ?>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section> -->



     <div class="inner-wraper">
     <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">View Email and Text Template</h4>            
          </div>
          <div class="card-body">           
             <div class="table-box mt-4 table-responsive dashbord-stricky-header">
                <table id="example" class="table table-striped table-hover">                  
                  <tbody>               
                   <tr>
                        <td>
                            <strong>Name</strong>
                        </td>
                        <td>
                            <?=$emailtemplates->name?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong> Subject </strong>
                        </td>
                        <td>
                            <?=$emailtemplates->subject?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>Email Template Description</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo (strip_tags($emailtemplates->description, "<p>, <strong>, <br>,<ul>,<li>")); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>Text Message Description</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo (strip_tags($emailtemplates->text_message, "<p>, <strong>, <br>,<ul>,<li>")); ?>
                        </td>
                    </tr>                    
                  </tbody>
                </table>
              </div>             
          </div>
         </div>
      </div>
     </div>
   </div>