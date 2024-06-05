<?php
require_once('utils.php');
function get_history() {

    if (isset($_SERVER) && isset($_SERVER['REQUEST_METHOD'])) {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            try {
                $lottery_id = $_GET['lottery_id'];
                echo fetch_cached_history($lottery_id);
            } catch (\Throwable $th) {
                echo json_encode(['status' => false, 'message' => 'Invalid request.']);
            }
           
        }
    }
}
get_history();
