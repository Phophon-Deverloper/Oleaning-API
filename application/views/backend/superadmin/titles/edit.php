<?php $school_id = school_id(); ?>
<?php $subjects = $this->db->get_where('subjects', array('id' => $param1))->result_array(); ?>
<?php foreach ($subjects as $subject) { ?>
  <form method="POST" class="d-block ajaxForm" action="<?php echo route('subject/update/' . $param1); ?>">
    <div class="form-row">

      <div class="form-group col-md-12">
        <label for="class"><?php echo get_phrase('sub_module'); ?></label>
        <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required>
          <option value=""><?php echo get_phrase('select_a_sub_module'); ?></option>
          <?php
          $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
          foreach ($classes as $class) {
          ?>
            <option value="<?php echo $class['id']; ?>" <?php if ($class['id'] == $subject['class_id']) {
                                                          echo 'selected';
                                                        } ?>><?php echo $class['name']; ?></option>
          <?php } ?>
        </select>
        <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_class'); ?></small>
      </div>


      <div class="form-group col-md-12">
        <label for="name"><?php echo get_phrase('title_name'); ?></label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $subject['name']; ?>" required>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_title_name'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="type"><?php echo get_phrase('title_type'); ?></label>
        <input type="text" class="form-control" id="type" name="type" value="<?php echo $subject['type']; ?>" required>
        <small id="type_help" class="form-text text-muted"><?php echo get_phrase('provide_title_type'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="description"><?php echo get_phrase('title_description'); ?></label>
        <input type="text" class="form-control" id="description" name="description" value="<?php echo $subject['description']; ?>" required>
        <small id="description_help" class="form-text text-muted"><?php echo get_phrase('provide_title_description'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="description"><?php echo get_phrase('choices'); ?></label>
        <input type="text" class="form-control" id="description" name="description" value="<?php echo $subject['description']; ?>" required>
        <small id="description_help" class="form-text text-muted"><?php echo get_phrase('provide_title_description'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="description"><?php echo get_phrase('answer_index'); ?></label>
        <input type="text" class="form-control" id="description" name="description" value="<?php echo $subject['description']; ?>" required>
        <small id="description_help" class="form-text text-muted"><?php echo get_phrase('provide_title_description'); ?></small>
      </div>



      <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_module'); ?></button>
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