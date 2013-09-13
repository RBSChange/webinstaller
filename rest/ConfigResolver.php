<?php

/**
 * @name ConfigResolver
 */
class ConfigResolver
{
	const RESOLVER_NAME = 'config';
	const DEFAULT_MYSQL_PORT = 3306;
	const DEFAULT_MYSQL_HOST = '127.0.0.1';
	const DEFAULT_SQLITE_FILE = 'Sqlite.db';

	/**
	 * @param \Change\Http\Rest\Resolver $resolver
	 */
	protected $resolver;

	/**
	 * @param \Change\Http\Rest\Resolver $resolver
	 */
	function __construct($resolver)
	{
		$this->resolver = $resolver;
	}

	/**
	 * Set Event params: resourcesActionName, documentId, LCID
	 * @param \Change\Http\Event $event
	 * @param array $resourceParts
	 * @param $method
	 * @return void
	 */
	public function resolve($event, $resourceParts, $method)
	{
		$nbParts = count($resourceParts);
		if ($nbParts == 1 && $method === Change\Http\Rest\Request::METHOD_GET && $resourceParts[0] === 'setDbConfig')
		{
			$event->setAction(array($this, 'setDbConfig'));
			return;
		}
	}


	/**
	 * @param \Change\Http\Event $event
	 */
	public function setDbConfig(\Change\Http\Event $event)
	{
		$application = $event->getApplicationServices()->getApplication();
		$editConfig = new \Change\Configuration\EditableConfiguration(array());
		$editConfig->import($application->getConfiguration());

		$dbType = $event->getRequest()->getQuery('type', 'mysql');
		if ($dbType === 'sqlite')
		{
			$editConfig->addPersistentEntry('Change/Db/use', 'sqlite', \Change\Configuration\EditableConfiguration::INSTANCE);
			$file = $event->getRequest()->getQuery('file', self::DEFAULT_SQLITE_FILE);
			$onWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
			$absolute = substr($file, 0, 1) === DIRECTORY_SEPARATOR || ($onWindows && preg_match('/^[A-Z]:\/\//i', $file));
			if (! $absolute)
			{
				$file = $application->getWorkspace()->appPath($file);
			}
			$editConfig->addPersistentEntry('Change/Db/sqlite/database', $file, \Change\Configuration\EditableConfiguration::INSTANCE);
		}
		else
		{
			$editConfig->addPersistentEntry('Change/Db/use', 'default', \Change\Configuration\EditableConfiguration::INSTANCE);
			$params = array(
				'database' => null,
				'user' => null,
				'password' => null,
				'host' => self::DEFAULT_MYSQL_HOST,
				'port' => self::DEFAULT_MYSQL_PORT
			);
			foreach ($params as $name => $default)
			{
				$editConfig->addPersistentEntry('Change/Db/default/' . $name, $event->getRequest()->getQuery($name, $default), \Change\Configuration\EditableConfiguration::INSTANCE);
			}
		}
		$editConfig->save();

		$result = new \Change\Http\Rest\Result\ArrayResult();
		$result->setArray(array());
		$result->setHttpStatusCode(\Zend\Http\Response::STATUS_CODE_200);
		$event->setResult($result);
	}

}