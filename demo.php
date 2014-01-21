<?php
	define("CLASSES", __DIR__ . "/classes");
	/*
	//We may need these when we do more in-depth look-ups that require authentication (such as trades/more in-depth player details etc)
	require CLASSES."/Guzzle/guzzle.phar";
	require CLASSES."/connector.php";
	require CLASSES."/eahashor.php";
	require CLASSES."/searchor.php";
	*/

	/*
	//Login credentials for FUT (webapp)
	$loginDetails = array(
	    "username" => 'havorkian@hotmail.com',
	    "password" => 'putAPasswordHereBro',
	    "hash" => '32f11fde8f01c685cd1ee4875d93eebf', //md5 hash of your security question's answer
	    "platform" => "xbox360",
	);

	$con = new Connector($loginDetails);
	$connection = $con->connect();
	*/

	require CLASSES."/functionor.php";

	function makeCard($id) {

		$look = new Functionor();

		//Retrieve player data
		$player = $look->playerinfo($id);

		//Convert string data to object
		$data = (array) json_decode($player)->Item;

		//Retrieve urls for images
		$clubimage = $look->clubimage($data['ClubId']);
		$playerimage = $look->playerimage($id);

		// Rare - 1 = rare, 0 = non-rare
		$rarity =  $data['Rare'] ? 'rare' : 'nonrare';

		$cardType = 'gold';
	    if ( $data['Rating'] < 65) {
	    	$cardType = 'bronze';
	    } else if ( $data['Rating'] < 75) {
	        $cardType = 'silver';
	    }

		$name = $data['CommonName'] ? $data['CommonName'] : $data['LastName'];

		echo '<div class="player-card" style="background-image:url(http://fh13.fhcdn.com/static/img/14/cards/large-' . $cardType . '-' . $rarity . '.png);">
				<img style="position:absolute; height: 115px; width: 115px; top: 45px; left: 77px;" src="' . $playerimage .'" />
				<img style="position: absolute; width: 35px; height: 35px; top: 85px; left: 30px;" src="' . $clubimage .'" />

				<p style="position:absolute; text-transform:uppercase; top: 20px; left: 0; font-size: 20px; width: 200px; text-align: center; line-height: 18px; ">' . $name . '</p>
				<p style="position:absolute; top: 30px; left: 18px; font-size: 32px; line-height: 44px;">' . $data["Rating"] . '</p>
				
				<p style="position:absolute; top: 192px; left: 26px; font-size: 18px;">' . $data["Attribute1"] . ' PAC</p>
				<p style="position:absolute; top: 220px; left: 26px; font-size: 18px;">' . $data["Attribute2"] . ' SHO</p>
				<p style="position:absolute; top: 246px; left: 26px; font-size: 18px;">' . $data["Attribute3"] . ' PAS</p>
				<p style="position:absolute; top: 192px; left: 111px; font-size: 18px;">' . $data["Attribute4"] . ' DRI</p>
				<p style="position:absolute; top: 220px; left: 111px; font-size: 18px;">' . $data["Attribute5"] . ' DEF</p>
				<p style="position:absolute; top: 246px; left: 111px; font-size: 18px;">' . $data["Attribute6"] . ' HEA</p>
			</div>';
	}

	function getCards($players) {
		foreach ($players as $player) {
			makeCard($player);
		}
	}

?>
<style>
	* {
		font-family: arial, sans-serif;
	}
	p {
		margin:0;
	}
	.player-card {
		color:#ffffff;
		font-weight:bold;
		width:200px;
		height:300px;
		position:relative;
		float:left;
		margin:10px;
	}
</style>

<h1>FUT Data grabber demo.</h1>
<H3>Stuff we don't yet have:</H3>
<ul>
	<li>Look-up using player's name (this uses IDs which you have to manually look up elsewhere)</li>
	<li>Player Position - we can only retrieve basi position like 'Midfield' and not LM/LW/RWB etc.</li>
	<li>Handle 'Known as' names in a more advanced way / truncation of long names.</li>
	<li>Nationality flag - think we have to grab our own flags by nation ID.</li>
	<li>Deal with card types other than gold/silver/bronze....aka legend/TOTY/etc etc</li>
	<li>More in-depth stats like strength etc</li>
	<li>Storing retrieved data in our own DB</li>
	<li>Store all the images on our own servers instead of being leaches!</li>
	<li>The ability to remove Barnsley altogether</li>
</ul>
	
<?php
	// Naldo = 171919, C. Ronaldo - 20801, Henao - 208960, Pele - 190043, Messi - 158023
	/*$players = array(171919, 20801, 208960, 190043, 158023, 214267);
	getCards( $players );*/
?>

<h3>The best team in London, no, the best team of all!</h3>

<?php
	$players = array(
		162056, 162471, 155964, 119689, 195126, 203491, 183442, 155086, 178713,
		53978, 53719, 138355, 169112, 177618, 111590, 189772, 53435, 182209, 163584,
		183524, 166855, 103581, 152907, 193185, 197938, 171019, 54008, 50707
	);
	getCards( $players );
?>
