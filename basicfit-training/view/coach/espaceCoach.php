<div class="container padding-container">

    <div class="dashboard-banner">
        <div class="banner-info">
            <h1>Bonjour, Coach <?= htmlspecialchars($_SESSION['prenom']) ?></h1>
            <p>Gérez vos athlètes et vos demandes.</p>
        </div>
        <div class="banner-stat">
            <span class="stat-label">Votre Spécialité</span>
            <span class="stat-value orange"><?= htmlspecialchars($maSpecialite) ?></span>
        </div>
    </div>

    <section class="dashboard-section-modern">
        <h2 class="section-title-modern">Demandes en attente <span class="count-badge"><?= count($clientsEnAttente) ?></span></h2>
        
        <?php if (empty($clientsEnAttente)): ?>
            <div class="empty-state-modern">
                <span class="empty-icon">...</span>
                <h3>Tout est calme</h3>
                <p>Aucune nouvelle demande ne correspond à votre profil.</p>
            </div>
        <?php else: ?>
            <div class="clients-grid">
                <?php foreach($clientsEnAttente as $client): ?>
                    <div class="modern-card request-card">
                        <div class="modern-card-header">
                            <div class="client-identity">
                                <h3><?= htmlspecialchars($client['prenom']) ?> <?= htmlspecialchars($client['nom']) ?></h3>
                                <span class="client-goal">Objectif : <?= htmlspecialchars($client['objectif']) ?></span>
                            </div>
                            <span class="badge-modern new">Nouveau</span>
                        </div>
                        
                        <div class="modern-card-body">
                            <div class="info-row">
                                <span class="lbl-small">Email :</span>
                                <span class="info-text"><?= htmlspecialchars($client['mail']) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="lbl-small">Téléphone :</span>
                                <span class="info-text"><?= !empty($client['telephone']) ? htmlspecialchars($client['telephone']) : 'Non renseigné' ?></span>
                            </div>
                            <div class="data-grid">
                                <div class="data-item"><span class="lbl">Poids</span><span class="val"><?= $client['poids'] ?> kg</span></div>
                                <div class="data-item"><span class="lbl">Taille</span><span class="val"><?= $client['taille'] ?> cm</span></div>
                            </div>
                            <hr class="card-divider">
                            <div class="motivation-quote">"<?= htmlspecialchars($client['motivation']) ?>"</div>
                        </div>

                        <div class="modern-card-footer" style="display: flex; gap: 10px;">
                            <form action="index.php" method="POST" style="flex: 1;">
                                <input type="hidden" name="controller" value="coach">
                                <input type="hidden" name="action" value="accepter_client">
                                <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
                                <button type="submit" class="btn-modern success full-width">Accepter</button>
                            </form>
                            <form action="index.php" method="POST" style="flex: 1;">
                                <input type="hidden" name="controller" value="coach">
                                <input type="hidden" name="action" value="refuser_client">
                                <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
                                <button type="submit" class="btn-modern outline full-width" style="color: #e74c3c; border-color: #e74c3c;">Refuser</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <div class="section-separator"></div>

    <section class="dashboard-section-modern">
        <h2 class="section-title-modern">Mes Athlètes suivis <span class="count-badge gray"><?= count($mesClients) ?></span></h2>
        <?php if (empty($mesClients)): ?>
            <div class="empty-state-modern"><p>Vous n'avez pas encore de clients actifs.</p></div>
        <?php else: ?>
            <div class="clients-grid">
                <?php foreach($mesClients as $client): ?>
                    <div class="modern-card active-client-card">
                        <div class="modern-card-header">
                            <div class="client-identity">
                                <h3><?= htmlspecialchars($client['prenom']) ?> <?= htmlspecialchars($client['nom']) ?></h3>
                                <span class="client-goal"><?= htmlspecialchars($client['objectif']) ?></span>
                            </div>
                            <span class="badge-modern orange">Suivi</span>
                        </div>
                         <div class="modern-card-body">
                            <div class="info-row">
                                <span class="lbl-small">Email :</span>
                                <span class="info-text"><?= htmlspecialchars($client['mail']) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="lbl-small">Téléphone :</span>
                                <span class="info-text"><?= !empty($client['telephone']) ? htmlspecialchars($client['telephone']) : 'Non renseigné' ?></span>
                            </div>
                            <div class="data-grid">
                                <div class="data-item"><span class="lbl">Poids</span><span class="val"><?= $client['poids'] ?> kg</span></div>
                                <div class="data-item"><span class="lbl">Taille</span><span class="val"><?= $client['taille'] ?> cm</span></div>
                            </div>
                            <div class="info-block">
                                <strong>Objectif initial :</strong>
                                <p class="small-text">"<?= htmlspecialchars($client['motivation']) ?>"</p>
                            </div>
                        </div>
                        </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>