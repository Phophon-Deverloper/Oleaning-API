<form method="POST" class="d-block ajaxForm" action="<?php echo route('courses/create_excel'); ?>">
  <div class="form-row">

    <!-- <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
    <input type="hidden" name="session" value="<?php echo active_session(); ?>"> -->

    <div class="form-group col-md-12">
      <label for="category_id_on_create"><?php echo get_phrase('category'); ?></label>
      <select name="category_id" id="category_id_on_create" class="form-control select2" data-toggle="select2" required>
        <option value=""><?php echo get_phrase('select_a_category'); ?></option>
        <?php
        $categories = $this->db->get('category')->result_array();
        foreach($categories as $category){
          ?>
          <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
        <?php } ?>
      </select>
      <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_category'); ?></small>
    </div>

    <div class="form-group col-md-12">
      <label for="name"><?php echo get_phrase('course_name'); ?></label>
      <input type="text" class="form-control" id="course_name" name="course_name" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_course_name'); ?></small>
    </div>

    <div class="form-group col-md-12">
      <label for="description"><?php echo get_phrase('course_description'); ?></label>
      <input type="text" class="form-control" id="description" name="course_description" required>
      <small id="description_help" class="form-text text-muted"><?php echo get_phrase('provide_course_description'); ?></small>
    </div>

    <div class="form-group col-md-12">
      <label for="image"><?php echo get_phrase('course_image'); ?></label>
      <input type="text" class="form-control" id="image" name="course_image" required>
      <small id="image_help" class="form-text text-muted"><?php echo get_phrase('provide_course_image_url'); ?></small>
    </div>


    <div class="form-group col-md-12">
    <label><?php echo get_phrase('upload_csv'); ?></label>
      <div class="row">
        <div class="col-12">
          <a href="<?php echo base_url('assets/csv_file/course.generate.csv'); ?>" class="btn btn-success btn-sm mb-1" download><?php echo get_phrase('generate_csv_file'); ?><i class="mdi mdi-download"></i></a>
          <!-- <button href="#" class="btn btn-dark btn-sm mb-1 mdi mdi-eye-outline" onclick="largeModal('<?php echo site_url('modal/popup/student/csv_preview'); ?>', 'CSV Format');" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('preview_csv_format'); ?>"></button> -->

        </div>
      </div>
      <br>
      <div class="form-group">
        
        <div class="custom-file-upload">
          <input type="file" id="csv_file" class="form-control" name="csv_file" required>
        </div>
      </div>
    </div>

    <div class="form-group  col-md-12">
      <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_course'); ?></button>
    </div>
  </div>
</form>

<script>
  $(document).ready(function() {
    initSelect2(['#class_id_on_create']);
    initCustomFileUploader();
  });
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllSubjects);
  });
</script>