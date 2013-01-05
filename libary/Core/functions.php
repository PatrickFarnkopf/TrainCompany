<?php
/**
*
* Zusätzliche Sammlung an Funktionen
*
**/
namespace Core;

/**
* Addiert den Wert eines Key in verschiedenen Arrays miteinander
*
* @param array $arrays - Beliebig viele Array
* @return array - Addiertes Array
**/
function addArrayContent(array $arrays) {
	$addArray = [];
	foreach($arrays as $currentArray) {
		foreach($currentArray as $key=>$content) {
			if(!isset($addArray[$key])) $addArray[$key] = 0;
			$addArray[$key] += $content;
		}
	}
	
	return $addArray;
}

/**
* Subtrahiert den Wert eines Key in verschiedenen Arrays miteinander
*
* @param array $arrays - Beliebig viele Array
* @return array - Addiertes Array
**/
function subArrayContent(array $arrays) {
	$addArray = [];
	foreach($arrays as $currentArray) {
		foreach($currentArray as $key=>$content) {
			if(!isset($addArray[$key])) $addArray[$key] = 0;
			$addArray[$key] -= $content;
		}
	}
	
	return $addArray;
}

/**
* Macht aus einem php.ini-Wert eine Byte-Zahl
*
* @param string $sizeString - Ein Größen-String
* @return int - Eine Größe in Byte
**/
function calcBytes($sizeString) {
    $sizeString = trim($sizeString);
    $last = strtolower($sizeString[strlen($sizeString)-1]);
    switch($last) {
        case 'g':
            $sizeString *= 1024;
        case 'm':
            $sizeString *= 1024;
        case 'k':
            $sizeString *= 1024;
    }

    return $sizeString;
}
?>