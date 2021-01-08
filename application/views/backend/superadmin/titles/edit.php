<?php $school_id = school_id(); ?>
<?php $subjects = $this->db->get_where('subjects', array('id' => $param1))->result_array(); ?>
<?php foreach ($subjects as $subject) { ?>
  <form method="POST" class="d-block ajaxForm" action="<?php echo route('subject/update/' . $param1); ?>">
    <div class="form-row">

      <div class="form-group col-md-12">
        <label for="name"><?php echo get_phrase('course_name'); ?></label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $subject['name']; ?>" required>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_subject_name'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="description"><?php echo get_phrase('course_description'); ?></label>
        <input type="text" class="form-control" id="description" description="description" required>
        <small id="description_help" class="form-text text-muted"><?php echo get_phrase('provide_course_description'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="image"><?php echo get_phrase('course_image_url'); ?></label>
        <input type="text" class="form-control" id="image" description="image" required>
        <small id="image_help" class="form-text text-muted"><?php echo get_phrase('provide_course_image_url'); ?></small>
      </div>
      <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_course'); ?></button>
      </div>
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