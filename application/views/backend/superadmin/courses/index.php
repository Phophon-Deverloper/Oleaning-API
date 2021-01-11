<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
        <i class="mdi mdi-view-dashboard title_icon"></i> <?php echo get_phrase('courses'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/courses/create'); ?>', '<?php echo get_phrase('create_course'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_course'); ?></button>
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
                    <select name="category_id" id="category_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_a_catergory'); ?></option>
                        <?php
                        $categories = $this->db->get('category')->result_array();?>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
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
    var category_id = $('#category_id').val();
    if(category_id != ""){
        showAllSubjects();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_category'); ?>');
    }
}

var showAllSubjects = function () {
    var category_id = $('#category_id').val();
    if(category_id != ""){
        $.ajax({
            url: '<?php echo route('categories/list/') ?>'+category_id,
            success: function(response){
                $('.subject_content').html(response);
            }
        });
    }
}
</script>
