<?php
if (isset($submodule_id)):
  $school_id  = school_id();
  $titles = $this->db->get_where('title', array('submodule_id' => $submodule_id))->result_array();
  if (count($titles) > 0):?>
  <table id="basic-datatable" class="table table-hover dt-responsive nowrap" width="100%">
    <thead>
      <tr style="background-color: #313a46; color: #ababab;">
        <th><?php echo get_phrase('name'); ?></th>
        <th><?php echo get_phrase('options'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($titles as $title){
        ?>
        <tr>
          <td onclick="rightModal('<?php echo site_url('modal/popup/titles/edit/'.$title['title_id'])?>', '<?php echo get_phrase('title_detail'); ?>');"><?php echo $title['title_description']; ?></td>
          <td>
            <div class="dropdown text-center">
    					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
    					<div class="dropdown-menu dropdown-menu-right">
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/titles/edit/'.$title['title_id'])?>', '<?php echo get_phrase('title_detail'); ?>');"><?php echo get_phrase('detail'); ?></a>    		
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
