<?php
if($m == 'INVALID_PARA') {
    echo $d;
} else if( $m == 'SIMILAR_EXISTS') {
    echo 'There is already a paragraph with stark similarity with the one you just entered!<br>';
    echo 'Play it <a href="'.(base_url().'?trackid='.$d).'">here</a>';
    
} else if( $m == 'INSERT_FAILURE') {
    echo 'Something went wrong at our end. Please try again later!';
}
?>
<br><br>
<a href="<?php echo base_url() ;?>">Back Home</a>
