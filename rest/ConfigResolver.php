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
	const TEST_CREATE_TABLE_NAME = 'test_rbs_change4';

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
		if ($nbParts == 1 && $method === Change\Http\Rest\Request::METHOD_GET)
		{
			if ($resourceParts[0] === 'setDbConfig')
			{
				$event->setAction(array($this, 'setDbConfig'));
			}
			elseif ($resourceParts[0] === 'checkDbConfig')
			{
				$event->setAction(array($this, 'checkDbConfig'));
			}
			return;
		}
	}


	/**
	 * @param \Change\Http\Event $event
	 */
	public function setDbConfig(\Change\Http\Event $event)
	{
		$request = $event->getRequest();
		$application = $event->getApplicationServices()->getApplication();
		$editConfig = new \Change\Configuration\EditableConfiguration(array());
		$editConfig->import($application->getConfiguration());

		$dbType = $event->getRequest()->getQuery('type', 'mysql');
		if ($dbType === 'sqlite')
		{
			$editConfig->addPersistentEntry('Change/Db/use', 'sqlite', \Change\Configuration\EditableConfiguration::PROJECT);
			$file = $request->getQuery('file', self::DEFAULT_SQLITE_FILE);
			$onWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
			$absolute = substr($file, 0, 1) === DIRECTORY_SEPARATOR || ($onWindows && preg_match('/^[A-Z]:\/\//i', $file));
			if (! $absolute)
			{
				$file = $application->getWorkspace()->appPath($file);
			}
			$editConfig->addPersistentEntry('Change/Db/sqlite/database', $file, \Change\Configuration\EditableConfiguration::PROJECT);
		}
		else
		{
			$editConfig->addPersistentEntry('Change/Db/use', 'default', \Change\Configuration\EditableConfiguration::PROJECT);
			$editConfig->addPersistentEntry('Change/Db/default/host', $request->getQuery('host', self::DEFAULT_MYSQL_HOST), \Change\Configuration\EditableConfiguration::PROJECT);
			$editConfig->addPersistentEntry('Change/Db/default/port', $request->getQuery('port', self::DEFAULT_MYSQL_PORT), \Change\Configuration\EditableConfiguration::PROJECT);
			$editConfig->addPersistentEntry('Change/Db/default/user', $request->getQuery('user'), \Change\Configuration\EditableConfiguration::PROJECT);
			$editConfig->addPersistentEntry('Change/Db/default/password', $request->getQuery('password'), \Change\Configuration\EditableConfiguration::PROJECT);
			$databaseName = $this->fixDatabaseName($request->getQuery('database'));
			$editConfig->addPersistentEntry('Change/Db/default/database', $databaseName);
		}
		$editConfig->save();

		$result = new \Change\Http\Rest\Result\ArrayResult();
		$result->setArray(array());
		$result->setHttpStatusCode(\Zend\Http\Response::STATUS_CODE_200);
		$event->setResult($result);
	}


	/**
	 * @param \Change\Http\Event $event
	 */
	public function checkDbConfig(\Change\Http\Event $event)
	{
		$request = $event->getRequest();
		$application = $event->getApplicationServices()->getApplication();
		$config = $application->getConfiguration();

		$dbType = $request->getQuery('type', 'mysql');
		if ($dbType === 'sqlite')
		{
			$config->addVolatileEntry('Change/Db/use', 'sqlite');
			$file = $request->getQuery('file', self::DEFAULT_SQLITE_FILE);
			$onWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
			$absolute = substr($file, 0, 1) === DIRECTORY_SEPARATOR || ($onWindows && preg_match('/^[A-Z]:\/\//i', $file));
			if (! $absolute)
			{
				$file = $application->getWorkspace()->appPath($file);
			}
			$config->addVolatileEntry('Change/Db/sqlite/database', $file);
		}
		else
		{
			$config->addVolatileEntry('Change/Db/use', 'default');
			$config->addVolatileEntry('Change/Db/default/host', $request->getQuery('host', self::DEFAULT_MYSQL_HOST));
			$config->addVolatileEntry('Change/Db/default/port', $request->getQuery('port', self::DEFAULT_MYSQL_PORT));
			$config->addVolatileEntry('Change/Db/default/user', preg_replace('/[^a-z0-9\-_]/i', '_', $request->getQuery('user')));
			$config->addVolatileEntry('Change/Db/default/password', $request->getQuery('password'));
		}

		// Try to create the database.
		try
		{
			// We use directly PDO here because we need a special connection string without a database name.
			$pdo = new PDO(
				$dbType . ':host=' . $config->getEntry('Change/Db/default/host') . ';port=' . $config->getEntry('Change/Db/default/port'),
				$config->getEntry('Change/Db/default/user'),
				$config->getEntry('Change/Db/default/password'),
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
			);
			$databaseName = $this->fixDatabaseName($request->getQuery('database'));
			$query = "CREATE DATABASE IF NOT EXISTS " . $databaseName . " DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
			$pdo->prepare($query)->execute();

			// Database exists: we can register its name in the configuration.
			$config->addVolatileEntry('Change/Db/default/database', $databaseName);

			$applicationServices = new \Change\Application\ApplicationServices($application);
			$dbProvider = $applicationServices->getDbProvider();
			$dbProvider->setLogging($applicationServices->getLogging());
			$schema = $dbProvider->getSchemaManager();
			$table = $schema->newTableDefinition(self::TEST_CREATE_TABLE_NAME);
			$table->addField($schema->newIntegerFieldDefinition('test_id'));
			$schema->createTable($table);
			$schema->execute('DROP TABLE ' . self::TEST_CREATE_TABLE_NAME);

			$result = new \Change\Http\Rest\Result\ArrayResult();
			$result->setArray(array('status' => 'ok'));
			$result->setHttpStatusCode(\Zend\Http\Response::STATUS_CODE_200);
			$event->setResult($result);
		}
		catch (RuntimeException $e)
		{
			$result = new \Change\Http\Rest\Result\ArrayResult();
			$result->setArray(array('status' => 'error', 'error' => $e->getMessage()));
			$result->setHttpStatusCode(\Zend\Http\Response::STATUS_CODE_200);
			$event->setResult($result);
		}

	}

	/**
	 * @param $dbName
	 * @return mixed
	 */
	protected function fixDatabaseName($dbName)
	{
		return preg_replace('/[^a-z0-9\-_\.]/i', '_', $dbName);
	}

}