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

function getSqlErrors($errorlist){
    $i = 0;
    $errors = "";
    foreach($errorlist as $list){
        $i++;
        $errors .= "#". $i .") ERROR ". $list['errno'] ." (". $list['sqlstate'] ."): ". $list['error']."\n";
    }
    return $errors;
}

function Query($sql, $backtrace, $database = "contacts"){
    /*Show or hide queries*/
    (isset( $_SESSION['debug'] ) && $_SESSION['debug'] == "on") ? $debug = 1 : $debug = 0;

    /*Database connect*/
    include('connection.php');

    $response = NULL;

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
                $response = resultToArray($result);
            }

            /*Show SELECT query*/
            if($debug) 
                showQuery("FETCH", $backtrace, $mysqli->host_info, $database, $sql, $result->num_rows ? $result->num_rows : 0, $msc, $result->num_rows ? $response : NULL);
        }
        else{
             /*For INSERT, UPDATE, DELETE queries*/
            $response = $mysqli->insert_id;
            if($debug)
                showQuery("AFFECT", $backtrace, $mysqli->host_info, $database, $sql, $mysqli->insert_id, $msc, $response);
        }
    }
    else{
        /*Query execution failed!*/
        $msc = number_format( microtime(true) - $msc , 2);

        /*Show failure query*/
        showQuery("FAILURE", $backtrace, $mysqli->host_info, $database, $sql, 0, $msc, $mysqli->error);

        /*Return error message*/
        $response = getSqlErrors($mysqli->error_list);
    }

        /*Close database connection*/
        $mysqli->close();

        /*Return records in tabular or nothing if it fails.*/
        return $response;
}

function errorChecking($response){
/*Check if a query has returned error message*/
    if(!is_string($response)){
        return $response;
    }
    else
    {
        $_SESSION['error'] = "<b>db.php:</b><br />".$response;
        echo $_SESSION['error'] ."<br />";
        return NULL;
    }
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
