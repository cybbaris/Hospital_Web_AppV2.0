<?php
session_start();
require_once 'hospital_db.php';


$show_add_form = false; 
if (isset($_POST['add_user'])) {
    $username = $baglanti->real_escape_string($_POST['username']);
    $password = $baglanti->real_escape_string($_POST['password']); 
    $email = $baglanti->real_escape_string($_POST['email']);
    $name = $baglanti->real_escape_string($_POST['name']);
    $surname = $baglanti->real_escape_string($_POST['surname']);

    $check_sorgu = "SELECT id FROM users WHERE username='$username'";
    $check_sonuc = $baglanti->query($check_sorgu);
    if ($check_sonuc->num_rows > 0) {
        $error = "Bu kullanıcı adı zaten alınmış!";
        $show_add_form = true; 
    } else {
        $sorgu = "INSERT INTO users (username, password, email, name, surname) VALUES ('$username', '$password', '$email', '$name', '$surname')";
        if ($baglanti->query($sorgu)) {
            header("Location: users.php");
            exit;
        } else {
            $error = "Kullanıcı eklenirken hata: " . $baglanti->error;
            $show_add_form = true;
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $baglanti->real_escape_string($_GET['delete']);
    $sorgu = "DELETE FROM users WHERE id='$id'";
    $baglanti->query($sorgu);
    header("Location: users.php");
    exit;
}

if (isset($_POST['update_user'])) {
    $id = $baglanti->real_escape_string($_POST['id']);
    $username = $baglanti->real_escape_string($_POST['username']);
    $password = $baglanti->real_escape_string($_POST['password']); 
    $email = $baglanti->real_escape_string($_POST['email']);
    $name = $baglanti->real_escape_string($_POST['name']);
    $surname = $baglanti->real_escape_string($_POST['surname']);

    $check_sorgu = "SELECT id FROM users WHERE username='$username' AND id != '$id'";
    $check_sonuc = $baglanti->query($check_sorgu);
    if ($check_sonuc->num_rows > 0) {
        $error = "Bu kullanıcı adı zaten alınmış!";
    } else {
        $sorgu = "UPDATE users SET username='$username', password='$password', email='$email', name='$name', surname='$surname' WHERE id='$id'";
        if ($baglanti->query($sorgu)) {
            header("Location: users.php");
            exit;
        } else {
            $error = "Kullanıcı güncellenirken hata: " . $baglanti->error;
        }
    }
}

$sorgu = "SELECT * FROM users";
$sonuc = $baglanti->query($sorgu);

$page_title = "Kullanıcılar";
ob_start();
?>

<h2 class="text-center">Kullanıcı Yönetimi</h2>
<button id="show-add-form" class="btn btn-success mb-3" <?php echo $show_add_form ? 'style="display: none;"' : ''; ?>>Yeni Kullanıcı Ekle</button>


<div id="add-user-form" <?php echo $show_add_form ? 'style="display: block;"' : 'style="display: none;"'; ?> class="mb-4">
    <?php if (isset($error) && !isset($_POST['update_user'])): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="add_user" value="1">
        <div class="row align-items-end">
            <div class="col-md-2">
                <input type="text" name="name" class="form-control" placeholder="Ad" value="<?php echo ($show_add_form && isset($_POST['name'])) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="surname" class="form-control" placeholder="Soyad" value="<?php echo ($show_add_form && isset($_POST['surname'])) ? htmlspecialchars($_POST['surname']) : ''; ?>" required>
            </div>
            <div class="col-md-2">
                <input type="email" name="email" class="form-control" placeholder="E-posta" value="<?php echo ($show_add_form && isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="username" class="form-control" placeholder="Kullanıcı Adı" value="<?php echo ($show_add_form && isset($_POST['username'])) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
            </div>
            <div class="col-md-2">
                <input type="password" name="password" class="form-control" placeholder="Parola" value="<?php echo ($show_add_form && isset($_POST['password'])) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-sm me-1">Ekle</button>
                <button type="button" id="hide-add-form" class="btn btn-secondary btn-sm">İptal</button>
            </div>
        </div>
    </form>
</div>


<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ad</th>
            <th>Soyad</th>
            <th>Kullanıcı Adı</th>
            <th>E-posta</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $sonuc->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['surname']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <button class="btn btn-warning btn-sm show-edit-form" data-id="<?php echo $user['id']; ?>">Güncelle</button>
                    <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                </td>
            </tr>

            <tr id="edit-form-<?php echo $user['id']; ?>" class="edit-user-form" style="display: none;">
                <td colspan="6">
                    <?php if (isset($error) && isset($_POST['update_user']) && $_POST['id'] == $user['id']): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <input type="hidden" name="update_user" value="1">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <div class="row align-items-end">
                            <div class="col-md-2">
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="surname" class="form-control" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <input type="password" name="password" class="form-control" value="<?php echo htmlspecialchars($user['password']); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm me-1">Güncelle</button>
                                <button type="button" class="btn btn-secondary btn-sm hide-edit-form" data-id="<?php echo $user['id']; ?>">İptal</button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<style>
    .btn-sm { padding: 0.25rem 0.5rem; }
    .me-1 { margin-right: 0.25rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const addForm = document.getElementById('add-user-form');
    const showAddButton = document.getElementById('show-add-form');
    const hideAddButton = document.getElementById('hide-add-form');

    showAddButton.addEventListener('click', function() {
        addForm.style.display = 'block';
        showAddButton.style.display = 'none';
    });

    hideAddButton.addEventListener('click', function() {
        addForm.style.display = 'none';
        showAddButton.style.display = 'block';
    });


    document.querySelectorAll('.show-edit-form').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const editForm = document.getElementById('edit-form-' + id);
            editForm.style.display = 'table-row';
            button.style.display = 'none';
        });
    });

    document.querySelectorAll('.hide-edit-form').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const editForm = document.getElementById('edit-form-' + id);
            editForm.style.display = 'none';
            document.querySelector(`.show-edit-form[data-id="${id}"]`).style.display = 'inline-block';
        });
    });
});
</script>

<?php
$content = ob_get_clean();
include 'template.php';
?>