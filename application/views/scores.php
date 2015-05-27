<div class="score-table-wrapper">
<?php
    echo '<table>';
    echo '<tr><td>user</td><td>time taken</td><td>wpm</td></tr>';
    foreach($scores as $score) {
        echo '<tr><td>'.$score['name'].'</td><td>'.(float)($score['time']/10).'s </td><td>'.round($trackInfo['words']/($score['time']/600),2).'</td></tr>';
    }
    echo '</table>';
    ?>
</div>
