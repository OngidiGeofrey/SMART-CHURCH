<?php
include 'inc/globals.php';

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `events` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>

<style>
	img#cimg{
		height: 20vh;
		width: 15vw;
		object-fit: cover;
		object-position: center top;
	}
</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Event</h3>
	</div>
	<div class="card-body">
		<form action="" id="event-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
				<label for="schedule" class="control-label">Deposit Date</label>
                <input type="date" class="form-control form" required name="deposit_date" value="<?php echo isset($schedule) ? $schedule : '' ?>">
            </div>
			<div class="form-group">
    <label for="title" class="control-label">Member</label>
    <select class="form-control form" required name="member_id">
        <?php
        // Fetch members from the users table and dynamically generate options
        $user_query = $conn->query("SELECT * FROM users");
        if ($user_query->num_rows > 0) {
            while ($row = $user_query->fetch_assoc()) {
                $selected = isset($member) && $member == $row['id'] ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>{$row['firstname']} {$row['lastname']}</option>";
            }
        }
        ?>
    </select>
	</div>
	<div class="form-group">
   

			<div class="form-group">
				<label for="description" class="control-label">Amount (KES)</label>
				<input type="text" class="form-control form" required name="amount" value="<?php echo isset($amount) ? $amount : '' ?>">

            </div>
			<div class="form-group">
    <label for="title" class="control-label">Deposit For</label>
	<select class="form-control form" required name="type">
    <?php
    // Iterate through the deposit types array and generate options
    foreach ($deposit_types as $key => $type) {
        $selected = isset($deposit_type) && $deposit_type == $key ? 'selected' : '';
        echo "<option value='{$key}' $selected>{$type}</option>";
    }
    ?>
</select>
	</div>
			<div class="form-group">
				<label for="description" class="control-label">Description</label>
                <textarea rows="2" class="form-control form" required name="description"><?php echo isset($description) ? stripslashes($description) : '' ?></textarea>
            </div>
		
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="event-form">Record Deposit</button>
		<a class="btn btn-flat btn-default" href="?page=events">Cancel</a>
	</div>
</div>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(document).ready(function(){
		function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Function to remove thousand separators
    function removeSeparator(number) {
        return number.replace(/,/g, '');
    }

    // Listen for input on the amount field
    $('input[name="amount"]').on('input', function() {
        // Remove any existing separators
        var amount = removeSeparator($(this).val());
        // Format the number with thousand separators
        $(this).val(formatNumber(amount));
    });
	$('#event-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=record_deposit",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=deposits";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
	})
</script>