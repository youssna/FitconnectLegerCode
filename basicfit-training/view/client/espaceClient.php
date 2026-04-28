<div class="container padding-container">
    
    <div class="dashboard-welcome">
        <div class="welcome-text">
            <h1>Ravi de vous revoir, <?= htmlspecialchars($_SESSION['prenom']) ?> !</h1>
            <p>Prêt à vous dépasser aujourd'hui ? Voici votre suivi.</p>
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Objectif</span>
                <span class="stat-value orange"><?= htmlspecialchars($monProfil['objectif']) ?></span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Poids actuel</span>
                <span class="stat-value"><?= htmlspecialchars($monProfil['poids']) ?> kg</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Taille</span>
                <span class="stat-value"><?= htmlspecialchars($monProfil['taille']) ?> cm</span>
            </div>
        </div>
    </div>

    <div class="dashboard-split-row">
        
        <div class="card dashboard-card coach-section">
            <h3>Mon Coach</h3>
            <?php if ($monCoach): ?>
                <div class="coach-details" style="margin-top: 15px;">
                    <h4 style="margin-bottom: 12px; font-size: 1.2em; color: #2c3e50;">
                        <?= htmlspecialchars($monCoach['prenom']) ?> <?= htmlspecialchars($monCoach['nom']) ?>
                    </h4>
                    <p style="margin: 5px 0; color: #34495e; font-size: 0.95em;">
                        <strong>Email :</strong> <a href="mailto:<?= htmlspecialchars($monCoach['mail']) ?>" style="color: #d35400; text-decoration: none;"><?= htmlspecialchars($monCoach['mail']) ?></a>
                    </p>
                    <p style="margin: 5px 0; color: #34495e; font-size: 0.95em;">
                        <strong>Téléphone :</strong> <?= !empty($monCoach['telephone']) ? htmlspecialchars($monCoach['telephone']) : 'Non renseigné' ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="coach-searching-small">
                    <div>
                        <strong>Recherche en cours</strong>
                        <p>Nous cherchons le meilleur expert.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <div class="card dashboard-card programme-large">
        <div class="card-header-clean">
            <h3>Mon Programme</h3>
            <?php if ($monProgramme): ?>
                <span class="badge orange"><?= htmlspecialchars($monProgramme['nom']) ?></span>
            <?php endif; ?>
        </div>
        
        <?php if ($monCoach && $monProgramme): ?>
            <div class="programme-content">
                
                <div class="programme-details">
                    <span class="badge info">Niveau : <?= htmlspecialchars($monProgramme['niveau']) ?></span>
                    <span class="badge info">Durée : <?= htmlspecialchars($monProgramme['duree_semaines']) ?> semaines</span>
                    <span class="badge info">Fréquence : <?= htmlspecialchars($monProgramme['frequence_par_semaine']) ?>x / semaine</span>
                </div>
                
                <hr class="card-divider">

                <div class="programme-description">
                    <?= htmlspecialchars($monProgramme['description']) ?> 
                </div>

                <?php 
                // On récupère les détails
                $exercicesDetails = [];
                if (!empty($monProgramme) && isset($monProgramme['id_programme'])) {
                    $exercicesDetails = $programmeModel->getDetailsProgramme($monProgramme['id_programme']); 
                }
                ?>

                <?php if (!empty($exercicesDetails)): ?>
                    <div class="seances-container">
                        <?php 
                        $jourActuel = 0;
                        foreach ($exercicesDetails as $exo): 
                            // Si on change de jour, on crée un nouveau tableau
                            if ($jourActuel != $exo['jour_numero']): 
                                // Si ce n'est pas le premier jour, on ferme le tableau précédent
                                if ($jourActuel != 0): ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <div class="seance-block">
                                    <h4 class="seance-titre"><?= htmlspecialchars($exo['titre_seance']) ?></h4>
                                    <div class="table-responsive">
                                        <table class="programme-table">
                                            <thead>
                                                <tr>
                                                    <th>Exercice</th>
                                                    <th>Groupe Musculaire</th>
                                                    <th>Séries</th>
                                                    <th>Répétitions</th>
                                                    <th>Repos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            <?php $jourActuel = $exo['jour_numero']; 
                            endif; ?>
                            
                            <tr>
                                <td class="exo-nom"><strong><?= htmlspecialchars($exo['nom_exercice']) ?></strong></td>
                                <td class="exo-muscle"><?= htmlspecialchars($exo['groupe_musculaire']) ?></td>
                                <td class="exo-stats"><span class="badge-stat"><?= htmlspecialchars($exo['series']) ?></span></td>
                                <td class="exo-stats"><strong><?= htmlspecialchars($exo['repetitions']) ?></strong></td>
                                <td class="exo-stats"><?= htmlspecialchars($exo['repos_secondes']) ?> sec</td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <?php if ($jourActuel != 0): ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="no-data-alert">
                        <p>Le détail des séances n'a pas encore été ajouté à ce programme.</p>
                    </div>
                <?php endif; ?>
                </div>
        <?php else: ?>
            <div class="no-coach-state">
                <p>Vous n'avez pas encore de coach assigné ou de programme défini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>