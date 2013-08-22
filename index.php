<?php
require_once('config.php');
$sql = "SELECT *
		FROM commands
		WHERE scenario_id = 1 AND event_id = 1";
$commands = $db->GetAll($sql);
$cmd_eventstarts = array();
$cmd_objects = array();
$cmd_characters = array();
foreach ($commands as $command)
{
	$cmd = unserialize($command['serialized_command']);
	$cmd->id = $command['id'];
	$cmd->scenario_id = $command['scenario_id'];
	$cmd->event_id = $command['event_id'];
	if ($cmd->category == 'eventstarts')
		$cmd_eventstarts[] = $cmd;
	if ($cmd->category == 'characters')
		$cmd_characters[] = $cmd;
}
// echo '<pre>'; print_r($cmd_characters); echo '</pre>';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>OpenSim Scenario Creator</title>
		<link type="text/css" href="css/style.css" rel="stylesheet" />
		<link type="text/css" href="css/jquery-ui.css" rel="stylesheet" />
		<link type="text/css" href="css/tooltipster.css" rel="stylesheet" />
		<link type="text/css" href="css/uniform.aristo.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
		<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
		<script type="text/javascript" src="js/options.js"></script>
		<script type="text/javascript" src="js/formize.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<div id="headercontent">
					<div id="logo">
						<a href="/">
							<img src="images/logo.png" alt="" />
						</a>
					</div>
					<div id="headerbuttons">
						<ul>
							<li><button type="button">Create Scenario</button></li>
							<li>
								<select name="scenarios">
									<option value="1">The Village</option>
								</select>
							</li>
						</ul>
					</div>
				</div>
			</div>
	
			<div id="main">
				<div id="titleblock">
					<div id="title"><h1>The Village</h1></div>
<!--
					<div id="titlebuttons">
						<ul>
							<li><a href="#">Create Event</a></li>
							<li><a href="#">Persist Action</a></li>
						</ul>
					</div>
-->
				</div>
	
				<div id="mainblock">
<!--
					<div id="events">
						<ul>
							<li><a href="#">Event 1<span class="hide">: The Introduction</span></a></li>
							<li><a href="#">Event 2<span class="hide">: Interview the People</span></a></li>
							<li><a href="#">Event 3<span class="hide">: Investigate the Lake</span></a></li>
							<li><a href="#">Event 4<span class="hide">: Talk to the Mayor</span></a></li>
							<li><a href="#">Event 5<span class="hide">: Explore the Mountains</span></a></li>
						</ul>
					</div>
-->
					<div id="maincontent">
						<h2>Event 1: The Introduction</h2>
						<div id="left">
							<div id="tabs">
								<ul>
									<li><a href="#startblock">When event starts</a></li>
									<li><a href="#objectsblock">Objects</a></li>
									<li><a href="#charactersblock">Characters</a></li>
								</ul>

								<!-- "When event starts" only has outcomes. -->
								<div id="startblock" class="optionblock">
									<div class="options">
										<ul class="optionlist sortable">
<?php
										foreach ($cmd_eventstarts as $cmd)
										{
?>
											<li>
												<div class="icons">
													<a class="openmenu" data-id="<?= $cmd->id ?>" href="#"><img src="images/edit-command.png" alt="menu" /></a>
												</div>
												<div class="eventstarts optionrow" data-id="<?= $cmd->id ?>">
													<div class="command_data">
														<span data-word="id" data-id="<?= $cmd->id ?>"></span>
													</div>
<?php
											if (!empty($cmd->condition))
											{
												echo '
													<div class="condition">
														<span class="conjunction">If</span>
												';

												foreach ($cmd->condition as $cond)
												{
													echo '
															<span data-word="' . $cond['word_type'] . '" data-text="' . $cond['text'] . '" data-id="' . $cond['option_id'] . '">' . $cond['text'] . '</span>
													';
												}

												echo '
													</div>
												';
											}

											if (!empty($cmd->outcomes))
											{
												foreach ($cmd->outcomes as $index_outcomes => $outcomes)
												{
													echo '
														<div class="outcome">
													';

													if ($index_outcomes == 0 && !empty($cmd->condition))
													{
														echo '
															<span class="then">then</span>
														';
													}
													else if ($index_outcomes > 0 && !empty($cmd->condition))
													{
														echo '
															<span class="and">and</span>
														';
													}

													foreach ($outcomes as $out)
													{
														echo '
															<span data-word="' . $out['word_type'] . '" data-text="' . $out['text'] . '" data-id="' . $out['option_id'] . '">' . $out['text'] . '</span>
														';
													}

													echo '
														</div>
													';
												}
											}
?>
												</div>
											</li>
<?php
										}
?>
										</ul>

										<div class="buttons">
											<span class="add">Add</span>
										</div>
									</div>
								</div>

								<div id="objectsblock" class="optionblock">
									<div class="options">
										<ul class="optionlist sortable">
											<li>
												<div class="objects optionrow">
													<div class="condition" style="display: inline">
														<span class="conjunction">If</span>
														<span data-word="object">Banana</span>
														<span data-word="verb_condition">detects character</span>
														<span data-word="character">Frank</span>
													</div>
		
													<div class="outcome" style="display: inline;">
														<span class="then">then</span>
														<span data-word="verb_outcome">tell player</span>
														<span data-word="textbox">Don't come near the banana!</span>
														<span data-word="textbox" class="linked">Go away!</span>
													</div>
												</div>
											</li>
		
											<li class="zebra">
												<div class="objects optionrow">
													<div class="condition" style="display: inline;">
														<span class="conjunction">If</span>
														<span data-word="object">Motorcycle</span>
														<span data-word="verb_condition">is touched</span>
													</div>

													<div class="outcome" style="display: inline;">
														<span class="then">then</span>
														<span data-word="verb_outcome">animate character</span>
														<span data-word="character">Frank</span>
														<span data-word="animation">high-five</span>
													</div>
												</div>
											</li>

											<li>
												<div class="characters optionrow">
													<div class="condition" style="display: inline">
														<span class="conjunction">If</span>
														<span data-word="object">Banana</span>
														<span data-word="verb_condition">detects character</span>
														<span data-word="character">Frank</span>
													</div>
		
													<div class="outcome" style="display: inline;">
														<span class="then">then</span>
														<span data-word="verb_outcome">tell player</span>
														<span data-word="textbox">Don't come near the banana!</span>
														<span data-word="textbox" class="linked">Go away!</span>
													</div>
												</div>
											</li>

											<li>
												<div class="characters optionrow">
													<div class="action" style="display: inline">
														<span class="add" href="">+</span>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
		
								<div id="charactersblock" class="optionblock">
									<div class="options">
										<ul class="optionlist sortable">
<?php
										foreach ($cmd_characters as $cmd)
										{
?>
											<li>
												<div class="icons">
													<a class="openmenu" data-id="<?= $cmd->id ?>" href="#"><img src="images/edit-command.png" alt="menu" /></a>
												</div>
												<div class="characters optionrow" data-id="<?= $cmd->id ?>">
													<div class="command_data">
														<span data-word="id" data-id="<?= $cmd->id ?>"></span>
													</div>
<?php
											if (!empty($cmd->condition))
											{
												echo '
													<div class="condition">
														<span class="conjunction">If</span>
												';

												foreach ($cmd->condition as $cond)
												{
													echo '
															<span data-word="' . $cond['word_type'] . '" data-text="' . $cond['text'] . '" data-id="' . $cond['option_id'] . '">' . $cond['text'] . '</span>
													';
												}

												echo '
													</div>
												';
											}

											if (!empty($cmd->outcomes))
											{
												foreach ($cmd->outcomes as $index_outcomes => $outcomes)
												{
													echo '
														<div class="outcome">
													';

													if ($index_outcomes == 0 && !empty($cmd->condition))
													{
														echo '
															<span class="then">then</span>
														';
													}
													else if ($index_outcomes > 0 && !empty($cmd->condition))
													{
														echo '
															<span class="and">and</span>
														';
													}

													foreach ($outcomes as $out)
													{
														echo '
															<span data-word="' . $out['word_type'] . '" data-text="' . $out['text'] . '" data-id="' . $out['option_id'] . '">' . $out['text'] . '</span>
														';
													}

													echo '
														</div>
													';
												}
											}
?>
												</div>
											</li>
<?php
										}
?>
										</ul>

										<div class="buttons">
											<span class="add">Add</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div id="right">
						</div>
						
						<div class="clear"></div>
					</div>
				</div>
			</div>

			<div id="footer"></div>
		</div>
		<script type="text/javascript" src="js/page.js"></script>
	</body>
</html>