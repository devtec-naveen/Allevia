<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Forms Management 
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Forms Management </li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">

                        
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                             <th><?= $this->Paginator->sort('id') ?></th>
                                             <th><?= $this->Paginator->sort('name') ?></th>
                                             <th><?= $this->Paginator->sort('subject') ?></th>
                                             <th><?= $this->Paginator->sort('created') ?></th>
                                             <th><?= $this->Paginator->sort('modified') ?></th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php 
                                        $Cms = [];

                                        $i = 1;

                                        foreach ($Cms as $cmspage): ?>
                                        <tr>
                                          <td><?= $this->Number->format($i) ?></td>
                                          <td><?= h($cmspage->title) ?></td>
                                          <td><?php echo  h(strip_tags(strlen($cmspage->content) > 100 ? substr($cmspage->content,0,100)."..." : $cmspage->content)); ?></td>
                                          <td><?= h($cmspage->created) ?></td>
                                          <td><?= h($cmspage->modified) ?></td>
                                        <td class="actions">
                                          <?= $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'view', $cmspage->id],['escape' => false,'class' => 'badge bg-blue']) ?>
                                          <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'edit', $cmspage->id],['escape' => false,'class' => 'badge bg-blue']) ?>
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