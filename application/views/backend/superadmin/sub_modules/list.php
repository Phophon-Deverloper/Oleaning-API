<?php
if (isset($module_id)):
  $school_id  = school_id();
  $sub_modules = $this->db->get_where('submodule', array('module_id' => $module_id))->result_array();
  if (count($sub_modules) > 0):?>
  <table id="basic-datatable" class="table table-hover dt-responsive nowrap" width="100%">
    <thead>
      <tr style="background-color: #313a46; color: #ababab;">
        <th><?php echo get_phrase('name'); ?></th>
        <th><?php echo get_phrase('options'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($sub_modules as $sub_module){
        ?>
        <tr>
          <td onclick="location.href ='<?php echo base_url('superadmin/titles?module_id='.$sub_module['submodule_id'].'&submodule_id='.$sub_module['submodule_id']); ?>'"><?php echo $sub_module['submodule_name']; ?></td>
          <td>
            <div class="dropdown text-center">
    					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
    					<div class="dropdown-menu dropdown-menu-right">
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/sub_modules/edit/'.$sub_module['submodule_id'])?>', '<?php echo get_phrase('sub_module_detail'); ?>');"><?php echo get_phrase('detail'); ?></a>
    						<!-- item-->
    		
    					</div>
    				</div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
