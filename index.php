<?php

error_reporting(0);

// include required class files.
require_once 'classes/limonade.php';
require_once 'classes/tropo.class.php';

// Route for the initial caller dialog.
dispatch_post('start', 'tropoStart');
function tropoStart() {
	
	$tropo = new Tropo();	
	$tropo->say("Welcome to the tropo orchestra example.", array("barge" => false));
	$tropo->ask("What is your favoirte programming language?", array("attempts" => 3,"choices" => "PHP, Ruby, JavaScript, Python", "name" => "language", "timeout" => 5));
	$tropo->on(array("event" => "continue", "next" => "index?uri=end", "say" => "Please hold."));
	$tropo->on(array("event" => "error", "next" => "index?uri=error", "say" => "An error has occured."));
	$tropo->renderJSON();
	
}

// Route for the final caler dialog.
dispatch_post('end', 'tropoEnd');
function tropoEnd() {
	
	$result = new Result();
	$selection = $result->getValue();	
	
	$tropo = new Tropo();
	
	switch($selection) {
		
		case 'PHP':
			$toSay = "PHP is the shiz nit.";
			break;
			
		case 'Ruby':
			$toSay = "I have nothing against Ruby.";
			break;
			
		case 'Javascript':
			$toSay = "Javascript is mighty fine.";
			break;
			
		case 'Python':
			$toSay = "Python is for lovers.";
		
	}
	
	$tropo->say("You chose, " . $selection);	
	$tropo->say($toSay);	
	$tropo->say("Thanks for playing along. Goodbye");	
	$tropo->hangup();	
	$tropo->renderJSON();

}

// Route for an error dialog.
dispatch_post('error', 'tropoError');
function tropoError() {
	
	$tropo = new Tropo();	
	$tropo->say("Sorry, an error has occured. Please try again later");	
	$tropo->hangup();	
	$tropo->renderJSON();
	
}

run();