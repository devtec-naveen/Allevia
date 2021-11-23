<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               View Clinic
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                                <li class="active">View</li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped results">
                              <tbody>
             
                                    <tr>
                                      <td><strong>Clinic Name</strong> </td>
                                      <td><?= $organizations->organization_name ?></td>
                                    </tr>

                                    <tr>
                                      <td><strong>Clinic Slug</strong> </td>
                                      <td><?= $organizations->org_url ?></td>
                                    </tr>

                                     <tr>
                                      <td><strong>Access Code</strong> </td>
                                      <td><?= $organizations->access_code ?></td>
                                     
                                    </tr>
                                    <tr>
                                      <td><strong>Specializations</strong> </td>
                                      <td><?= $organizations->specialization_ids ?></td>
                                     
                                    </tr>

                                     <tr>
                                      <td><strong>Location</strong> </td>
                                      <td>
                                        <?php if(!empty($organizations['locations'])){

                                          foreach($organizations['locations'] as $key => $value)
                                          {                                              
                                             $location[] = $value['location'];
                                          }
                                          echo implode( ', ', $location );
                                          ?>                                        
                                          <?php }?>
                                        </td>
                                     
                                    </tr>
                                    <tr>
                                      <td><strong>Api Key</strong> </td>
                                      <td><?= $organizations->api_key ?></td>
                                     
                                    </tr>
                                    <tr>
                                      <td><strong>Api Secret</strong> </td>
                                      <td><?= $organizations->api_secret ?></td>
                                     
                                    </tr>
                                    <tr>
                                      <td><strong>Api System Id</strong> </td>
                                      <td><?= $organizations->api_system_id ?></td>
                                     
                                    </tr>

                                    <tr>
                                      <td><strong>Logo</strong></td>
                                      <td>
                    <?php 
                    if(!empty($organizations->clinic_logo)) {
                    ?>                    
                                  <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$organizations->clinic_logo; ?>">
                    <?php } ?>                                        
                                      </td>
                                    </tr>

                                    <tr>
                                      <td><strong>Created</strong> </td>
                                      <td><?=   h($organizations->created) ?></td>
                                     
                                    </tr>                                 
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>