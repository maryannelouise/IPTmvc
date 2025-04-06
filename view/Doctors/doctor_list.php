<div class="doctor-list">
    <?php foreach ($doctors as $doctor): ?>
    <div class="doctor-card">
        <img src="/assets/images/doctor/<?= $doctor['id'] ?>.png" alt="<?= htmlspecialchars($doctor['name']) ?>">
        <h3>Dr. <?= htmlspecialchars($doctor['name']) ?></h3>
        <p><?= htmlspecialchars($doctor['description']) ?></p>
        <a href="/doctors/schedule/<?= $doctor['id'] ?>" class="btn">View Availability</a>
    </div>
    <?php endforeach; ?>
</div>
