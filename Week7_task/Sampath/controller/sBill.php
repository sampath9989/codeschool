<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/controller/db.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/response.php";

class SBill
{

    function getSBillDetailsById($billId)
    {
        $query = "SELECT * FROM supplementary_bills WHERE id =?";
        $queryResponse = (new DBConnection())->selectSingle($query, [$billId]);
        return $queryResponse;
    }

    function getBillEmployees($billId){
        $query = "SELECT e.*, sbill.total_earnings, sbill.total_deductions FROM employee e, s_bill_emp_map as sbill
        WHERE sbill.emp_id = e.id
        AND sbill.s_bill_id = ?;";
        $queryResponse = (new DBConnection())->select($query, [$billId]);
        return $queryResponse;
    }

    function getBillAddings($billId){
        $query = "SELECT sbill.emp_id, a.* FROM s_bill_emp_map sbill, ( SELECT ba.*, a.name, a.type
        FROM bill_addings ba, adding_types a
        WHERE ba.adding_type_id = a.id
        AND ba.s_bill_id = ?) as a
        WHERE a.s_bill_emp_map_id = sbill.id;";
        $queryResponse = (new DBConnection())->select($query, [$billId]);
        return $queryResponse;
    }
}
