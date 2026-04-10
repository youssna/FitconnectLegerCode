<?php
// --- DONNÉES ---
$dataProgrammes = [
    'prise_masse' => [
        'titre' => 'Prise de Masse',
        'sous_titre' => 'Volume & Hypertrophie',
        'image' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?q=80&w=1920&auto=format&fit=crop',
        'description' => 'Ce programme est conçu pour maximiser le volume musculaire. L\'accent est mis sur les mouvements polyarticulaires avec des charges lourdes pour stimuler l\'hypertrophie.',
        'frequence' => '4 séances / semaine',
        'duree' => '1h15',
        'difficulte' => 'Intense'
    ],
    'seche' => [
        'titre' => 'Sèche & Définition',
        'sous_titre' => 'Brûler le gras, garder le muscle',
        'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=1920&auto=format&fit=crop',
        'description' => 'Un rythme soutenu pour augmenter la dépense calorique. Nous combinons musculation en séries longues et circuits training pour dessiner les muscles.',
        'frequence' => '5 séances / semaine',
        'duree' => '1h00',
        'difficulte' => 'Cardio élevé'
    ],
    'remise_forme' => [
        'titre' => 'Remise en Forme',
        'sous_titre' => 'Santé & Vitalité',
        'image' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?q=80&w=1920&auto=format&fit=crop',
        'description' => 'Idéal pour reprendre le sport en douceur. Ce programme mixe renforcement musculaire global et travail cardio-vasculaire pour retrouver du tonus.',
        'frequence' => '3 séances / semaine',
        'duree' => '45 min',
        'difficulte' => 'Modéré'
    ]
];

$type = isset($_GET['type']) ? $_GET['type'] : null;
$prog = ($type && isset($dataProgrammes[$type])) ? $dataProgrammes[$type] : null;
?>

<?php if ($prog): ?>

    <section class="prog-hero" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('<?= $prog['image'] ?>');">
        <div class="hero-content">
            <span class="badge-hero"><?= $prog['difficulte'] ?></span>
            <h1><?= $prog['titre'] ?></h1>
            <p><?= $prog['sous_titre'] ?></p>
            <a href="index.php?page=programme" class="btn btn-outline">← Voir les autres programmes</a>
        </div>
    </section>

    <div class="container prog-container">
        
        <div class="prog-main">
            <h2>En quoi consiste ce programme ?</h2>
            <p class="prog-desc"><?= $prog['description'] ?></p>

            <div class="locked-content">
                <h3>🔒 Détail des séances</h3>
                <p>Ce module complet comprend :</p>
                <ul style="margin-bottom: 20px; list-style-type: circle; padding-left: 20px;">
                    <li>La liste précise des exercices jour par jour</li>
                    <li>Le nombre de séries et de répétitions</li>
                    <li>Les temps de repos optimisés</li>
                    <li>L'accès au suivi par votre coach</li>
                </ul>
                <p style="font-weight: bold; color: #333;">
                    Le planning détaillé est disponible uniquement dans votre Espace Client après validation par votre coach.
                </p>
            </div>
        </div>

        <div class="prog-sidebar">
            <div class="summary-card">
                <h3>Récapitulatif</h3>
                <ul class="summary-list">
                    <li>
                        <span class="icon">📅</span>
                        <div><strong>Fréquence</strong> <small><?= $prog['frequence'] ?></small></div>
                    </li>
                    <li>
                        <span class="icon">⏱️</span>
                        <div><strong>Durée</strong> <small><?= $prog['duree'] ?></small></div>
                    </li>
                    <li>
                        <span class="icon">🔥</span>
                        <div><strong>Difficulté</strong> <small><?= $prog['difficulte'] ?></small></div>
                    </li>
                </ul>
                <hr>
                <a href="index.php?page=inscription_client" class="btn btn-primary full-width">Commencer ce programme</a>
            </div>
        </div>
    </div>

<?php else: ?>

    <section class="hero" style="height: 350px;">
        <div class="hero-content">
            <h1>Nos Programmes</h1>
            <p>Choisissez l'objectif qui vous correspond.</p>
        </div>
    </section>

    <section class="programmes container">
        <div class="programmes-grid">
            <?php foreach($dataProgrammes as $key => $p): ?>
            <div class="card" style="padding: 0; overflow: hidden;">
                <div style="height: 150px; background: url('<?= $p['image'] ?>') center/cover;"></div>
                <div style="padding: 30px;">
                    <h3><?= $p['titre'] ?></h3>
                    <p><?= $p['sous_titre'] ?></p>
                    <a href="index.php?page=programme&type=<?= $key ?>" class="btn-card">Découvrir</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

<?php endif; ?>