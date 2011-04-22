<?php

error_reporting(0);

// include required class files.
require_once 'classes/limonade.php';
require_once 'classes/tropo.class.php';

// Route for the initial caller dialog.
dispatch_post('start', 'tropoStart');
function tropoStart() {
	
	// Create a new instance of the Tropo object.
	$tropo = new Tropo();	
	
	// Welcome message, and get caller input.
	$tropo->say("Welcome to the tropo orchestra example.", array("barge" => false));
	$tropo->ask("What is your favoirte programming language dude? You can say PHP, Ruby, Javascript or Python.", 
				array("attempts" => 3,
					  "choices" => "PHP, Ruby, JavaScript, Python", 
					  "name" => "language", 
					  "timeout" => 5)
				);
	
	// Event handlers.
	$tropo->on(array("event" => "continue", "next" => "index?uri=end", "say" => "Please hold."));
	$tropo->on(array("event" => "error", "next" => "index?uri=error", "say" => "An error has occured."));
	
	// Render JSON for Tropo to consume.
	$tropo->renderJSON();
	
}

// Route for the final caler dialog.
dispatch_post('end', 'tropoEnd');
function tropoEnd() {
	
	// Create a new instance of the result object, and get caller selection.
	$result = new Result();
	$selection = $result->getValue();	
	
	// Create a new instance of the Tropo object.
	$tropo = new Tropo();
	
	// Alternate prompt based on caller selection.
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
	
	// Read out prompt based on caller langage selection.
	$tropo->say("You chose, " . $selection);	
	$tropo->say($toSay);	
	$tropo->say("Thanks for playing along. Goodbye");	
	
	// Hangup when done.
	$tropo->hangup();
		
	// Render JSON for Tropo to consume.
	$tropo->renderJSON();

}

// Route for an error dialog.
dispatch_post('error', 'tropoError');
function tropoError() {
	
	// Create a new instance of the Tropo object.
	$tropo = new Tropo();	
	
	// Error prompt.
	$tropo->say("Sorry, an error has occured. Please try again later");

	// Hangup when done.
	$tropo->hangup();
	
	// Render JSON for Tropo to consume.
	$tropo->renderJSON();
	
}

// Run the app.
run();