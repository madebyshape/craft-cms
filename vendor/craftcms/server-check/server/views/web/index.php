<?php
/* @var $this RequirementsChecker */
/* @var $summary array */
/* @var $requirements array[] */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Craft Requirements Checker</title>
	<?php $this->renderViewFile(__DIR__.'/css.php'); ?>
</head>
<body>
<div class="container">
	<div class="header">
		<h1>Craft Requirements Checker</h1>
	</div>
	<hr>

	<div class="content">
		<h3>Description</h3>
		<p>
			This script checks if your server configuration meets the requirements for running a Craft installation.
			It checks if the server is running the right version of PHP, if appropriate PHP extensions have been loaded, and if php.ini file settings are correct.
			If database credentials are supplied in db.php, the script will also performs some database checks as well.
		</p>
		<p>
			There are two kinds of requirements being checked. Mandatory requirements are those that have to be met
			to allow Craft to work as expected. There are also some optional requirements being checked which will
			show you a warning when they do not meet. You can use Craft without them but some specific
			functionality may be not available in this case.
		</p>

		<h3>Results</h3>
		<?php if ($summary['errors'] > 0): ?>
			<div class="alert alert-danger">
				<strong>Unfortunately your server configuration does not meet the requirements to run Craft.<br>Please refer to the table below for detailed explanation.</strong>
			</div>
		<?php elseif ($summary['warnings'] > 0): ?>
			<div class="alert alert-info">
				<strong>Your server configuration meet the minimum requirements to run Craft.<br>Please pay attention to the warnings listed below and check if your site will use the corresponding features.</strong>
			</div>
		<?php else: ?>
			<div class="alert alert-success">
				<strong>Congratulations! Your server configuration can run Craft!</strong>
			</div>
		<?php endif; ?>

		<h3>Details</h3>

		<table class="table table-bordered">
			<tr><th>Name</th><th>Result</th><th>Memo</th></tr>
			<?php foreach ($requirements as $requirement): ?>
			<tr class="<?php echo $requirement['condition'] ? 'success' : ($requirement['mandatory'] ? 'danger' : 'warning') ?>">
				<td>
				<?php echo $requirement['name'] ?>
				</td>
				<td>
				<span class="result"><?php echo $requirement['condition'] ? 'Passed' : ($requirement['mandatory'] ? 'Failed' : 'Warning') ?></span>
				</td>
				<td>
				<?php echo $requirement['memo'] ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>

	</div>

	<hr>

	<div class="footer">
		<p>Server: <?php echo $this->getServerInfo().' '.$this->getCurrentDate() ?></p>
		<p>Powered by <a href="https://craftcms.com/" rel="external">Craft</a></p>
	</div>
</div>
</body>
</html>
