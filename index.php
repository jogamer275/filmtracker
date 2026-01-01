<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Film zoeken</title>
</head>
<body>
<h1>Film database</h1>
<form method="get">
    <label for="t">Zoek film:</label>
    <input
            type="search"
            id="t"
            name="t"
            placeholder="Voer film in"
            value="<?= htmlspecialchars(isset($_GET['t']) ? $_GET['t'] : '') ?>"
    />
    <button type="submit">Search</button>
</form>



<?php

/**
 * Haalt filmgegevens op uit de OMDb API.
 *
 * @param string $title De filmtitel die opgezocht gaat worden
 * @return array|string
 *         - array  : bij succes (API data)
 *         - string : bij fout (foutmelding)
 */
function fetchMovie($title) {
    // OMDb api key
    $apiKey = 'b01fb12c';

    $title = trim($title);

    // Check of er een filmtitel is ingevoerd
    if ($title === '') {
        return "Geen filmtitel opgegeven";
    }

    $movie = urlencode($title);

    // API request naar OMDb
    $response = file_get_contents(
        "http://www.omdbapi.com/?t=$movie&apikey=$apiKey"
    );

    if ($response === false) {
        return "Kon geen verbinding maken met de database";
    }
    // JSON response omzetten naar PHP
    return json_decode($response, true);
}
// Haal de zoekterm uit de URL
$result = fetchMovie(isset($_GET['t']) ? $_GET['t'] : '');
?>

<h2> De naam van de film is <?php echo $result['Title']; ?></h2>
<img src="<?php echo $result['Poster']; ?>" alt="<?php echo $result['Title']; ?>" />

</body>
</html>


