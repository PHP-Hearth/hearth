<?php
namespace Hearth\Build\Target;

use \Hearth\Library\Chmod as Chmod;

class ChmodTest
{
	public function main() {

		$chmod = new Chmod();

		$chmod
			->setFile('/home/douglas/test')
			->setPermissions(0755)
			->setRecursive(true);
		$result = $chmod->execute();

		echo "Chmod'ed {$result->folders} folders and {$result->files} files.";

		return;
	}
}