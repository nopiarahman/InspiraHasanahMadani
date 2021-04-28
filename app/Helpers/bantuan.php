<?php
function cekNamaUser(){
    return auth()->user()->name;
}