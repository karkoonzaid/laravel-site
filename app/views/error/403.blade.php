@extends('error.master')
<?php

$content = <<<HTML
<div class='container'>
    <div id='content' class='row'>
        <div class='alert alert-danger alert-block'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <div class='error-details' style="text-align: center">
               <h2>Bad Request, Contact Admin For More Details</h2>
            </div>
        </div>
    </div>
    <!-- end content -->
</div>
<!--end of container-->
HTML;

?>