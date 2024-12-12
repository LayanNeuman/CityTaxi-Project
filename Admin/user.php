
<?php
session_start();
require_once '../config/config.php';
require_once '../models/AutoPwd.php';
require_once '../models/user.php';


$user = new User($pdo);

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $user_type = $_POST['user_type'];
    $result = $user->createUser($email, $username, $user_type);

  }
  // Fetch all users
 $users = $user->getData();

?>
<?php require 'header.php';?>
<main>
    <div class="container-fluid">
        <!---Area---->
                    <div class="row">
                      <div class="col">
                      <?php
                              if (isset($_SESSION['message']))
                               {
                                  $msg_type = isset($_SESSION['msg_type']) && $_SESSION['msg_type'] == 'success' ? 'success' : 'danger';
                                  echo '<div class="alert alert-' . $msg_type . '" role="alert">' . $_SESSION['message'] . '</div>';
                                  unset($_SESSION['message']); // Clear the session message after displaying it
                                  unset($_SESSION['msg_type']); // Clear the session msg_type after displaying it
                               }
                           ?>
                        <div class="card">
                          <div class="card-body">
                          <h5 class="card-title mb-5 d-inline">Create User</h5>
                              <form method="POST" action="user.php" enctype="multipart/form-data">
                                <div class="col-md-6 form-outline mb-4 mt-4">
                                    <input type="email" name="email"  class="form-control" placeholder="Email" required />
                                </div>
                                <div class="col-md-6 form-outline mb-4">
                                    <input type="text" name="username"  class="form-control" placeholder="Username" required />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <select class="form-control form-control-sm" name="user_type" required>
                                        <option value="" selected disabled>User Type</option>
                                        <option value="O">Operator</option>
                                        <option value="A">Admin</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create</button>
                                </div>
                             </form>
                          </div>
                        </div>
                       </div>
                     </div>

        <!---Area---->

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">User Details</h5>
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">username</th>
                    <th scope="col">email</th>
                    <th scope="col">Type</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                      <?php if (!empty($users)): ?>
                          <?php foreach ($users as $index => $user): ?>
                              <tr>
                                  <th scope="row"><?php echo $index + 1; ?></th>
                                  <td><?php echo htmlspecialchars($user['username']); ?></td>
                                  <td><?php echo htmlspecialchars($user['email']); ?></td>
                                  <td><?php echo htmlspecialchars($user['user_type']); ?></td>
                                  <td>
                                      <!-- Placeholder for action buttons (e.g., Edit/Delete) -->
                                      <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                      <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                  </td>
                              </tr>
                          <?php endforeach; ?>
                      <?php else: ?>
                          <tr>
                              <td colspan="4">No users found.</td>
                          </tr>
                      <?php endif; ?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>
    </div>
</main>
<?php require 'footer.php';?>
