<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
        <i class="mdi mdi-view-dashboard title_icon"></i> <?php echo get_phrase('title'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row mt-3">
                <div class="col-md-3"></div>
                <div class="col-md-4">
                    <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_a_sub_module'); ?></option>
                        <?php
                        $submodules = $this->db->get_where('submodule', array('module_id'=>$module_id))->result_array();?>
                        <?php foreach ($submodules as $submodule): ?>
                            <option value="<?php echo $submodule['submodule_id']; ?>" <?php if ($submodule['submodule_id'] == $submodule_id) {
                                                          echo 'selected';
                                                        } ?>><?php echo $submodule['submodule_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_class()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="card-body subject_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>


<script>
function filter_class(){
    var course_id = $('#class_id').val();
    if(course_id != ""){
        showAllSubjects();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_sub_module'); ?>');
    }
}

var showAllSubjects = function () {
    var course_id = $('#class_id').val();
    if(course_id != ""){
        $.ajax({
            url: '<?php echo route('titles/list/') ?>'+course_id,
            success: function(response){
                $('.subject_content').html(response);
            }
        });
    }
}
</script>
