<?php
include "config.php";

$corn_varieties_id = $_POST['id'];

$delele_corn_varieties_query = " DELETE FROM tbl_corn_breeding_data WHERE id = $corn_varieties_id";

if ($conn->query($delele_corn_varieties_query) == true) {
    echo "success";
} else {
    echo "fail";
}
