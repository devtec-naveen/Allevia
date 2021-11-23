<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Email Templates
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Email Templates</li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">

                        
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                             <th>Sr. No.</th>
                                             <th>name</th>
                                             <th>subject</th>
                                             <th>created</th>
                                             <th>modified</th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                            foreach ($emailtemplates as $emailtemplate): ?>
                                                <tr>
                                                  <td><?= $this->Number->format($i) ?></td>
                                                  <td><?= h($emailtemplate->name) ?></td>
                                                  <td><?= h($emailtemplate->subject) ?></td>
                                                  <td><?= h($emailtemplate->created) ?></td>
                                                  <td><?= h($emailtemplate->modified) ?></td>
                                                  <td class="actions">
                                                    <?php //echo  $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'view', $emailtemplate->id],['escape' => false,'class' => 'badge bg-blue']) ?>
                                                    <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'edit', $emailtemplate->id],['escape' => false,'class' => 'badge bg-blue']) ?>
                                                  </td>
                                                </tr>
                                      <?php  $i++; endforeach; ?>
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