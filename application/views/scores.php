<div>
<?php
    echo '<table class="table">';
    echo '<tr><th>user</th><th>time taken</th><th>wpm</th></tr>';
    foreach($scores as $score) {
        echo '<tr><td>'.$score['name'].'</td><td>'.(float)($score['time']/10).'s </td><td>'.round($trackInfo['words']/($score['time']/600),2).'</td></tr>';
    }
    echo '</table>';
    ?>
</div>
