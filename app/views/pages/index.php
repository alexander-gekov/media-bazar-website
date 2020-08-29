<?php
include APPROOT . 'views/inc/header.php';
include APPROOT . 'views/inc/nav.php'; ?>
<div class="text-center text-white p-2 mx-auto mt-20
          position-relative purple" style="min-width:330px; max-width:600px; display: flex;
  flex-direction: column;
  justify-content: center;
  text-align: center; ">
    <h1 class="display-4">Welcome, <?php echo $_SESSION['name']; ?></h1>
    <h4 style="color: #e5e5e5;"><?php echo $_SESSION['department']; ?></h4>
</div>
<a class="btn purple purple-hover text-center rounded-lg position:relative text-white mx-auto mb-3"
   style="margin-top: 200px; auto; max-width: 150px; text-align:center; display:flex; "
   href="mailto:georgivladov@mediabazar.nl">Contact Manager</a>
<?php include APPROOT . 'views/inc/footer.php'; ?>
