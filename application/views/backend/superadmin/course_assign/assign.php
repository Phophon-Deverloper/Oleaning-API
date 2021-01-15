<form method="POST" class="d-block ajaxForm" action="<?php echo route('course_assign/manage/'.$param1); ?>">
<div class="form-row">
    <?php $count = 0; ?>
    <?php $classes = $this->db->get_where('classes')->result_array(); ?>
    <?php foreach ($classes as $class) {
        $assigned = $this->db->get_where('assign', array('course_id' => $param1, 'class_id'=> $class['id']))->result_array();?>
                       <div class="form-group col-md-12">
                            <div class="form-check col-10">
                                <input class="form-check-input" type="checkbox"  name="class_assign_id[]" value="<?php echo $class['id']; ?>" id="defaultCheck<?php echo $count?>" <?php if ($assigned){ echo 'checked';} ?>>
                                <label class="form-check-label" for="defaultCheck<?php echo $count?>">
                                    <?php echo $class['name'] ?>
                                </label>
                            </div>
                        </div>
        
            
   <?php $count++; } ?>
    <div id="section_area"></div>
    <div class="row no-gutters">
        <div class="form-group  col-md-12 p-0 mt-2">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
        </div>
        </div>
    </div>
</form>


<script>
    //update form
    // Jquery form validation initialization
    $(".ajaxForm").validate({});
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllClasses);
    });



    // function appendSection() {
    //     $('#section_area').append(blank_section_field);
    // }

    // function removeSection(elem) {
    //     $(elem).closest('.form-row').remove();
    // }

    // function removeSectionDatabase(section_id) {
    //     $('#sectionDatabase' + section_id).hide();
    //     $('#section' + section_id).val(section_id + 'delete');
    // }
</script>