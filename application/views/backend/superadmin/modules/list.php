<?php
if (isset($course_id)):
  $school_id  = school_id();
  $modules = $this->db->get_where('module', array('course_id' => $course_id))->result_array();
  if (count($modules) > 0):?>
  <table id="basic-datatable" class="table table-hover dt-responsive nowrap" width="100%">
    <thead>
      <tr style="background-color: #313a46; color: #ababab;">
        <th ><?php echo get_phrase('name'); ?></th>
        <th><?php echo get_phrase('options'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($modules as $subject){
        ?>
        <tr>
          <td onclick="location.href ='<?php echo base_url('superadmin/sub_modules?course_id='.$subject['course_id'].'&module_id='.$subject['module_id']); ?>'"><?php echo $subject['module_name']; ?></td>
          <td>
            <div class="dropdown text-center">
    					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
    					<div class="dropdown-menu dropdown-menu-right">
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/modules/edit/'.$subject['module_id'])?>', '<?php echo get_phrase('update_module'); ?>');"><?php echo get_phrase('detail'); ?></a>
    						<!-- item-->
    						<!-- <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('subject/delete/'.$subject['id']); ?>', showAllSubjects)"><?php echo get_phrase('delete'); ?></a> -->
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
