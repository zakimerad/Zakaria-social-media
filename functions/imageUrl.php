<?php 

function getImageUrl($imageName) {
    return "actions/uploads/" . htmlspecialchars($imageName);
}



?>