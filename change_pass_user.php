<?php
include 'header.php';
include 'includes/connection.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    $id = '';
}
?>
<div class="col-lg-4" style="padding-left:0px;padding-right:5px;">
    <div class="dash-unit">
        <dtitle style="color:#b2c831">Change Password</dtitle>
        <hr>
        <div style="padding:10px">
            <form method = "POST" action = "change_pass.php">
                <input type="password" id="basicinput" class = "form-control" name='old_password' class="span8" placeholder = "Old Password" required><br>
                <input type="password" id="password" name="password" class = "form-control password" placeholder="Password" required><br>
                <input type="password" name='confirm_password' id="confirm_password" class = "form-control confirm_password" onchange = "val_cpass()" placeholder="Confirm Password" required>
                <div  class = "alert alert-danger" id="cpass_msg" style = "display:none; width:100%; height:50px;text-align:center;">
                    <h6 style="color:red">Confirm Password not Match!</h6>
                </div>
                <br>
                <input type="submit" id = "submit" name = "submit" class="btn btn-md btn-primary" value='Change' onclick="return Validate()" style="width:100%">
                <input type='hidden' name='id' value="<?php echo $id; ?>">
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function val_cpass() {
        var password = $(".password").val();
        var confirm_password = $(".confirm_password").val();

        if(password != confirm_password) {
            $("#cpass_msg").show();
            $("#cpass_msg").html("Confirm password not match!");
            // $("#btn_save").hide();
        }
        else{
            $("#cpass_msg").hide();
            $("#btn_save").show();
        }
    }
    function Validate() {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;
        if (password != confirm_password) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
</script>