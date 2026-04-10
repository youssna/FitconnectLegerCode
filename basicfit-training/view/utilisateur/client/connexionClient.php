<section class="form-section">
    <div class="form-card">
        <h2>Connexion Espace Client</h2>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert-error">
                Email ou mot de passe incorrect.
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            
            <input type="hidden" name="controller" value="client">
            <input type="hidden" name="action" value="connexion">

            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="mail" class="form-input" placeholder="exemple@mail.com" required>
            </div>

            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="motdepasse" class="form-input" placeholder="Votre mot de passe" required>
            </div>

            <button type="submit" class="btn btn-primary full-width">Se connecter</button>
        </form>

        <div class="form-footer">
            <p>Pas encore de compte ? <a href="index.php?page=inscription_client">S'inscrire</a></p>
        </div>
    </div>
</section>