<?php
	namespace Database;

	use Composer\Script\Event;

	class Backup {
		public static function run(Event $event) {
			\Lib\Framework\EnvVarsLoader::loadEnvVars();

			$cur = getcwd();
			$dir = __DIR__ . '/../storage/backup/';
			$bk = sprintf("%s.sqlite", date('Y-m-d-U'));
			$IO = $event -> getIO();
			$which = sprintf("%s %s", (PHP_OS != 'WINNT') ? "which" : "where", escapeshellarg("sqlite3"));
			$db = __DIR__ . '/../' . ltrim(getenv('DATABASE_PATH'), '/');

			if (!is_writable($dir)) {
				return $IO -> writeError("<error>The backup directory ($dir) is not writable</error>");
			}

			switch (PHP_OS) {
				case 'Darwin':
				case 'Linux':
					$loc = shell_exec(sprintf("which %s", escapeshellarg("sqlite3")));
					$sqlite3 = (!empty($loc)) ? true : false;
				break;
				case 'WINNT':
					$loc = shell_exec(sprintf("where %s", escapeshellarg("sqlite3")));
					$sqlite3 = (file_exists(trim($loc))) ? true : false;
				break;
				default:
					$loc = shell_exec(sprintf("command -v %s", escapeshellarg("sqlite3")));
					$sqlite3 = (!empty($loc)) ? true : false;
				break;
			}

			if (!$sqlite3) {
				return $IO -> writeError("<error>The sqlite3 process cannot be found, so we cannot backup the database safely.</error>");
			} else {
				chdir($dir);
				$backup = shell_exec(sprintf('sqlite3 %s ".backup %s"', escapeshellarg($db), escapeshellarg($bk)));
				if (!file_exists($bk)) {
					$IO -> writeError("<error>The sqlite3 database backup was not created: storage/backup/$bk</error>");
				} else {
					$IO -> write("<info>Backup created: storage/backup/$bk</info>");
				}
				chdir($cur);
				exit;
			}
		}
	}
?>
