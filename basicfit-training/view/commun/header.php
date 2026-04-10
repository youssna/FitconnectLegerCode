<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitConnect - Basic-Fit Training</title>
    
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<header class="main-header">
    <div class="container header-content">
        
        <div class="logo">
            <a href="index.php">
                Fit<span>Connect</span>
            </a>
        </div>

        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="index.php?page=programme">Nos Programmes</a></li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>
                    <li>
                        <span class="user-welcome">Bonjour, <?= htmlspecialchars($_SESSION['prenom']) ?></span>
                    </li>
                    <li>
                        <a href="index.php?page=espace_client" class="btn-outline">Mon Espace</a>
                    </li>
                    <li>
                        <form action="index.php" method="POST" style="display:inline;">
                            <input type="hidden" name="controller" value="client">
                            <input type="hidden" name="action" value="deconnexion">
                            <button type="submit" class="btn-logout">Se déconnecter</button>
                        </form>
                    </li>

                <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'coach'): ?>
                    <li>
                        <span class="user-welcome">Coach <?= htmlspecialchars($_SESSION['prenom']) ?></span>
                    </li>
                    <li>
                        <a href="index.php?page=espace_coach" class="btn-outline">Mon Espace</a>
                    </li>
                    <li>
                        <form action="index.php" method="POST" style="display:inline;">
                            <input type="hidden" name="controller" value="coach">
                            <input type="hidden" name="action" value="deconnexion">
                            <button type="submit" class="btn-logout">Se déconnecter</button>
                        </form>
                    </li>

                <?php else: ?>
                    <li><a href="index.php?page=connexion_client">Espace Client</a></li>
                    
                    <li><a href="index.php?page=inscription_coach">Devenir Coach</a></li>
                    
                    <li><a href="index.php?page=connexion_coach" class="link-coach">Accès Pro</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>