<?php
/// FUNCTIONS.PHP

/// clean the form data to prevent injections

/*
 * Built in functions used
 * trip()
 * stripslashes()
 * htmlspecialchars()
 * strip_tagas()
 * str_replace()
 */
function validateFormData($formData) {
    $formData = trim( stripslashes( htmlspecialchars( strip_tags( str_replace( array('(', ')' ), '', $formData
    ) ), ENT_QUOTES ) ) );
    return $formData;
}

?>