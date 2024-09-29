<?php
include 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $age = $_POST['age'];
    $genre = $_POST['genre'];
    $preference = $_POST['preference'];
    $bio = $_POST['bio'];
    $localisation = $_POST['localisation'];

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, pseudo, email, mot_de_passe, age, genre, preference, bio, localisation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $pseudo, $email, $mot_de_passe, $age, $genre, $preference, $bio, $localisation]);

    header('Location: connexion.php');
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mx-auto mt-10 max-w-lg">
    <h2 class="text-2xl font-bold text-center">Inscription</h2>
    <form action="inscription.php" method="post" class="mt-4 bg-white p-6 rounded-lg shadow-md">
        <input type="text" name="nom" placeholder="Nom" class="border p-2 w-full mb-4" required>
        <input type="text" name="prenom" placeholder="Prénom" class="border p-2 w-full mb-4" required>
        <input type="text" name="pseudo" placeholder="Pseudo" class="border p-2 w-full mb-4" required>
        <input type="email" name="email" placeholder="Email" class="border p-2 w-full mb-4" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" class="border p-2 w-full mb-4" required>
        <input type="number" name="age" placeholder="Âge" class="border p-2 w-full mb-4" required>
        <select name="genre" class="border p-2 w-full mb-4">
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Autre">Autre</option>
        </select>
        <select name="preference" class="border p-2 w-full mb-4">
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Tous">Tous</option>
        </select>
        <textarea name="bio" placeholder="Votre bio" class="border p-2 w-full mb-4"></textarea>
        <input type="text" name="localisation" placeholder="Localisation" class="border p-2 w-full mb-4">
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 w-full">S'inscrire</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
