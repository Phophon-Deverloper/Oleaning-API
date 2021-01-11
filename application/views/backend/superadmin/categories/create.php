<form method="POST" class="d-block ajaxForm" action="<?php echo route('categories/create'); ?>">
    <div class="form-row">
        <!-- <input type="hidden" name="school_id" value="<?php echo school_id(); ?>"> -->
        <div class="form-group col-md-12">
            <label for="category_name"><?php echo get_phrase('category_name'); ?></label>
            <input type="text" class="form-control" id="category_name" name = "category_name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_category_name'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_category'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllClassRooms);
});
</script>
