<?php
require_once __DIR__ . '/app/MovieService.php';
$config = require __DIR__ . '/app/config.php';

// MovieService instantie maken
$movieService = new MovieService($config);

// Haal de zoekterm op
$query = isset($_GET['t']) ? $_GET['t'] : '';

// Gebruik fetchMovie
$result = $movieService->fetchMovie($query);

?>
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
<h2> De naam van de film is <?php echo $result['Title']; ?></h2>
<img src="<?php echo $result['Poster']; ?>" alt="<?php echo $result['Title']; ?>" />
<form method="post">
    <!-- IMDB ID gebruiken als unieke identifier -->
    <input type="hidden" name="imdb_id" value="<?= $result['imdbID']; ?>">
    <input type="hidden" name="title" value="<?= $result['Title']; ?>">
    <input type="hidden" name="year" value="<?= $result['Year']; ?>">
    <input type="hidden" name="poster" value="<?= $result['Poster']; ?>">

    <button type="submit" name="save_movie">Opslaan in database</button>
</form>

</body>

<?
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_movie'])) {
    // Maak een array van de POST-data
    $movieToSave = [
        'imdbID' => $_POST['imdb_id'],
        'Title'  => $_POST['title'],
        'Year'   => $_POST['year'],
        'Poster' => $_POST['poster']
    ];

    // Roep saveMovie aan
    $movieService->saveMovie($movieToSave);
}


?>
</html>


