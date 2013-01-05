<?php
/**
* 
* Alias für Sprachkonstrukte erstellen
*
* Datum: 20.12.2012
*
**/
namespace Core;

class Alias {
	const TMP_FILE = 'cache/alias.tmp.php';

	private static $aliasCallback = [];

	/**
	* Macht einen Alias für eine Klasse. Unterschied zu class_alias(): Er lässt sich nachvollziehen
	*
	* @param Classname $original - Eigentlicher Klassenname
	* @param Classname $alias - Alias
	**/
	public static function forClass(Classname $original, Classname $alias) {
		if(class_exists($alias->getFullClassname(), false))
			throw new \Exception('Es gibt bereits eine Klasse mit dem Namen „'.$alias->getFullClassname().'“.', 1110);
		
		
		$script = 'namespace '.$alias->getNamespaceAsString().'; class '.$alias->getClassname().' extends '.$original->getFullClassname().' {}';
		self::runScript($script);
	}
	
	/**
	* Macht einen Alias für eine Funktion
	*
	* @param callable $original - Eigentlicher Funktionsname
	* @param string $alias - Alias
	**/
	public static function forFunction(callable $original, $alias) {
		if(function_exists($alias)) throw new Exception('Es gibt bereits eine Funktion mit dem Namen „'.$alias.'“.', 1111);
		
		// Callback speichern
		self::$aliasCallback[$alias] = $original;
	
		$script = 'function '.$alias.'() { return call_user_func_array(\Core\Alias::getCallbackForAlias(\''.$alias.'\'), func_get_args()); }';
		self::runScript($script);
	}
	
	/**
	* Schreibt den Code in die tmp-Datei und führt ihn aus.
	*	Wieso kein eval()? Fehlerbehandlung!
	*
	* @param string $script - Der Code
	**/
	private static function runScript($script) {
		$script = '<?php '.$script.' ?>';
		
		// Inhalt in die Datei schreiben
		file_put_contents(ROOT_PATH.self::TMP_FILE, $script);
		
		// Datei öffnen
		require ROOT_PATH.self::TMP_FILE;
	}
	
	/**
	* Gibt den Callback für eine Funktion zurück
	*
	* @param string $alias - Name der Funktione
	* @return callable
	**/
	public static function getCallbackForAlias($alias) {
		return self::$aliasCallback[$alias];
	}
} 	
?>