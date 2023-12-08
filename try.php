<style>
	<?php include 'style.css'?> 
</style>
<?php include 'home.html'?>
<?php



$selectedOption = "Type";

// Verifica se è stata inviata una richiesta POST dalla combobox
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["race"])) {
	// Ottieni il valore selezionato dalla combobox
    $selectedOption = $_POST["race"];
}

$baseUrl = "https://omgvamp-hearthstone-v1.p.rapidapi.com/cards/races/$selectedOption?locale=itIT";
// $url = $baseUrl . strtolower($selectedOption);
$curl = curl_init();

//se alla fine del link che trovi qua sotto sostituisci l'ultima
//parola(Pirates), e inserisci un'altro tipo(tutti i tipi li vedi
//in home.html nella parte del form dove ci sono gli input). ciao frocio
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
	echo "cURL Error #:" . $err;
} else {
    $decoded_response = json_decode($response, true);
    
    if ($decoded_response !== null) {
        $file_name = 'cards_murloc.json';
        $formatted_json = json_encode($decoded_response, JSON_PRETTY_PRINT);
        file_put_contents($file_name, $formatted_json);
        
    } else {
        echo "Errore nella decodifica della risposta JSON.";
    }




	$file_content = file_get_contents('cards_murloc.json');
	$json_data = json_decode($file_content, true);

	$desired_id = 'UNG_073';
	$minion = 'Minion';

	foreach ($json_data as $element) {
    	// if (isset($element['cardId']) && $element['cardId'] === $desired_id) {
			if($element['type'] === 'Minion'){
				if($element['cardSet'] === 'Battlegrounds'){
				if (isset($element['img'])) {
	
					$cleaned_url = stripslashes($element['img']);
				
				} else {
					$cleaned_url = "Immagine Non Disponibile";
				}
				if (isset($element['text'])) {
	
					$text = stripslashes($element['text']);
				
				} else {
					$text = "Descrizione Non Disponibile";
				}
				if (isset($element['falvor'])) {
	
					$flavor = stripslashes($element['flavor']);
				
				} else {
					$flavor = "Flavor Non Disponibile";
				}
				if (isset($element['race'])) {
	
					$race = stripslashes($element['race']);
				
				} else {
					$race = "Tipo della carta non disponibile";
				}
				echo "
				<div class='cardContent'>
					<div class='imgCard'>
						<img src='" . $cleaned_url . "' alt='Caricamento immagine non riuscita'>
					</div>
					<div class='infoCard'> 
						<p>Name: {$element['name']}</p>
						<p>Tribe: {$race}</p>
						<p>Descrizione: {$text}</p>
						<p>Flavor: {$flavor}</p>
					</div>
				</div>";

			}
		}
	
			
    	}
	
	}



// }


//funziona tutto
//usa: https://rapidapi.com/blog/hearthstone-api-with-python-php-ruby-javascript-examples/
//rapidapi hs usato: https://rapidapi.com/omgvamp/api/hearthstone/