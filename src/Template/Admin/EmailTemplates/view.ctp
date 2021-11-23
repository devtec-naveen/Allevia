<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               View Email Templates
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'email-templates'  ?>">Email Templates</a></li>
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
                                          <strong> Template</strong>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="2">
                                          <?=$emailtemplates->description?>
                                      </td>
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