<section class="form-section">
    <div class="form-card" style="max-width: 600px;"> 
        <h2>Inscription Espace Client</h2>

        <form action="index.php" method="POST">
            
            <input type="hidden" name="controller" value="client">
            <input type="hidden" name="action" value="ajouter">

            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>Nom :</label>
                    <input type="text" name="nom" class="form-input" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Prénom :</label>
                    <input type="text" name="prenom" class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="mail" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Téléphone :</label>
                <input type="tel" name="telephone" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="motdepasse" class="form-input" required>
            </div>

            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>Poids (kg) :</label>
                    <input type="number" name="poids" class="form-input" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Taille (cm) :</label>
                    <input type="number" name="taille" class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <label>Votre Objectif :</label>
                <select name="objectif" class="form-input">
                    <option value="prise_masse">Prise de masse</option>
                    <option value="seche">Sèche</option>
                    <option value="remise_forme">Remise en forme</option>
                </select>
            </div>

            <div class="form-group">
                <label>Description / Motivation :</label>
                <textarea name="description" class="form-input" placeholder="Parlez-nous de vos attentes..." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary full-width">Commencer ma transformation</button>
        </form>

        <div class="form-footer">
            <p>Déjà un compte ? <a href="index.php?page=connexion_client">Se connecter</a></p>
        </div>
    </div>
</section>