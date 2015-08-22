<?php
function Query($sql, $debug, $db_name = "contacts"){
    if( isset( $_SESSION['admin'] ) && $_SESSION['admin'] == "xxx")
            $print = 1;
    else
            $print = 0;
    $msc   = microtime(true);

    include('connection.php');
    //dump( $mysqli ,"mysqli");

    if ($result = $mysqli->query($sql)) {
            isset($_SESSION['Queries']) ? $_SESSION['Queries']++ : $_SESSION['Queries'] = 1;
            usleep(10000);
            $msc = microtime(true) - $msc;
            $msc = number_format($msc, 3);

            /*At this point and down must be different function.*/

            if ($result !== true) //SELECT
                    {
                    if ($result->num_rows) {
                            //$Array = mysqli_fetch_all($result,MYSQLI_ASSOC); //PHP/5.5.11 ONLY
                            $Array = array(
                                    array()
                            );
                            $i     = 0;
                            while ($row = $result->fetch_assoc()) {
                                    $r = 0;
                                    while ($r++ < count($row)) {
                                            $value           = current($row);
                                            $key             = key($row);
                                            $Array[$i][$key] = $value;
                                            next($row);
                                    }
                                    $i++;
                            }
                            if($print) show_query(1, $debug, $mysqli->host_info, $db_name, $sql, $result->num_rows, $msc, $Array);
                            $result->close();
                    } else {
                            if($print) show_query(1, $debug, $mysqli->host_info, $db_name, $sql, 0, $msc, NULL);
                            $result->close();
                            return NULL;
                    }
            } else //INSERT, UPDATE , DELETE 
                    {
                    $Array = $mysqli->insert_id;
                    if($print) show_query(2, $debug, $mysqli->host_info, $db_name, $sql, $mysqli->insert_id, $msc, $Array);
            }

            $mysqli->close();
            return $Array;
    } else {
            $msc = microtime(true) - $msc;
            $msc = number_format($msc, 2);

            show_query(3, $debug, $mysqli->host_info, $db_name, $sql, 0, $msc, $mysqli->error);
            $mysqli->close();

            return NULL;
    }
}

include('sql_select.php');
include('sql_insert.php');
include('sql_update.php');