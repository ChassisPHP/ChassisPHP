<?PHP

use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;

// Get the value of a .env variable
// If the variable is not set, use the default
if (! function_exists('envar')) {
    function envar($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

//debug tool for examining variables
if (! function_exists('debugVar')) {
    function debugVar($var)
    {
	$dumper = new HtmlDumper;
	$cloner = new VarCloner;
	$dumper->dump($cloner->cloneVar($var));
        die();
    }
}
