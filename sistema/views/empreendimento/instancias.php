<?php
    // print_r($model->licenciamentos);
    echo "<div class='row'>";
    echo "<div class='col'></div>";
    foreach ($model->licenciamentos as $row) {
        echo "<div class='col my-3'>";
        echo "<center>
            <div class='card' style='width: 18rem;'>
                <div class='card-body'>
                <h5 class='card-title'>$row->numero</h5>
                <h6 class='card-subtitle mb-2 text-body-secondary'><br></h6>
                <p class='card-text'>$row->descricao</p>
                </div>
            </div></center>
        ";
        echo "</div>";
    }
    echo "<div class='col'></div>";
    echo "</div>";