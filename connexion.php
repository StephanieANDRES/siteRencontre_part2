<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $erreur = "";
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        $erreur = "Adresse e-mail invalide!";
    }

    $mot_de_passe = $_POST['mot_de_passe'];

    if ($erreur == "") {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
        } else {
            $erreur = "Identifiants incorrects";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mx-auto mt-10 max-w-lg">
    <h2 class="text-2xl font-bold text-center">Connexion</h2>
    <form action="connexion.php" method="post" class="mt-4 bg-white p-6 rounded-lg shadow-md">
        <input type="email" name="email" placeholder="Email" class="border p-2 w-full mb-4" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" class="border p-2 w-full mb-4" required>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 w-full">Se connecter</button>
        <?php if (isset($erreur)): ?>
            <p class="text-red-500 mt-2"><?= $erreur ?></p>
        <?php endif; ?>
    </form>
</div>

<?php include 'includes/footer.php'; ?>