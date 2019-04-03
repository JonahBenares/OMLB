
<script src = "js/jquery.min.js" type="text/javascript"></script>
<a href="javascript:void(0)" data-toggle="modal" data-target="#searchModal" class="btn btn-warning btn-md btn-fill">Search Vendor</a>

<!-- Modal -->
<div id="searchModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
     <div class="modal-content" style='padding:10px'>
      <div class="modal-header">
       <h3 class="modal-title">Search Vendor
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></h3>
        
      </div>
   
       <div class='vendorinfo'>
       
       <div id="errorBox" ></div>
       <form method="post">
        <table class='table'>
          <tr>
            <td>Vendor Name:</td>
            <td><input type="text" name="vendorname" id='vendorname' class="form-control custom-input" autocomplete="off"><span id="suggestion-vendor"></span></td>
          </tr>
          <tr>
            <td>Product/Service:</td>
            <td><input type="text" name="category_name" id='category_name' class="form-control custom-input" autocomplete="off" ><span id="suggestion-category"></span></td>
          </tr>
          <tr>
            <td>Other Information:</td>
            <td><input type="text" name="other" class="form-control custom-input" ></td>
          </tr>
          <tr>
          <td colspan='2'><center><input type='submit' name='searchvendor' value='Search'></center></td>
          </tr>
        </table>
       </form>
       </div>
    </div>
  </div>
</div>