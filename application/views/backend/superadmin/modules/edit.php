<?php $school_id = school_id(); ?>
<?php $subjects = $this->db->get_where('module', array('module_id' => $param1))->result_array(); ?>
<?php foreach ($subjects as $subject) { ?>
  <form method="POST" class="d-block ajaxForm" action="<?php echo route('module/update/' . $param1); ?>">
    <div class="form-row">

      <div class="form-group col-md-12">
        <label for="class"><?php echo get_phrase('course'); ?></label>
        <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" disabled>
          <option value=""><?php echo get_phrase('select_a_course'); ?></option>
          <?php
          $courses = $this->db->get('course')->result_array();
          foreach ($courses as $course) {
          ?>
            <option value="<?php echo $course['course_id']; ?>" <?php if ($course['course_id'] == $subject['course_id']) {
                                                          echo 'selected';
                                                        } ?>><?php echo $course['course_name']; ?></option>
          <?php } ?>
        </select>
      </div>                                        

      <div class="form-group col-md-12">
        <label for="name"><?php echo get_phrase('module_name'); ?></label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $subject['module_name']; ?>" disabled>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_module_name'); ?></small>
      </div>


      <!-- <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_module'); ?></button>
      </div> -->
    </div>
  </form>
<?php } ?>

<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllSubjects);
  });

  $(document).ready(function() {
    initSelect2(['#class_id_on_create']);
  });
</script>