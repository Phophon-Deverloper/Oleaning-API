

<?php $school_id = school_id(); ?>
<?php $subjects = $this->db->get_where('course', array('course_id' => $param1))->result_array(); ?>
<?php foreach($subjects as $subject){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('courses/update/'.$param1); ?>">
    <div class="form-row">
    <div class="form-group col-md-12">
        <label for="category"><?php echo get_phrase('category'); ?></label>
        <select name="category_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required>
          <option value=""><?php echo get_phrase('select_a_category'); ?></option>
          <?php
          $categories = $this->db->get('category')->result_array();
          foreach ($categories as $category) {
          ?>
            <option value="<?php echo $category['category_id']; ?>" <?php if ($category['category_id'] == $course['category_id']) {
                                                                      echo 'selected';
                                                                    } ?>><?php echo $category['category_name']; ?></option>
          <?php } ?>
        </select>
        <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_category'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="name"><?php echo get_phrase('course_name'); ?></label>
        <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo $course['course_name']; ?>" required>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_course_name'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="course_description"><?php echo get_phrase('course_description'); ?></label>
        <input type="text" class="form-control" id="course_description" name="course_description" value="<?php echo $course['course_description']; ?>" required>
        <small id="description_help" class="form-text text-muted"><?php echo get_phrase('provide_course_description'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="course_image_url"><?php echo get_phrase('course_image_url'); ?></label>
        <input type="text" class="form-control" id="course_image_url" name="course_image_url" value="<?php echo $course['course_image_url']; ?>" required>
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
