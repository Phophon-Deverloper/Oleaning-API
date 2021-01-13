<?php $categories = $this->db->get_where('category', array('id' => $param1))->result_array(); ?>
<?php foreach($categories as $category){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('categories/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('category_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $category['category_name']; ?>" id="category_name" name = "category_name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_category_name'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_category'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllClassRooms);
});
</script>
