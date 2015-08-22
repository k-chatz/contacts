<?php
function resultToArray($result){
    $records = array( array() );
    $i = 0;

    while ($row = $result->fetch_assoc()){
        $r = 0;
        while ($r++ < count($row)){
            $value = current($row);
            $key = key($row);
            $records[$i][$key] = $value;
            next($row);
        }
        $i++;
    }
    return $records;
}

function Query($sql, $debug, $db_name = "contacts"){
    /*Show or hide queries*/
    (isset( $_SESSION['debug'] ) && $_SESSION['debug'] == "on") ? $print = 1 : $print = 0;

    /*Database connect*/
    include('connection.php');

    $records = NULL;

    /*Start timer*/
    $msc = microtime(true);

    if ($result = $mysqli->query($sql)){
        /*Successful Query execution*/

        /*Stop timer*/
        $msc = number_format( microtime(true) - $msc , 3);

        /*increasing number of queries*/
        isset($_SESSION['Queries']) ? $_SESSION['Queries']++ : $_SESSION['Queries'] = 1;

        if ($result !== true){
            /*For SELECT queries*/
           
           //dump($result,"result");

           /*If exists records then fetch this.*/
            if($result->num_rows){
                $records = resultToArray($result);
            }
            if($print) 
                show_query(1, $debug, $mysqli->host_info, $db_name, $sql, $result->num_rows ? $result->num_rows : 0, $msc, $result->num_rows ? $records : NULL);
        }
        else{ 
             /*For INSERT, UPDATE, DELETE queries*/

            $records = $mysqli->insert_id;

            /*Show SELECT query debugging*/
            if($print)
                show_query(2, $debug, $mysqli->host_info, $db_name, $sql, $mysqli->insert_id, $msc, $records);
        }
    }
    else{
        /*Query execution failed!*/
        $msc = number_format( microtime(true) - $msc , 2);

        /*Show query debugging*/
        show_query(3, $debug, $mysqli->host_info, $db_name, $sql, 0, $msc, $mysqli->error);
    }
        /*Close database connection*/
        $mysqli->close();

        /*Return records in tabular or nothing if it fails.*/
        return  $records;
}

include_once('select/select.php');
include_once('select/sel_user.php');
include_once('select/sel_phones.php');
include_once('select/sel_persons.php');
include_once('select/sel_addresses.php');

include_once('insert/insert.php');
include_once('insert/ins_user.php');
include_once('insert/ins_phone.php');
include_once('insert/ins_person.php');
include_once('insert/ins_addresses.php');

include_once('update/update.php');
include_once('update/upt_user.php');