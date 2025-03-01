<!-- home.php -->

<h2>Lista de Alunos</h2>
<ul>
    <?php if (!empty($alunos) && is_array($alunos)): ?>
        <?php foreach ($alunos as $aluno): ?>
            <li><?= esc($aluno->nome); ?></li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>Não há alunos cadastrados.</li>
    <?php endif; ?>
</ul>
