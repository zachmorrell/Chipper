<?php
    // Ensure we are receiving a POST.
    if($_SERVER['REQUEST_METHOD']=='POST') {
        
        // Identify JSON received and decode it.
        $input_JSON = file_get_contents('php://input');
        $decoded_JSON = json_decode($input_JSON, true);

        // If the changes exist, continue to update the database.
        if(isset($decoded_JSON['update'])) {
            $changes = $decoded_JSON['update'];

            // Connect to database in preparation for update/s.
            require '../../../config/db_connect.php';

            // Check if first index length is greater than two.
            if($changes['task'] == 'users') {
                
                // Update users if more than 2 params are sent
                    $user_id = $changes['id'];
                    $restriction = $changes['restriction'];
                    $role = $changes['role'];

                    $update_sql = 'UPDATE users
                    SET restriction = :restriction, role = :role
                    WHERE userID = :user_id';

                    $sql_statement = $db->prepare($update_sql);
                    $sql_statement->bindParam(':restriction', $restriction);
                    $sql_statement->bindParam(':role', $role);
                    $sql_statement->bindParam(':user_id', $user_id);
                    $sql_statement->execute();
            } else {

                // For each change in changes, update database.
                // Currently there is only a max of one change at any given time.
                    $id = $changes['id'];
                    $hidden = $changes['hidden'];

                    $update_sql = 'UPDATE images 
                    SET hidden = :hidden 
                    WHERE imageID = :id';

                    $sql_statement = $db->prepare($update_sql);
                    $sql_statement->bindParam(':hidden', $hidden);
                    $sql_statement->bindParam(':id', $id);
                    $sql_statement->execute();
            }

            // Close the database.
            $db = null;
            
            $response = ['status' => 'success', 'message' => $changes['task'] . ' database updated successfully.'];
            echo json_encode($response);
        } else {
            $response = ['status' => 'success', 'message' => 'There was an issue with an update request.'];
            echo json_encode($response);
        }
    }
?>