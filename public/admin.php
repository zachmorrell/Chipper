<!-- USE CSS TO FLOAT LEFT AND TOP 50% -->
<nav class="admin_nav">
    <ul>
        <li><a href="#" onclick="display_contents()">Contents</a></li>
        <li><a href="#" onclick="display_users()">Users</a></li>
    </ul>
</nav>
<?php
    // Database connection hosted outside the publicly available directory.
    require('../config/db_connect.php');
    $query_contents = $db->query("SELECT * FROM images ORDER BY imageID");
    $content_rows = array();
    if($query_contents !== FALSE) {
        $content_rows = $query_contents->fetchAll(PDO::FETCH_ASSOC);
    }
    $query_users = $db->query("SELECT userID, username, firstName, lastName, email, restriction, role FROM users ORDER BY userID");
    $users_rows = array();
    if($query_users !== FALSE) {
        $users_rows = $query_users->fetchAll(PDO::FETCH_ASSOC);
    }
?>
<div class="container">
    <table id="community_table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>File Name</th>
                <th>Creator ID</th>
                <th>Meme</th>
                <th>Hidden</th>
            </tr>
        <?php
        foreach($content_rows as $row) {
            $id = $row['imageID'];
            $name = $row['imageName'];
            $file_name = $row['img_name'];
            $creator_id = $row['userID'];
            $meme = $row['isMeme'];
            $hidden = $row['hidden'];
            $class = 'green';
            if($hidden == 1) {
                $class = 'red';
            }
            echo "
            <tr class=$class>
                <td>$id</td>
                <td>$name</td>
                <td>$file_name</td>
                <td>$creator_id</td>
                <td>$meme</td>
                <td>$hidden</td>
            </tr>";
        }
        ?>
    </table>
    <table id="users_table" hidden="true">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Restriction</th>
                <th>Role</th>
            </tr>
        <?php
        foreach($users_rows as $row) {
            $id = $row['userID'];
            $username = $row['username'];
            $first_name = $row['firstName'];
            $last_name = $row['lastName'];
            $email = $row['email'];
            $restriction = $row['restriction'];
            $role = $row['role'];
            $class = 'green';
            if($restriction == 1) {
                $class = 'red';
            }
            echo "
            <tr class=$class>
                <td>$id</td>
                <td>$username</td>
                <td>$first_name</td>
                <td>$last_name</td>
                <td>$email</td>
                <td>$restriction</td>
                <td>$role</td>
            </tr>";
        }
        ?>

    </table>
</div>
<script>
    function display_contents() {
        document.getElementById('community_table').hidden = false;
        document.getElementById('users_table').hidden = true;
    }
    function display_users() {
        document.getElementById('community_table').hidden = true;
        document.getElementById('users_table').hidden = false;
    }
    /*
        Changes an image content from visible-hidden-visible based on row clicked.
    */
    document.getElementById('community_table').addEventListener('click', function (e) {
        // Check if the clicked element is a table cell (td)
        if (e.target.tagName.toLowerCase() === 'td') {

            // Maybe eventually check if td or column is userid or hidden to do different things.
            var tdContent = e.target.textContent;

            // Get the parent row (tr) of the clicked td
            var row = e.target.parentNode;

            // Find all td elements within the row and convert them to an array
            var tds = Array.from(row.getElementsByTagName('td'));

            // Get the first td of the row
            var firstTd = parseInt(tds[0].textContent);
            var hiddenTd = tds[5]
            var content_hidden = parseInt(hiddenTd.textContent);
            
            // Open a view of the content based on row clicked and allow the admin to hide or unhide content.
            if(content_hidden == 0) {
                content_hidden = 1;
                row.className = 'red';
            } else {
                content_hidden = 0;
                row.className = 'green';
            }

            hiddenTd.textContent = content_hidden;

            update_database([{id: firstTd, hidden: content_hidden}]);
        }
    });
    document.getElementById('users_table').addEventListener('click', function (e) {
        // Check if the clicked element is a table cell (td)
        if (e.target.tagName.toLowerCase() === 'td') {

            // Maybe eventually check if td or column is userid or hidden to do different things.
            var tdContent = e.target.textContent;

            // Get the parent row (tr) of the clicked td
            var row = e.target.parentNode;

            // Find all td elements within the row and convert them to an array
            var tds = Array.from(row.getElementsByTagName('td'));

            // Get the first td of the row
            var firstTd = parseInt(tds[0].textContent);
            var hiddenTd = tds[5]
            var content_hidden = parseInt(hiddenTd.textContent);
            
            // Open a view of the content based on row clicked and allow the admin to hide or unhide content.
            if(content_hidden == 0) {
                content_hidden = 1;
                row.className = 'red';
            } else {
                content_hidden = 0;
                row.className = 'green';
            }

            hiddenTd.textContent = content_hidden;

            //update_database([{id: firstTd, hidden: content_hidden}]);
        }
    });

    function update_database(changes) {
        //Fetch API to update database whether hidden or not.
        fetch('assets/scripts/admin_update.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({update: changes}),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
</script>