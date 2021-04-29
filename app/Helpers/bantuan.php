<?php
function cekNamaUser(){
    return auth()->user()->name;
}
function proyekId(){
    return auth()->user()->proyek_id;
}