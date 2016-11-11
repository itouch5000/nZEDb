<?php
namespace nzedb;

use nzedb\db\Settings;
use nzedb\utility\Misc;

/**
 * Class Uploads
 */
class Uploads
{
	// RAR/ZIP Passworded indicator.
	const PASSWD_NONE      = 0; // No password.
	const PASSWD_POTENTIAL = 1; // Might have a password.
	const BAD_FILE         = 2; // Possibly broken RAR/ZIP.
	const PASSWD_RAR       = 10; // Definitely passworded.

	/**
	 * @var \nzedb\db\Settings
	 */
	public $pdo;

	/**
	 * @var Groups
	 */
	public $groups;

	/**
	 * @var bool
	 */
	public $updategrabs;

	/**
	 * @var ReleaseSearch
	 */
	public $releaseSearch;

	/**
	 * @var SphinxSearch
	 */
	public $sphinxSearch;

	/**
	 * @var string
	 */
	public $showPasswords;

	/**
	 * @var array $options Class instances.
	 */
	public function __construct(array $options = [])
	{
		$defaults = [
			'Settings' => null,
			'Groups'   => null
		];
		$options += $defaults;

		$this->pdo = ($options['Settings'] instanceof Settings ? $options['Settings'] : new Settings());
		$this->groups = ($options['Groups'] instanceof Groups ? $options['Groups'] : new Groups(['Settings' => $this->pdo]));
		$this->updategrabs = ($this->pdo->getSetting('grabstatus') == '0' ? false : true);
		$this->passwordStatus = ($this->pdo->getSetting('checkpasswordedrar') == 1 ? -1 : 0);
		$this->sphinxSearch = new SphinxSearch();
		$this->releaseSearch = new ReleaseSearch($this->pdo, $this->sphinxSearch);
		$this->showPasswords = self::showPasswords($this->pdo);
	}

	public function getUploaderByReleaseName($releasename)
	{
		$qry = sprintf("SELECT * from uploads WHERE releasename = %s", $this->pdo->escapeString($releasename)):
		$uploader = $this->pdo->queryOneRow($qry);

		return $uploader;
	}

	public function updateStatus($releasename, $status, $guid = false)
	{
		$qry = sprintf("SELECT * from uploads WHERE releasename = %s", $this->pdo->escapeString($releasename)):
		$uploader = $this->pdo->queryOneRow($qry);

		return $uploader;
	}

}
