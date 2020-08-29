<?php
$selected_department = NULL;
include APPROOT . 'views/inc/header.php';
include APPROOT . 'views/inc/nav.php'; ?>
<!--<section style="height: 30px" class="purple mb-3">-->
<h3 class="pl-5 pt-4 text-white justify-center">Requests</h3>
<!--</section>-->

<container>
    <div class="container mb-3">
      <div>
        <form method="post">
          <select name="department" id="departmentSelector" class="form-control form-control-sm mr-2 ml-auto" style="width:20%">
            <?php foreach ($data['departments'] as $department) : ?>
              <option value=<?php echo $department->id ?>><?php echo $department->name ?></option>
            <?php endforeach; ?>
          </select>
          <input type="submit" class="btn btn-primary float-right" name="submit" value="Sort">
        </form>
<?php
if(isset($_POST['submit']))
  $selected_department = $_POST['department'];
?>
      </div>
      <div class="row border border-gray p-3 d-inline mx-auto mt-5
        bg-light rounded-lg shadow-lg lead"> Pending requests
      </div>

        <div class="row border border-gray p-3 mx-auto mt-4
          bg-white rounded-lg shadow-lg lead">
            <div class="col-md-2 border-right">
                <strong>Image:</strong>
            </div>
            <div class="col-md-2 border-right">
                <strong>Product Id:</strong>
            </div>
            <div class="col border-right">
                <strong>Product Name:</strong>
            </div>
            <div class="col-md-1 border-right text-center">
                <strong>Quantity:</strong>
            </div>
            <div class="col-md-2 text-center">
                <strong>Done:</strong>
            </div>
        </div>
        <?php foreach ($data['requests'] as $request) : ?>
<?php if($request->department == $selected_department || !isset($selected_department) || $selected_department == 10) : ?>
        <div class="row border border-gray p-2 mx-auto mt-4
          bg-white rounded-lg shadow-lg lead">
            <div class="col-md-2 border-right">
                <img src="https://www.technopolis.bg/medias/sys_master/h66/hbf/12054810853406.jpg" alt=""
                     width="100px">
            </div>
            <div class="col-md-2 border-right text-center d-flex align-items-center">
              <?php echo $request->stock_id ?>
            </div>
            <div class="col border-right text-center d-flex align-items-center">
                <?php echo $request->name ?>
            </div>
            <div class="col-md-1 border-right text-center d-flex align-items-center">
                <?php echo $request->restock_quantity ?>
            </div>
            <div class="col-md-2 d-flex align-items-center justify-content-center">
                <a href="<?php echo URLROOT; ?>/requests/markComplete/<?php echo $request->id ?>" class="btn purple purple-hover text-white" id="RequestDoneButton">Received</a>
            </div>
        </div>
      <?php endif; ?>
      <?php endforeach; ?>
      <div class="row border border-gray p-3 mx-auto mt-4 d-table text-left
        bg-light rounded-lg shadow-lg lead"> Products with low quantity
      </div>
      <?php foreach ($data['lowQuantityProducts'] as $product) : ?>
        <?php if($product->department == $selected_department || !isset($selected_department) || $selected_department == 10) : ?>
      <div class="row border border-gray p-2 mx-auto mt-4
        bg-white rounded-lg shadow-lg lead">
          <div class="col-md-2 border-right">
              <img src="https://www.technopolis.bg/medias/sys_master/h66/hbf/12054810853406.jpg" alt=""
                   width="100px">
          </div>
          <div class="col-md-2 border-right text-center d-flex align-items-center">
            <?php echo $product->id ?>
          </div>
          <div class="col border-right text-center d-flex align-items-center">
              <?php echo $product->name ?>
          </div>
          <div class="col-md-1 border-right text-center d-flex align-items-center">
              <?php echo $product->quantity ?>
          </div>
          <div class="col-md-2 d-flex align-items-center justify-content-center">
              <button type="button" class="btn purple purple-hover text-white" data-toggle="modal"
              data-target="#requestModal" data-id="<?php echo $product->id; ?>" data-btn="<?php echo $product->name; ?>">Request</button>
          </div>
      </div>
            <?php endif; ?>
    <?php endforeach; ?>
    </div>
    <!-- Modal -->
<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Request a product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body lead">
        <form class="req" method="post" action="<?php echo URLROOT; ?>/requests/requestProduct/">
          <div class="form-group">
            <h3 class="head" id="productNameRequest"></h3>
          </div>
          <div class="form-group">
            <label for="quantitypr" class="col-form-label">Request quantity:</label>
            <input class="form-control" id="quantitypr" name="quantitypr"></input>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="sendRequestBtn">Send Request</button>
      </div>
      </form>
    </div>
  </div>
</div>
</container>

<?php include APPROOT . 'views/inc/footer.php'; ?>
