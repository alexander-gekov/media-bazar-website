<?php

class Request
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    //methods
    public function updateStock($id)
    {

        $sql = "SELECT stock_id,restock_quantity FROM product_requests WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $request = $this->db->single();

        $sql = "UPDATE products SET quantity = quantity + :restockquantity WHERE id = :stockid";

        $this->db->query($sql);
        $this->db->bind(':restockquantity', $request->restock_quantity);
        $this->db->bind(':stockid', $request->stock_id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function completeRequest($id)
    {
        $sql = "UPDATE product_requests SET complete = 1 WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }



    public function getRequests()
    {
        $this->db->query('SELECT pr.id,
                                pr.stock_id,
                                pr.restock_quantity,
                                pr.complete,
                                p.name,
                                p.department
                          FROM product_requests AS pr
                          INNER JOIN products AS p
                          ON pr.stock_id = p.id
                          WHERE pr.complete = 0;');

        $results = $this->db->result();

        return $results;
    }

    public function getLowQuantityProducts()
    {
      $sql = "SELECT id, name, quantity,department FROM products WHERE quantity < 25;";
      $this->db->query($sql);
      $result = $this->db->result();
      return $result;
    }

    public function requestProduct($id, $quantity)
    {
      $data = strval(date("Y-m-d"));
      $sql = "INSERT INTO product_requests (stock_id, date_of_request, restock_quantity)
              VALUES (:id, :data, :quant);";
      $this->db->query($sql);
      $this->db->bind(':id', $id);
      $this->db->bind(':data', $data);
      $this->db->bind(':quant', $quantity);

      $this->db->execute();
    }

    public function checkRequestExistance($stock_id)
    {
      $sql = "SELECT stock_id FROM product_requests WHERE stock_id = :id;";
      $this->db->query($sql);
      $this->db->bind(':id', $stock_id);
      $row = $this->db->single();
      return $row;
      if($row == $stock_id){
        return true;
      }else{ return false;}
    }

    public function getDepartments()
    {

        $sql = 'SELECT * FROM departments';
        $this->db->query($sql);
        $result = $this->db->result();
        return $result;

    }
}
