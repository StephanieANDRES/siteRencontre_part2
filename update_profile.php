<?php
session_start();
include 'includes/db.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupère l'utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT nom, prenom, pseudo, email, photo FROM utilisateurs WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $photo = $_FILES['photo'];

    // Traitement de l'upload de la photo
    if ($photo['error'] === UPLOAD_ERR_OK) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($photo["name"]);
        move_uploaded_file($photo["tmp_name"], $target_file);
        $photo_path = $target_file;
    } else {
        $photo_path = $user['photo']; // Conserve l'ancienne photo si pas de nouvelle
    }

    // Met à jour les informations de l'utilisateur
    $stmt = $pdo->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, pseudo = ?, email = ?, photo = ? WHERE id = ?");
    $stmt->execute([$nom, $prenom, $pseudo, $email, $photo_path, $user_id]);

    header("Location: profil.php?id=$user_id");
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'menu.php'; ?>

<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold">Modifier mon profil</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nom" class="block">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom']) ?>" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="prenom" class="block">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="pseudo" class="block">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" value="<?= htmlspecialchars($user['pseudo']) ?>" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="photo" class="block">Photo de profil</label>
            <input type="file" name="photo" id="photo" class="border p-2 w-full">
        </div>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Mettre à jour</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
