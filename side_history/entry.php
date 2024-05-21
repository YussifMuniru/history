<?php
require_once('utils.php');
function get_history() {

    if (isset($_SERVER) && isset($_SERVER['REQUEST_METHOD'])) {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            try {
                $valid_types = ['std', 'two_sides', 'board_games', 'full_chart'];
                $count       = isset($_GET['count']) ? $_GET['count'] : 30;
                if (!in_array($count, [30, 50, 100]) || !in_array($_GET['type'], $valid_types)) {
                    echo json_encode(['status' => false, 'message' => 'Invalid request.']);
                    return;
                }
                $lottery_id = $_GET['lottery_id'];
                $type       = $_GET['type'];
                echo fetch_cached_history($lottery_id, $type, $count);
            } catch (\Throwable $th) {
                echo json_encode(['status' => false, 'message' => 'Invalid request.']);
            }
           
        }
    }
}
get_history();
