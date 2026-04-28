<section class="form-section" style="background-color: #eee;">
    <div class="form-card" style="max-width: 600px; border-top: 5px solid #333;">
        <h2 style="color: #333;">Inscription Coach</h2>
        <p style="text-align:center; color:#666; margin-bottom:20px;">
            Rejoignez l'élite Basic-Fit Training.
        </p>

        <form action="index.php" method="POST">
            
            <input type="hidden" name="controller" value="coach">
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
                <label>Email pro :</label>
                <input type="email" name="mail" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Téléphone :</label>
                <input type="tel" name="telephone" class="form-input"  required>
            </div>

            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="motdepasse" class="form-input" minlength="8" required>
                <small style="color:#666;"></small>
            </div>

        

            <div class="form-group">
                <label>Adresse Postale :</label>
                <input type="text" name="adresse" class="form-input" placeholder="Ville, Code Postal..." required>
            </div>

            <div class="form-group">
                <label>Votre Spécialité (Expertise) :</label>
                <select name="specialite" class="form-input">
                    <option value="prise_masse">Prise de Masse (Hypertrophie)</option>
                    <option value="seche">Sèche & Perte de poids</option>
                    <option value="remise_forme">Remise en Forme & Cardio</option>
                </select>
            </div>

            <div class="form-group">
                <label>Votre CV (Lien LinkedIn ou Portfolio) :</label>
                <input type="text" name="cv" class="form-input" placeholder="https://..." required>
            </div>

            <button type="submit" class="btn btn-primary full-width" style="background-color: #333; border-color: #333;">S'inscrire</button>
        </form>

        <div class="form-footer">
            <p>Déjà membre de l'équipe ? <a href="index.php?page=connexioncoach" style="color:#333;">Accès Espace Pro</a></p>
        </div>
    </div>
</section>