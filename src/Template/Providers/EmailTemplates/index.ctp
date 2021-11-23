<div class="inner-wraper">
     <div class="row">
      <div class="col-md-12">
          <?= $this->Flash->render() ?>
        <div class="card">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5"> Email and Text Templates</h4>                        
          </div>
          <div class="card-body">          
             <div class="table-box mt-4 table-responsive dashbord-stricky-header">
                <table id="example" class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Sr. No.</th>
                      <th>Name</th>
                      <th>Subject</th>
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
                                  <td class="actions">
                                     <div class="btn-groups dropdown">
                                      <a href="javascript:;" class="btn btn-round" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                      </a>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?php echo  $this->Html->link($this->Html->tag('i',' View', array('class'=>' fas fa-eye')), ['action' => 'view', base64_encode($emailtemplate->id)],['escape' => false,'class' => 'dropdown-item']) ?>
                                       <?= $this->Html->link($this->Html->tag('i',' Edit',array('class'=>' fas fa-edit')), ['action' => 'edit', base64_encode($emailtemplate->id)],['escape' => false,'class' => 'dropdown-item']) ?>
                                      </div>
                                    </div>
                                    
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
   </div>
<script type="text/javascript">
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        "searching": false,
        dom:"<'myfilter'f><'mylength'l>tt<'mylength'p>",        
        buttons: [ 'copy', 'excel', 'pdf' ],
        "sScrollY": "600",
        "bScrollCollapse": true
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>