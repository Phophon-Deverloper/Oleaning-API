<?php
if (isset($category_id)) :
  $check_data = $this->db->get_where('course', array('category_id' => $category_id))->result_array();
  if (count($check_data) > 0) : ?>
    <table id="basic-datatable" class="table table-hover dt-responsive nowrap" width="100%">
      <thead>
        <tr style="background-color: #313a46; color: #ababab;">
          <th><?php echo get_phrase('name'); ?></th>
          <th><?php echo get_phrase('options'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php

        $courses = $this->db->get_where('course', array('category_id' => $category_id))->result_array();
        foreach ($courses as $course) {
        ?>
          <tr>
          <td onclick="location.href ='<?php echo base_url('superadmin/modules?course_id='.$course['course_id']); ?>'"><?php echo $course['course_name']; ?></td>
            <td>

              <div class="dropdown text-center">
                <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                  <!-- item-->
                  <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/courses/edit/' . $course['course_id']) ?>', '<?php echo get_phrase('update_course'); ?>');"><?php echo get_phrase('edit'); ?></a>
                  <!-- item-->
                  <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('courses/delete/' . $course['course_id']); ?>', showAllSubjects)"><?php echo get_phrase('delete'); ?></a>
                </div>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php else : ?>
    <?php include APPPATH . 'views/backend/empty.php'; ?>
  <?php endif; ?>
<?php else : ?>
  <?php include APPPATH . 'views/backend/empty.php'; ?>
<?php endif; ?>