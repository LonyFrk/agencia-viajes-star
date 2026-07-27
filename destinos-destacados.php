<?php
$destinos = [
    [
        "nombre" => "San Pedro de Atacama",
        "descripcion" => "Paisajes desérticos y experiencias astronómicas.",
        "precio" => 180000
    ],
    [
        "nombre" => "Puerto Varas",
        "descripcion" => "Naturaleza, lagos y volcanes del sur de Chile.",
        "precio" => 145000
    ],
    [
        "nombre" => "Isla de Pascua",
        "descripcion" => "Historia, cultura y paisajes únicos.",
        "precio" => 390000
    ]
];
?>

<section class="container py-5">
    <h2 class="text-center mb-4">Destinos destacados</h2>

    <div class="row">
        <?php foreach ($destinos as $destino): ?>
            <div class="col-md-4 mb-3">
                <article class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title">
                            <?= htmlspecialchars($destino["nombre"]) ?>
                        </h3>

                        <p class="card-text">
                            <?= htmlspecialchars($destino["descripcion"]) ?>
                        </p>

                        <p>
                            Desde $<?= $destino["precio"] ?>
                        </p>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
