<style>
	<?php include 'style.css'?> 
</style>
<?php include 'home.html'?>
<?php



$selectedOption = " ";
$searchTerm = " ";

// Verifica se è stata inviata una richiesta POST dalla combobox
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tipo"])) {
	// Ottieni il valore selezionato dalla combobox
	$searchTerm = $_POST["nome"];
    $selectedOption = $_POST["tipo"];
}
else {
	$searchTerm = "";
}

if($searchTerm === ""){
	echo"
	<div class='research'>
		<h1>Risultati in '$selectedOption'</h1>
	</div>";
}
else{
	echo	"
	<div class='research'>
		<h1>Risultati in '$selectedOption'</h1>
		<p>chiamati '$searchTerm';
	</div>";
}

$baseUrl = "https://omgvamp-hearthstone-v1.p.rapidapi.com/cards/races/$selectedOption?locale=itIT";
$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => $baseUrl,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: omgvamp-hearthstone-v1.p.rapidapi.com",
		"X-RapidAPI-Key: 55aa425b1fmshd6e6c7c3064b0cfp10269bjsn6ca8fd2b7d67"
	],
]);


$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo " ";
}
else {
    $decoded_response = json_decode($response, true);
    
    if ($decoded_response !== null) {
        $file_name = 'cardsBG.json';
        $formatted_json = json_encode($decoded_response, JSON_PRETTY_PRINT);
        file_put_contents($file_name, $formatted_json);
        
    } else {
        echo "Errore nella decodifica della risposta JSON.";
    }

	$file_content = file_get_contents('cardsBG.json');
	$json_data = json_decode($file_content, true);

	$desired_id = 'UNG_073';
	$minion = 'Minion';

	foreach ($json_data as $element) {
			if(isset($element['type']) && isset($element['cardSet']) && $element['type'] === 'Minion' && $element['cardSet'] === 'Battlegrounds'){
					if(isset($element['name']))
				if(stripos(strtolower($element['name']), strtolower($searchTerm)) !== false){
			$cleaned_url = isset($element['img']) ? stripslashes($element['img']) : "Immagine Non Disponibile";
			if(isset($element['text'])){
				$text = stripslashes($element['text']);
			} 
			else {
				$text = " ";
			}
			$race = isset($element['race']) ? stripslashes($element['race']) : "Tipo della carta non disponibile";
			$attack = isset($element['attack']) && isset($element['health']) ? stripslashes($element['attack']) : "???";
			$health = isset($element['attack']) && isset($element['health']) ? stripslashes($element['health']) : "???";
			if (isset($element['otherRaces']) && is_array($element['otherRaces']) && count($element['otherRaces']) > 0) {
				foreach ($element['otherRaces'] as $key) {
					$race2 = "- $key";
				}
			} else{
				$race2 = " ";
			}
				echo "
				<div class='cardSection'>
				<div class='cardContent'>
					<div class='imgCard'>
						<img src='" . $cleaned_url . "' alt='Immagine Non Disponibile'>
					</div>
					<div class='infoCard'> 
						<p>Name: {$element['name']}</p>
						<p>Tribe: {$race} {$race2}</p>
						<p>Descrizione: {$text}</p>
						<p><strong class='strong'>ATK: {$attack} - HTH: {$health}</strong></p>
					</div>
				</div>
				</div>";

			}
		}
	}
}
	

// https://rapidapi.com/blog/hearthstone-api-with-python-php-ruby-javascript-examples/
// https://rapidapi.com/omgvamp/api/hearthstone/