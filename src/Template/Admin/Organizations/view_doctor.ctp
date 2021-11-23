<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               View Doctor
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations/doctors'  ?>">Doctors</a></li>
                                <li class="active">View</li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped results">
                              <tbody>
           
                                  
                                     <tr>
                                      <td><strong>Doctor Name</strong> </td>
                                      <td><?= $doctor->doctor_name ?></td>
                                     
                                    </tr>
                                    <tr>
                                      <td><strong>Doctor Credential</strong> </td>
                                      <td><?= $doctor->credentials ?></td>
                                     
                                    </tr>
                                     <tr>
                                      <td><strong>Clinic</strong> </td>
                                      <td><?= $doctor->organization->organization_name ?></td>
                                     
                                    </tr>                                    
                                     <tr>
                                      <td><strong>Specialization</strong> </td>
                                      <td><?= $doctor->specialization_id ?></td>
                                     
                                    </tr>

                                    <tr>
                                      <td><strong>Visit Reason</strong> </td>
                                      <td><?php  echo !empty($temp_doctor_visit_reasons) ? implode(', ', $temp_doctor_visit_reasons->toarray()):'N/A'; ?></td>
                                     
                                    </tr>

                                     <tr>
                                      <td><strong>E-mail</strong> </td>
                                      <td><?= $doctor->email ?></td>
                                     
                                    </tr>

                                       <tr>
                                      <td><strong>Location</strong> </td>
                                      <td>
                                        <?php if(!empty($doctor['user_locations'])){

                                          foreach($doctor['user_locations'] as $key => $value)
                                          {                                              
                                             $location[] = $value['location']['location'];
                                          }
                                          if(!empty(array_filter($location)))
                                          {  
                                          echo implode(', ', $location);
                                          }
                                          ?>                                        
                                          <?php }?>
                                        </td>
                                     
                                    </tr>




                                     <tr>
                                      <td><strong>Created</strong> </td>
                                      <td><?= $doctor->created ?></td>
                                     
                                    </tr> 
          <!--                           <tr>
                                      <td><strong>Modified</strong> </td>
                                      <td><?php echo  $doctor->modified ?></td>
                                     
                                    </tr>  -->                                    

                                 
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