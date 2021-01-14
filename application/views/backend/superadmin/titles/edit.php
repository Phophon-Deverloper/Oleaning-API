<?php $school_id = school_id(); ?>
<?php $titles = $this->db->get_where('title', array('title_id' => $param1))->result_array(); ?>
<?php foreach ($titles as $title) { ?>
  <form method="POST" class="d-block ajaxForm" action="">
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="class"><?php echo get_phrase('sub_module'); ?></label>
        <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required>
          <option value=""><?php echo get_phrase('select_a_sub_module'); ?></option>
          <?php
          $submodules = $this->db->get_where('submodule', array('submodule_id' => $title['submodule_id']))->result_array();
          foreach ($submodules as $submodule) {
          ?>
            <option value="<?php echo $submodule['submodule_id']; ?>" <?php if ($submodule['submodule_id'] == $title['submodule_id']) {
                                                                        echo 'selected';
                                                                      } ?>><?php echo $submodule['submodule_name']; ?></option>
          <?php } ?>
        </select>
        <small id="class_help" class="form-text text-muted"><?php echo get_phrase('select_a_submodule'); ?></small>
      </div>


      <div class="form-group col-md-12">
        <label for="name"><?php echo get_phrase('title_name'); ?></label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $title['title_name']; ?>" required>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_title_name'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="type"><?php echo get_phrase('title_type'); ?></label>
        <input type="text" class="form-control" id="type" name="type" value="<?php echo $title['title_type']; ?>" required>
        <small id="type_help" class="form-text text-muted"><?php echo get_phrase('provide_title_type'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="description"><?php echo get_phrase('title_description'); ?></label>
        <textarea type="text" class="form-control" id="description" name="description" rows="5" required><?php echo $title['title_description']; ?></textarea>
        <small id="description_help" class="form-text text-muted"><?php echo get_phrase('provide_title_description'); ?></small>
      </div>

      <?php if ($title['title_type'] == 'QUIZ') { ?>

        <?php $quizchoice = $this->db->get_where('quizchoice', array('title_id' => $title['title_id']))->result_array(); ?>
        
        <div class="form-group col-md-12">
          <label for="description"><?php echo get_phrase('choices'); ?></label>
          <input type="text" class="form-control" id="description" name="description" value="<?php echo $quizchoice[0]['choice']; ?>" required>
          <small id="description_help" class="form-text text-muted"><?php echo get_phrase('provide_title_description'); ?></small>
        </div>

        <div class="form-group col-md-12">
          <label for="description"><?php echo get_phrase('answer_index'); ?></label>
          <input type="text" class="form-control" id="description" name="description" value="<?php echo $quizchoice[0]['answer']; ?>" required>
          <small id="description_help" class="form-text text-muted"><?php echo get_phrase('provide_title_description'); ?></small>
        </div>
      <?php } ?>
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