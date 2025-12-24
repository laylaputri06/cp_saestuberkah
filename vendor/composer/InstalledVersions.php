Jobs();
}










public function execute($command, &$output = null, ?string $cwd = null): int
{
if (func_num_args() > 1) {
return $this->doExecute($command, $cwd, false, $output);
}

return $this->doExecute($command, $cwd, false);
}








public function executeTty($command, ?string $cwd = null): int
{
if (Platform::isTty()) {
return $this->doExecute($command, $cwd, true);
}

return $this->doExecute($command, $cwd, false);
}






private function runProcess($command, ?string $cwd, ?array $env, bool $tty, &$output = null): ?int
{



if (is_string($command)) {
if (Platform::isWindows() && Preg::isMatch('{^([^:/\\\\]++) }', $command, $match)) {
$command = substr_replace($command, self::escape(self::getExecutable($match[1])), 0, strlen($match[1]));
}

$process = Process::fromShellCommandline($command, $cwd, $env, null, static::getTimeout());
} else {
if (Platform::isWindows() && \strlen($command[0]) === strcspn($command[0], ':/\\')) {
$command[0] = self::getExecutable($command[0]);
}

$process = new Process($command, $cwd, $env, null, static::getTimeout());
}

if (!Platform::isWindows() && $tty) {
try {
$process->setTty(true);
} catch (RuntimeException $e) {

}
}

$callback = is_callable($output) ? $output : function (string $type, string $buffer): void {
$this->outputHandler($type, $buffer);
};

$signalHandler = SignalHandler::create(
[SignalHandler::SIGINT, SignalHandler::SIGTERM, SignalHandler::SIGHUP],
function (string $signal) {
if ($this->io !== null) {
$this->io->writeError(
'Received '.$signal.', aborting when child process is done',
true,
IOInterface::DEBUG
);
}
}
);

try {
$process->run($callback);

if ($this->captureOutput && !is_callable($output)) {
$output = $process->getOutput();
}

$this->errorOutput = $process->getErrorOutput();
} catch (ProcessSignaledException $e) {
if ($signalHandler->isTriggered()) {

$signalHandler->exitWithLastSignal();
}
} finally {
$signalHandler->unregister();
}

return $process->getExitCode();
}





private function doExecute($command, ?string $cwd, bool $tty, &$output = null): int
{
$this->outputCommandRun($command, $cwd, false);

$this->captureOutput = func_num_args() > 3;
$this->errorOutput = '';

$env = null;

$requiresGitDirEnv = $this->requiresGitDirEnv($command);
if ($cwd !== null && $requiresGitDirEnv) {
$isBareRepository = !is_dir(sprintf('%s/.git', rtrim($cwd, '/')));
if ($isBareRepository) {
$configValue = '';
$this->runProcess(['git', 'config', 'safe.bareRepository'], $cwd, ['GIT_DIR' => $cwd], $tty, $configValue);
$configValue = trim($configValue);
if ($configValue === 'explicit') {
$env = ['GIT_DIR' => $cwd];
}
}
}

return $this->runProcess($command, $cwd, $env, $tty, $output);
}








public function executeAsync($command, ?string $cwd = null): PromiseInterface
{
if (!$this->allowAsync) {
throw new \LogicException('You must use the ProcessExecutor instance which is part of a Composer\Loop instance to be able to run async processes');
}

$job = [
'id' => $this->idGen++,
'status' => self::STATUS_QUEUED,
'command' => $command,
'cwd' => $cwd,
];

$resolver = static function ($resolve, $reject) use (&$job): void {
$job['status'] = ProcessExecutor::STATUS_QUEUED;
$job['resolve'] = $resolve;
$job['reject'] = $reject;
};

$canceler = static function () use (&$job): void {
if ($job['status'] === ProcessExecutor::STATUS_QUEUED) {
$job['status'] = ProcessExecutor::STATUS_ABORTED;
}
if ($job['status'] !== ProcessExecutor::STATUS_STARTED) {
return;
}
$job['status'] = ProcessExecutor::STATUS_ABORTED;
try {
if (defined('SIGINT')) {
$job['process']->signal(SIGINT);
}
} catch (\Exception $e) {

}
$job['process']->stop(1);

throw new \RuntimeException('Aborted process');
};

$promise = new Promise($resolver, $canceler);
$promise = $promise->then(function () use (&$job) {
if ($job['process']->isSuccessful()) {
$job['status'] = ProcessExecutor::STATUS_COMPLETED;
} else {
$job['status'] = ProcessExecutor::STATUS_FAILED;
}

$this->markJobDone();

return $job['process'];
}, function ($e) use (&$job): void {
$job['status'] = ProcessExecutor::STATUS_FAILED;

$this->markJobDone();

throw $e;
});
$this->jobs[$job['id']] = &$job;

if ($this->runningJobs < $this->maxJobs) {
$this->startJob($job['id']);
}

return $promise;
}

protected function outputHandler(string $type, string $buffer): void
{
if ($this->captureOutput) {
return;
}

if (null === $this->io) {
echo $buffer;

return;
}

if (Process::ERR === $type) {
$this->io->writeErrorRaw($buffer, false);
} else {
$this->io->writeRaw($buffer, false);
}
}

private function startJob(int $id): void
{
$job = &$this->jobs[$id];
if ($job['status'] !== self::STATUS_QUEUED) {
return;
}


$job['status'] = self::STATUS_STARTED;
$this->runningJobs++;

$command = $job['command'];
$cwd = $job['cwd'];

$this->outputCommandRun($command, $cwd, true);

try {
if (is_string($command)) {
$process = Process::fromShellCommandline($command, $cwd, null, null, static::getTimeout());
} else {
$process = new Process($command, $cwd, null, null, static::getTimeout());
}
} catch (\Throwable $e) {
$job['reject']($e);

return;
}

$job['process'] = $process;

try {
$process->start();
} catch (\Throwable $e) {
$job['reject']($e);

return;
}
}

public function setMaxJobs(int $maxJobs): void
{
$this->maxJobs = $maxJobs;
}

public function resetMaxJobs(): void
{
if (is_numeric($maxJobs = Platform::getEnv('COMPOSER_MAX_PARALLEL_PROCESSES'))) {
$this->maxJobs = max(1, min(50, (int) $maxJobs));
} else {
$this->maxJobs = 10;
}
}




public function wait($index = null): void
{
while (true) {
if (0 === $this->countActiveJobs($index)) {
return;
}

usleep(1000);
}
}




public function enableAsync(): void
{
$this->allowAsync = true;
}







public function countActiveJobs($index = null): int
{

foreach ($this->jobs as $job) {
if ($job['status'] === self::STATUS_STARTED) {
if (!$job['process']->isRunning()) {
call_user_func($job['resolve'], $job['process']);
}

$job['process']->checkTimeout();
}

if ($this->runningJobs < $this->maxJobs) {
if ($job['status'] === self::STATUS_QUEUED) {
$this->startJob($job['id']);
}
}
}

if (null !== $index) {
return $this->jobs[$index]['status'] < self::STATUS_COMPLETED ? 1 : 0;
}

$active = 0;
foreach ($this->jobs as $job) {
if ($job['status'] < self::STATUS_COMPLETED) {
$active++;
} else {
unset($this->jobs[$job['id']]);
}
}

return $active;
}

private function markJobDone(): void
{
$this->runningJobs--;
}




public function splitLines(?string $output): array
{
$output = trim((string) $output);

return $output === '' ? [] : Preg::split('{\r?\n}', $output);
}




public function getErrorOutput(): string
{
return $this->errorOutput;
}




public static function getTimeout(): int
{
return static::$timeout;
}




public static function setTimeout(int $timeout): void
{
static::$timeout = $timeout;
}








public static function escape($argument): string
{
return self::escapeArgument($argument);
}




private function outputCommandRun($command, ?string $cwd, bool $async): void
{
if (null === $this->io || !$this->io->isDebug()) {
return;
}

$commandString = is_string($command) ? $command : implode(' ', array_map(self::class.'::escape', $command));
$safeCommand = Preg::replaceCallback('{://(?P<user>[^:/\s]+):(?P<password>[^@\s/]+)@}i', static function ($m): string {

if (Preg::isMatch(GitHub::GITHUB_TOKEN_REGEX, $m['user'])) {
return '://***:***@';
}
if (Preg::isMatch('{^[a-f0-9]{12,}$}', $m['user'])) {
return '://***:***@';
}

return '://'.$m['user'].':***@';
}, $commandString);
$safeCommand = Preg::replace("{--password (.*[^\\\\]\') }", '--password \'***\' ', $safeCommand);
$this->io->writeError('Executing'.($async ? ' async' : '').' command ('.($cwd ?: 'CWD').'): '.$safeCommand);
}














private static function escapeArgument($argument): string
{
if ('' === ($argument = (string) $argument)) {
return escapeshellarg($argument);
}

if (!Platform::isWindows()) {
return "'".str_replace("'", "'\\''", $argument)."'";
}




$argument = strtr($argument, [
"\n" => ' ',
"\u{ff02}" => '"',
"\u{02ba}" => '"',
"\u{301d}" => '"',
"\u{301e}" => '"',
"\u{030e}" => '"',
"\u{ff1a}" => ':',
"\u{0589}" => ':',
"\u{2236}" => ':',
"\u{ff0f}" => '/',
"\u{2044}" => '/',
"\u{2215}" => '/',
"\u{00b4}" => '/',
]);


$quote = strpbrk($argument, " \t,") !== false;
$argument = Preg::replace('/(\\\\*)"/', '$1$1\\"', $argument, -1, $dquotes);
$meta = $dquotes > 0 || Preg::isMatch('/%[^%]+%|![^!]+!/', $argument);

if (!$meta && !$quote) {
$quote = strpbrk($argument, '^&|<>()') !== false;
}

if ($quote) {
$argument = '"'.Preg::replace('/(\\\\*)$/', '$1$1', $argument).'"';
}

if ($meta) {
$argument = Preg::replace('/(["^&|<>()%])/', '^$1', $argument);
$argument = Preg::replace('/(!)/', '^^$1', $argument);
}

return $argument;
}




public function requiresGitDirEnv($command): bool
{
$cmd = !is_array($command) ? explode(' ', $command) : $command;
if ($cmd[0] !== 'git') {
return false;
}

foreach (self::GIT_CMDS_NEED_GIT_DIR as $gitCmd) {
if (array_intersect($cmd, $gitCmd) === $gitCmd) {
return true;
}
}

return false;
}




private static function getExecutable(string $name): string
{
if (\in_array(strtolower($name), self::BUILTIN_CMD_COMMANDS, true)) {
return $name;
}

if (!isset(self::$executables[$name])) {
$path = (new ExecutableFinder())->find($name, $name);
if ($path !== null) {
self::$executables[$name] = $path;
}
}

return self::$executables[$name] ?? $name;
}
}
<?php declare(strict_types=1);











namespace Composer\Util;

use Closure;
use Composer\Config;
use Composer\Downloader\MaxFileSizeExceededException;
use Composer\IO\IOInterface;
use Composer\Downloader\TransportException;
use Composer\Pcre\Preg;
use Composer\Util\Http\Response;
use Composer\Util\Http\ProxyManager;







class RemoteFilesystem
{

private $io;

private $config;

private $scheme;

private $bytesMax;

private $originUrl;

private $fileUrl;

private $fileName;

private $retry = false;

private $progress;

private $lastProgress;

private $options = [];

private $disableTls = false;

private $lastHeaders;

private $storeAuth = false;

private $authHelper;

private $degradedMode = false;

private $redirects;

private $maxRedirects = 20;








public function __construct(IOInterface $io, Config $config, array $options = [], bool $disableTls = false, ?AuthHelper $authHelper = null)
{
$this->io = $io;



if ($disableTls === false) {
$this->options = StreamContextFactory::getTlsDefaults($options, $io);
} else {
$this->disableTls = true;
}


$this->options = array_replace_recursive($this->options, $options);
$this->config = $config;
$this->authHelper = $authHelper ?? new AuthHelper($io, $config);
}












public function copy(string $originUrl, string $fileUrl, string $fileName, bool $progress = true, array $options = [])
{
return $this->get($originUrl, $fileUrl, $options, $fileName, $progress);
}











public function getContents(string $originUrl, string $fileUrl, bool $progress = true, array $options = [])
{
return $this->get($originUrl, $fileUrl, $options, null, $progress);
}






public function getOptions()
{
return $this->options;
}







public function setOptions(array $options)
{
$this->options = array_replace_recursive($this->options, $options);
}






public function isTlsDisabled()
{
return $this->disableTls === true;
}






public function getLastHeaders()
{
return $this->lastHeaders;
}





public static function findStatusCode(array $headers)
{
$value = null;
foreach ($headers as $header) {
if (Preg::isMatch('{^HTTP/\S+ (\d+)}i', $header, $match)) {


$value = (int) $match[1];
}
}

return $value;
}





public function findStatusMessage(array $headers)
{
$value = null;
foreach ($headers as $header) {
if (Preg::isMatch('{^HTTP/\S+ \d+}i', $header)) {


$value = $header;
}
}

return $value;
}















protected function get(string $originUrl, string $fileUrl, array $additionalOptions = [], ?string $fileName = null, bool $progress = true)
{
$this->scheme = parse_url(strtr($fileUrl, '\\', '/'), PHP_URL_SCHEME);
$this->bytesMax = 0;
$this->originUrl = $originUrl;
$this->fileUrl = $fileUrl;
$this->fileName = $fileName;
$this->progress = $progress;
$this->lastProgress = null;
$retryAuthFailure = true;
$this->lastHeaders = [];
$this->redirects = 1; 

$tempAdditionalOptions = $additionalOptions;
if (isset($tempAdditionalOptions['retry-auth-failure'])) {
$retryAuthFailure = (bool) $tempAdditionalOptions['retry-auth-failure'];

unset($tempAdditionalOptions['retry-auth-failure']);
}

$isRedirect = false;
if (isset($tempAdditionalOptions['redirects'])) {
$this->redirects = $tempAdditionalOptions['redirects'];
$isRedirect = true;

unset($tempAdditionalOptions['redirects']);
}

$options = $this->getOptionsForUrl($originUrl, $tempAdditionalOptions);
unset($tempAdditionalOptions);

$origFileUrl = $fileUrl;

if (isset($options['prevent_ip_access_callable'])) {
throw new \RuntimeException("RemoteFilesystem doesn't support the 'prevent_ip_access_callable' config.");
}

if (isset($options['gitlab-token'])) {
$fileUrl .= (false === strpos($fileUrl, '?') ? '?' : '&') . 'access_token='.$options['gitlab-token'];
unset($options['gitlab-token']);
}

if (isset($options['http'])) {
$options['http']['ignore_errors'] = true;
}

if ($this->degradedMode && strpos($fileUrl, 'http://repo.packagist.org/') === 0) {

$fileUrl = 'http://' . gethostbyname('repo.packagist.org') . substr($fileUrl, 20);
$degradedPackagist = true;
}

$maxFileSize = null;
if (isset($options['max_file_size'])) {
$maxFileSize = $options['max_file_size'];
unset($options['max_file_size']);
}

$ctx = StreamContextFactory::getContext($fileUrl, $options, ['notification' => Closure::fromCallable([$this, 'callbackGet'])]);

$proxy = ProxyManager::getInstance()->getProxyForRequest($fileUrl);
$usingProxy = $proxy->getStatus(' using proxy (%s)');
$this->io->writeError((strpos($origFileUrl, 'http') === 0 ? 'Downloading ' : 'Reading ') . Url::sanitize($origFileUrl) . $usingProxy, true, IOInterface::DEBUG);
unset($origFileUrl, $proxy, $usingProxy);


if ((!Preg::isMatch('{^http://(repo\.)?packagist\.org/p/}', $fileUrl) || (false === strpos($fileUrl, '$') && false === strpos($fileUrl, '%24'))) && empty($degradedPackagist)) {
$this->config->prohibitUrlByConfig($fileUrl, $this->io);
}

if ($this->progress && !$isRedirect) {
$this->io->writeError("Downloading (<comment>connecting...</comment>)", false);
}

$errorMessage = '';
$errorCode = 0;
$result = false;
set_error_handler(static function ($code, $msg) use (&$errorMessage): bool {
if ($errorMessage) {
$errorMessage .= "\n";
}
$errorMessage .= Preg::replace('{^file_get_contents\(.*?\): }', '', $msg);

return true;
});
$http_response_header = [];
try {
$result = $this->getRemoteContents($originUrl, $fileUrl, $ctx, $http_response_header, $maxFileSize);

if (!empty($http_response_header[0])) {
$statusCode = self::findStatusCode($http_response_header);
if ($statusCode >= 300 && Response::findHeaderValue($http_response_header, 'content-type') === 'application/json') {
HttpDownloader::outputWarnings($this->io, $originUrl, json_decode($result, true));
}

if (in_array($statusCode, [401, 403]) && $retryAuthFailure) {
$this->promptAuthAndRetry($statusCode, $this->findStatusMessage($http_response_header), $http_response_header);
}
}

$contentLength = !empty($http_response_header[0]) ? Response::findHeaderValue($http_response_header, 'content-length') : null;
if ($contentLength && Platform::strlen($result) < $contentLength) {

$e = new TransportException('Content-Length mismatch, received '.Platform::strlen($result).' bytes out of the expected '.$contentLength);
$e->setHeaders($http_response_header);
$e->setStatusCode(self::findStatusCode($http_response_header));
try {
$e->setResponse($this->decodeResult($result, $http_response_header));
} catch (\Exception $discarded) {
$e->setResponse($this->normalizeResult($result));
}

$this->io->writeError('Content-Length mismatch, received '.Platform::strlen($result).' out of '.$contentLength.' bytes: (' . base64_encode($result).')', true, IOInterface::DEBUG);

throw $e;
}
} catch (\Exception $e) {
if ($e instanceof TransportException && !empty($http_response_header[0])) {
$e->setHeaders($http_response_header);
$e->setStatusCode(self::findStatusCode($http_response_header));
}
if ($e instanceof TransportException && $result !== false) {
$e->setResponse($this->decodeResult($result, $http_response_header));
}
$result = false;
}
if ($errorMessage && !filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOLEAN)) {
$errorMessage = 'allow_url_fopen must be enabled in php.ini ('.$errorMessage.')';
}
restore_error_handler();
if (isset($e) && !$this->retry) {
if (!$this->degradedMode && false !== strpos($e->getMessage(), 'Operation timed out')) {
$this->degradedMode = true;
$this->io->writeError('');
$this->io->writeError([
'<error>'.$e->getMessage().'</error>',
'<error>Retrying with degraded mode, check https://getcomposer.org/doc/articles/troubleshooting.md#degraded-mode for more info</error>',
]);

return $this->get($this->originUrl, $this->fileUrl, $additionalOptions, $this->fileName, $this->progress);
}

throw $e;
}

$statusCode = null;
$contentType = null;
$locationHeader = null;
if (!empty($http_response_header[0])) {
$statusCode = self::findStatusCode($http_response_header);
$contentType = Response::findHeaderValue($http_response_header, 'content-type');
$locationHeader = Response::findHeaderValue($ht