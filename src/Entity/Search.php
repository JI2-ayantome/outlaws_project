<?php

namespace App\Entity;

class Search 
{
    const FIELD_NOM = "nom";
    const FIELD_PRENOMS = "prenoms";
    const FIELD_JURIDICTION = "juridictions";
    const FIELD_NATIONALITE = "nationalite";
    const FIELD_INFRACTIONS = "infractions";
    const FIELD_ADRESSE = "adresse";
    const FIELD_EXECUTE = "execute";

    public $q = "";

    public $field;


}