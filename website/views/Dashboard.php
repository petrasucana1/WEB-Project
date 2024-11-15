<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: components/404Error.html");
    exit;
}


include_once '../app/models/Admin.php';
include_once '../app/models/Actor.php';
include_once '../app/models/Movie.php';
include_once '../app/models/Nominee.php';
include_once '../app/models/News.php';

$admin = new Admin();
$actor = new Actor();
$movie = new Movie();
$nominee= new Nominee();
$news= new News();

$admins = $admin->getAdmins();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['import'])) {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file']['tmp_name'];
        

            $result = $nominee->importCSV($fileTmpPath);
    
            if ($result) {
                $_SESSION['message'] = "Data imported successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to import data.";
                $_SESSION['message_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "File upload error.";
            $_SESSION['message_type'] = "error";
        }
    }

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'modify') {
            $admin_id = $_POST['admin_id'];
            $email = $_POST['email'];
            $password_plain = $_POST['password'];
            $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

            $result = $admin->editAdmin($admin_id, $email, $password_hash);
            if ($result) {
                $_SESSION['message'] = "Admin modified successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to modify admin.";
                $_SESSION['message_type'] = "error";
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        if ($action === 'delete') {
            $admin_id = $_POST['admin_id'];
            $result = $admin->deleteAdmin($admin_id);
            if ($result) {
                $_SESSION['message'] = "Admin deleted successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to delete admin.";
                $_SESSION['message_type'] = "error";
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        if ($action === 'addActor') {
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $popularity = $_POST['popularity'];
            $picture_url = $_POST['picture_url'];
            $departament = $_POST['departament'];
            $bio = $_POST['bio'];
            $birth_place = $_POST['birth_place'];
            $birthday = $_POST['birthday'];

            $data = [
                'name' => $name,
                'gender' => $gender,
                'popularity' => $popularity,
                'picture_url' => $picture_url,
                'departament' => $departament,
                'bio' => $bio,
                'birth_place' => $birth_place,
                'birthday' => $birthday
            ];

            $result = $actor->addActor($data);
            if ($result) {
                $_SESSION['message'] = "Actor added successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to add actor.";
                $_SESSION['message_type'] = "error";
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        if ($action === 'deleteActor') {
            $actor_id = $_POST['id'];
            $result = $actor->deleteActor($actor_id);
            if ($result) {
                $_SESSION['message'] = "Actor deleted successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to delete actor.";
                $_SESSION['message_type'] = "error";
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        if ($action === 'addMovie') {
            $actor_id = $_POST['actor_id'];
            $title = $_POST['title'];
            $release_date = $_POST['release_date'];
            $vote_average = $_POST['vote_average'];
            $poster_url = $_POST['poster_url'];

            $data = [
                'actor_id' => $actor_id,
                'title' => $title,
                'release_date' => $release_date,
                'vote_average' => $vote_average,
                'poster_url' => $poster_url,
            ];

            $result = $movie->addMovie($data);
            if ($result) {
                $_SESSION['message'] = "Movie added successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to add movie.";
                $_SESSION['message_type'] = "error";
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        if ($action === 'deleteMovie') {
            $movie_id = $_POST['id'];
            $result = $movie->deleteMovie($movie_id);
            if ($result) {
                $_SESSION['message'] = "Movie deleted successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to delete movie.";
                $_SESSION['message_type'] = "error";
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        if ($action === 'addNews') {
            $title = $_POST['title'];
            $date = $_POST['date'];
            $link = $_POST['link'];

            $data = [
                'title' => $title,
                'date' => $date,
                'link' => $link
            ];

            $result = $news->addNews($data);
            if ($result) {
                $_SESSION['message'] = "News added successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to add news.";
                $_SESSION['message_type'] = "error";
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        if ($action === 'deleteNews') {
            $news_id = $_POST['id'];
            $result = $news->deleteNews($news_id);
            if ($result) {
                $_SESSION['message'] = "News deleted successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to delete news.";
                $_SESSION['message_type'] = "error";
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }
    } else {
        $email = $_POST['email'];
        $password_plain = $_POST['password'];
        $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

        $data = [
            'Email' => $email,
            'Password' => $password_hash
        ];

        $result = $admin->addAdmin($data);
        if ($result) {
            $_SESSION['message'] = "Admin added successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to add admin.";
            $_SESSION['message_type'] = "error";
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link rel="stylesheet" href="styles/styles_admin.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/styles_database.css">
</head>
<body>
    <div class="message" id="message"></div>
    <div class="sidebar">
        <h1 style="color: goldenrod;">Dashboard</h1>
        <div class="button-container">
            <button class="button" onclick="showSection('admin-settings')">Admin Settings</button>
            <button class="button" onclick="showSection('database-settings')">Database Settings</button>
            <a href="Logout.php" style=" text-decoration: none; padding-left: 40%;" class="button">Logout</a>
        </div>
    </div>

    <div class="container">
        <div id="admin-settings" class="section">
            <h1>Admin Settings</h1>
            <div class="admin-table">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                
                    <tbody id="admin-list">
                        <?php foreach($admins as $admin) { ?>
                            <tr>
                                <td><?php echo $admin["Id"]; ?></td>
                                <td><?php echo $admin["Email"]; ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="admin_id" value="<?php echo $admin['Id']; ?>">
                                        <button type="button" onclick="openModal('<?php echo $admin['Id']; ?>', '<?php echo $admin['Email']; ?>')" class="modify-button">Modify</button>
                                        <button type="submit" name="action" value="delete" class="delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
            

            <h1>Add New Admin</h1>
            <div class="add-admin-container">
                <form method="POST" action="">
                    <input type="email" name="email" required  placeholder="Enter email">
                    <input type="password" name="password" required placeholder="Enter password">
                    <button type="submit" class="add-admin-button">Add Admin</button>
                </form>
            </div>

            <div id="modifyModal" class="modal">
                <div class="modal-content">
                    <h2>Modify Admin</h2>
                    <form id="modifyForm" method="POST" action="">
                        <input type="hidden" id="modifyId" name="admin_id">
                        <label for="modifyEmail">New Email:</label>
                        <input type="email" id="modifyEmail" name="email" required><br><br>
                        <label for="modifyPassword">New Password:</label>
                        <input type="password" id="modifyPassword" name="password" required><br><br>
                        <button type="button" onclick="closeModal()" class="modify-button">Cancel</button>
                        <button type="submit" name="action" value="modify" class="modify-button">Submit Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="database-settings" class="section" style="display: none;">
        <div class="container">
            <h2>Actors Table Management</h2> 
                <div class="buttons">
                    <button type="button" class="add-button" onclick="openAddActorModal()">Add Actor</button>
                    <button type="button" class="del-button" onclick="openDeleteActorModal()">Delete Actor</button>
                </div>
            <hr>
            <h2>Movies Table Management</h2> 
            <div class="buttons">
                <button type="button" class="add-button" onclick="openAddMovieModal()">Add Movie</button>
                <button type="button" class="del-button" onclick="openDeleteMovieModal()">Delete Movie</button>
            </div>
            <hr>
            <h2>News Table Management</h2> 
            <div class="buttons">
                <button type="button" class="add-button" onclick="openAddNewsModal()">Add News</button>
                <button type="button" class="del-button" onclick="openDeleteNewsModal()">Delete News</button>
            </div>
            <hr>
            <div class="import-section">
                <h2>Import from CSV</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Choose CSV file</label>
                        <input id="file" class="file-input" type="file" name="file" accept=".csv" required>
                    </div>
                    <button type="submit" name="import" class="import-button">Import</button>
                </form>
            </div>
        </div>

        <div id="addActorModal" class="modal">
            <div class="modal-content">
                <h2>Add Actor</h2>
                <form id="addActorForm" method="POST" action="">
                    <label for="name">Actor Name:</label>
                    <input type="text" id="name" name="name" required><br><br>
                    <label for="gender">Actor Gender:</label>
                    <input type="number" id="gender" name="gender" required><br><br>
                    <label for="popularity">Actor Popularity:</label>
                    <input type="number" id="popularity" name="popularity" required><br><br>
                    <label for="picture_url">Actor Picture Url:</label>
                    <input type="text" id="picture_url" name="picture_url" required><br><br>
                    <label for="departament">Actor Departament:</label>
                    <input type="text" id="departament" name="departament" required><br><br>
                    <label for="bio">Actor Biography:</label>
                    <input type="text" id="bio" name="bio" required><br><br>
                    <label for="birth_place">Actor Birth Place:</label>
                    <input type="text" id="birth_place" name="birth_place" required><br><br>
                    <label for="birthday">Actor Birth Date:</label>
                    <input type="date" id="birthday" name="birthday" required><br><br>
                    <button type="button" onclick="closeAddActorModal()" class="modify-button">Cancel</button>
                    <button type="submit" name="action" value="addActor" class="modify-button">Submit Changes</button>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteActorModal" class="modal">
        <div class="modal-content">
            <h2>Delete Actor</h2>
            <form id="deleteActorForm" method="POST" action="">
                <label for="id">Actor Id:</label>
                <input type="number" id="id" name="id" required><br><br>
                <button type="button" onclick="closeDeleteActorModal()" class="modify-button">Cancel</button>
                <button type="submit" name="action" value="deleteActor" class="modify-button">Submit Changes</button>
            </form>
        </div>
    </div>

    <div id="addMovieModal" class="modal">
        <div class="modal-content">
            <h2>Add Movie</h2>
            <form id="addMovieForm" method="POST" action="">
                <label for="actor_id">Movie Actor Id:</label>
                <input type="number" id="actor_id" name="actor_id" required><br><br>
                <label for="title">Movie Title:</label>
                <input type="text" id="title" name="title" required><br><br>
                <label for="release_date">Movie Release Date:</label>
                <input type="date" id="release_date" name="release_date" required><br><br>
                <label for="vote_average">Movie Vote Average:</label>
                <input type="number" id="vote_average" name="vote_average" required><br><br>
                <label for="poster_url">Movie Poster Url:</label>
                <input type="text" id="poster_url" name="poster_url" required><br><br>
                <button type="button" onclick="closeAddMovieModal()" class="modify-button">Cancel</button>
                <button type="submit" name="action" value="addMovie" class="modify-button">Submit Changes</button>
            </form>
        </div>
    </div>

    <div id="deleteMovieModal" class="modal">
        <div class="modal-content">
            <h2>Delete Movie</h2>
            <form id="deleteMovieForm" method="POST" action="">
                <label for="id">Movie Id:</label>
                <input type="number" id="id" name="id" required><br><br>
                <button type="button" onclick="closeDeleteMovieModal()" class="modify-button">Cancel</button>
                <button type="submit" name="action" value="deleteMovie" class="modify-button">Submit Changes</button>
            </form>
        </div>
    </div>

    <div id="addNewsModal" class="modal">
        <div class="modal-content">
            <h2>Add News</h2>
            <form id="addNewsForm" method="POST" action="">
                <label for="title">News Title:</label>
                <input type="text" id="title" name="title" required><br><br>
                <label for="date">News Date:</label>
                <input type="text" id="date" name="date" required><br><br>
                <label for="link">News Link:</label>
                <input type="text" id="link" name="link" required><br><br>
                <button type="button" onclick="closeAddNewsModal()" class="modify-button">Cancel</button>
                <button type="submit" name="action" value="addNews" class="modify-button">Submit Changes</button>
            </form>
        </div>
    </div>

    <div id="deleteNewsModal" class="modal">
        <div class="modal-content">
            <h2>Delete News</h2>
            <form id="deleteNewsForm" method="POST" action="">
                <label for="id">News Id:</label>
                <input type="number" id="id" name="id" required><br><br>
                <button type="button" onclick="closeDeleteNewsModal()" class="modify-button">Cancel</button>
                <button type="submit" name="action" value="deleteNews" class="modify-button">Submit Changes</button>
            </form>
        </div>
    </div>
</body>

<script>
    function openModal(id, email) {
        var modal = document.getElementById("modifyModal");
        var modifyId = document.getElementById("modifyId");
        var modifyEmail = document.getElementById("modifyEmail");

        modifyId.value = id;
        modifyEmail.value = email;

        modal.style.display = "block";
    }

    function closeModal() {
        var modal = document.getElementById("modifyModal");
        modal.style.display = "none";
    }

    function showSection(sectionId) {
        var sections = document.getElementsByClassName('section');
        for (var i = 0; i < sections.length; i++) {
            sections[i].style.display = 'none';
        }
        document.getElementById(sectionId).style.display = 'block';
    }

    window.onload = function() {
            const message = '<?php echo isset($_SESSION["message"]) ? $_SESSION["message"] : ""; ?>';
            const messageType = '<?php echo isset($_SESSION["message_type"]) ? $_SESSION["message_type"] : ""; ?>';
            
            if (message) {
                const messageDiv = document.getElementById('message');
                messageDiv.classList.add(messageType);
                messageDiv.textContent = message;
                messageDiv.style.display = 'block';
                setTimeout(function() {
                    messageDiv.style.display = 'none';
                }, 2000);
                <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            }
        };
        
    // Functions to handle opening and closing modals for adding and deleting actors and movies
    function openAddActorModal() {
        var modal = document.getElementById("addActorModal");
        modal.style.display = "block";
    }

    function closeAddActorModal() {
        var modal = document.getElementById("addActorModal");
        modal.style.display = "none";
    }

    function openDeleteActorModal() {
        var modal = document.getElementById("deleteActorModal");
        modal.style.display = "block";
    }

    function closeDeleteActorModal() {
        var modal = document.getElementById("deleteActorModal");
        modal.style.display = "none";
    }

    function openAddMovieModal() {
        var modal = document.getElementById("addMovieModal");
        modal.style.display = "block";
    }

    function closeAddMovieModal() {
        var modal = document.getElementById("addMovieModal");
        modal.style.display = "none";
    }

    function openDeleteMovieModal() {
        var modal = document.getElementById("deleteMovieModal");
        modal.style.display = "block";
    }

    function closeDeleteMovieModal() {
        var modal = document.getElementById("deleteMovieModal");
        modal.style.display = "none";
    }

    function openDeleteNewsModal() {
        var modal = document.getElementById("deleteNewsModal");
        modal.style.display = "block";
    }

    function closeDeleteNewsModal() {
        var modal = document.getElementById("deleteNewsModal");
        modal.style.display = "none";
    }

    function openAddNewsModal() {
        var modal = document.getElementById("addNewsModal");
        modal.style.display = "block";
    }

    function closeAddNewsModal() {
        var modal = document.getElementById("addNewsModal");
        modal.style.display = "none";
    }

    
</script>
</html>
