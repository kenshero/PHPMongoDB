<?php

// Autoload
require './vendor/autoload.php';

// Instantiate a Slim application
$app = new \Slim\Slim();

$m = new MongoClient();	
$db = $m->selectDB("todoTest");

$app->get('/getdata', function () use($m,$db) {

	try 
	{
		
		$cursor = $db->{'members'}->find();
		echo json_encode(iterator_to_array($cursor));
		
	}
	catch ( MongoConnectionException $e ) 
	{
	    echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
	    exit();
	}

});

$app->post('/adddata', function () use($app,$db) {

	try 
	{	
		 // $d = array("_id" => new MongoId()); //Generates new ID
		 // $data = array('_id' => $d['_id']->{'$id'}); 
		
		 $user = json_decode($app->request()->getBody());
		 $cursor = $db->{'members'}->insert($user->params);
		 print_r($user);
		// echo json_encode($cursor);

	
		
	}
	catch ( MongoConnectionException $e ) 
	{
	    echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
	    exit();
	}

});


$app->post('/editdata', function () use($app,$db) {

	try 
	{
		$user = json_decode($app->request()->getBody());

		print_r($user);
		$db->{'members'}->update(
			array("_id" => $user->params->id),
            array('$set' => array("Name" => $user->params->name, "Phone" => $user->params->phone)),
            array("upsert" => true)
			 );
		
		//print_r($user);

		//echo json_encode($cursor);
		
	}
	catch ( MongoConnectionException $e ) 
	{
	    echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
	    exit();
	}

});



$app->post('/deldata/:id', function ($id) use($app, $db) {

	try
	{
		$db->{'members'}->remove(array('_id' => new MongoId($id)));
   		print_r($id);
	}
	catch ( MongoConnectionException $e ) 
	{
	    echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
	    exit();
	}
	
    
});


// Run the Slim application
$app->run();


?>