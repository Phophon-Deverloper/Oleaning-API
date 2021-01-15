<?php
$school_id = school_id();
$courses = $this->db->get_where('course')->result_array();
if (count($courses) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('assign to'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($courses as $course): ?>
            <tr>
                <td><?php echo $course['course_name']; ?></td>
                <td>
                    <ul>
                        <?php
                        $assigned = $this->db->get_where('assign', array('course_id' => $course['course_id']))->result_array();
                        foreach($assigned as $assign){
                            $class = $this->db->get_where('classes', array('id' => $assign['class_id']))->result_array();
                            echo '<li>'.$class[0]['name'].'</li>';
                        }
                        ?>
                    </ul>
                </td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/course_assign/assign/'.$course['course_id'])?>', '<?php echo get_phrase('sctions'); ?>');"><?php echo get_phrase('assign'); ?></a>
                            
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
