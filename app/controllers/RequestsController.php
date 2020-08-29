<?php

class RequestsController extends Controller
{

    public function __construct()
    {
        $this->requestModel = $this->model('Request');
    }

    public function index()
    {
        $requests = $this->requestModel->getRequests();
        $lowQuantityProducts = $this->requestModel->getLowQuantityProducts();
        $departments = $this->requestModel->getDepartments();
        $data = [
            'requests' => $requests,
            'lowQuantityProducts' => $lowQuantityProducts,
            'departments' => $departments
        ];


        $this->view('requests/index', $data);
    }

    public function markComplete($id)
    {
      $this->requestModel->completeRequest($id);
      $this->requestModel->updateStock($id);
        redirect('requests/index');
    }

    public function updateStock($stockid, $restockquantity)
    {
      $this->requestModel->updateStock($stockid, $restockquantity);
    }

    public function requestProduct($id)
    {
      if(isset($_POST['quantitypr'])){
      $quantity = $_POST['quantitypr'];
      if(!($this->requestModel->checkRequestExistance($id))){
      $this->requestModel->requestProduct($id, $quantity);
      }
      redirect('requests');
      }
    }


}
