<?php
require_once __DIR__ . '/db.php';
$config = require __DIR__ . '/config.php';

class MovieService
{
    // OMDb api key
    private $apiKey;

    public function __construct($config)
    {
        $this->apiKey = $config['omdb_api_key'];
    }


    /**
     * Haalt filmgegevens op uit de OMDb API.
     *
     * @param string $title De filmtitel die opgezocht gaat worden
     * @return array|string
     *         - array  : bij succes (API data)
     *         - string : bij fout (foutmelding)
     */
    public function fetchMovie($title)
    {


        $title = trim($title);

        // Check of er een filmtitel is ingevoerd
        if ($title === '') {
            return "Geen filmtitel opgegeven";
        }

        $movie = urlencode($title);

        // API request naar OMDb
        $response = file_get_contents(
            "http://www.omdbapi.com/?t=$movie&apikey=$this->apiKey"
        );

        if ($response === false) {
            return "Kon geen verbinding maken met de database";
        }
        // JSON response omzetten naar PHP
        return json_decode($response, true);
    }


    public function saveMovie($movie)
    {
        print_r($movie);
        try {
            $db = getDatabaseConnection();
            $stmt = $db->prepare("INSERT IGNORE INTO movies (imdb_id, title, year, poster, created_at)
            VALUES (:imdb_id, :title, :year, :poster, :created_at)
        ");

            $stmt->execute([
                ':imdb_id'    => $movie['imdbID'],
                ':title'      => $movie['Title'],
                ':year'       => $movie['Year'],
                ':poster'     => $movie['Poster'],
                ':created_at' => date('Y-m-d H:i:s')
            ]);



            return "Film opgeslagen!";
        } catch (PDOException $e) {
            return "Fout bij verbinding: " . $e->getMessage();
        }


    }
}

