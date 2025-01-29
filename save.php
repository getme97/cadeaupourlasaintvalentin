<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];  // Mot de passe en clair ❌

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Email invalide !");
    }

    // 📂 Vérification et création du dossier `data/`
    $dossier = "data/";
    if (!is_dir($dossier)) {
        mkdir($dossier, 0777, true);
    }

    // 📄 Fichier JSON pour stocker les utilisateurs
    $fichier = $dossier . "users.json";
    
    // 🔍 Charger les anciens utilisateurs s'ils existent
    $users = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];

    // 📌 Ajouter le nouvel utilisateur
    $users[] = ["email" => $email, "password" => $password];  // ⚠️ Stocké en clair

    // 📝 Sauvegarder en JSON
    file_put_contents($fichier, json_encode($users, JSON_PRETTY_PRINT));

    //echo "<script>alert('✅ Compte enregistré avec succès !'); window.location.href = 'index.html';</script>";

    header("Location: site.html");
    exit();
} else {
    echo "❌ Accès refusé.";
}
?>
