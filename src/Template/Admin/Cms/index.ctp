<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CMS
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">CMS</li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">

                        
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                             <th>Sr. No.</th>
                                             <th>Page Title</th>
                                             <th>Content</th>
                                             <th>created</th>
                                             <th>modified</th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php $i = 1;

                                        foreach ($Cms as $cmspage): ?>
                                        <tr>
                                          <td><?= $this->Number->format($i) ?></td>
                                          <td><?= h($cmspage->title) ?></td>
                                          <td><?php echo  h(strip_tags(strlen($cmspage->bottom_content) > 100 ? substr($cmspage->bottom_content,0,100)."..." : $cmspage->bottom_content)); ?></td>
                                          <td><?= h($cmspage->created) ?></td>
                                          <td><?= h($cmspage->modified) ?></td>
                                        <td class="actions">
                                          <?= $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'view', $cmspage->id],['escape' => false,'class' => 'badge bg-blue','style' => 'margin:1px;']) ?>
                                          <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'edit', $cmspage->id],['escape' => false,'class' => 'badge bg-blue','style' => 'margin:1px;']) ?>
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
      <?= $this->Html->link($this->Html->tag('i','add',array('class'=>'material-icons')), ['action' => 'add'],['escape' => false,'class' => 'btn btn-primary btn-circle-lg waves-effect waves-circle waves-float sticky-btn-add', 'title' => 'Add Clinic']) ?>
            
        </div>
    </section>