<?php
set_time_limit(3000);

class TMDBInserter extends DB{
        private $page;

        public function __construct($page){
            parent::__construct();
            $this->page=$page;
        }

        public function fetch_tmdb_data() {
            $bearer_token="eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJjNjYxMTkxNzA5NDBjMGVlNjczOTJhMjk5ZDA0Mzg3MyIsInN1YiI6IjY2NDhkMjZmZWE4ZTg1ODU2ZmYyNDJkYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.-qGbUifCD2OBR3K4HM_gWzsCvflw6Er559SgwL7KoYc";
            $url = "https://api.themoviedb.org/3/person/popular?page=" . $this->page;
            
            // Initialize cURL session
            $curl = curl_init();

            // Set cURL options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer " . $bearer_token
            ));


            $response = curl_exec($curl);

            if($response === false) {
                echo 'Curl error: ' . curl_error($curl);
            } else {
                $data = json_decode($response, true);
            }

            curl_close($curl);

            return $data;
        }

        public function fetch_actor_credits($actor_id){
            $bearer_token="eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJjNjYxMTkxNzA5NDBjMGVlNjczOTJhMjk5ZDA0Mzg3MyIsInN1YiI6IjY2NDhkMjZmZWE4ZTg1ODU2ZmYyNDJkYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.-qGbUifCD2OBR3K4HM_gWzsCvflw6Er559SgwL7KoYc";
            $url = "https://api.themoviedb.org/3/person/" . $actor_id . "/movie_credits";
            
            // Initialize cURL session
            $curl = curl_init();

            // Set cURL options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer " . $bearer_token
            ));


            $response = curl_exec($curl);

            if($response === false) {
                echo 'Curl error: ' . curl_error($curl);
            } else {
                $data = json_decode($response, true);
            }

            curl_close($curl);

            return $data;


        }

        public function fetch_actor_details($actor_id) {
            $bearer_token="eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJjNjYxMTkxNzA5NDBjMGVlNjczOTJhMjk5ZDA0Mzg3MyIsInN1YiI6IjY2NDhkMjZmZWE4ZTg1ODU2ZmYyNDJkYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.-qGbUifCD2OBR3K4HM_gWzsCvflw6Er559SgwL7KoYc";
            $url = "https://api.themoviedb.org/3/person/" . $actor_id;
            
            // Initialize cURL session
            $curl = curl_init();

            // Set cURL options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer " . $bearer_token
            ));


            $response = curl_exec($curl);

            if($response === false) {
                echo 'Curl error: ' . curl_error($curl);
            } else {
                $data = json_decode($response, true);
            }

            curl_close($curl);

            return $data;


        }

        public function insert_data($data) {
            foreach ($data['results'] as $person) {
                $stmt = $this->pdo->prepare('SELECT id FROM actors WHERE id = :id');
                $stmt->execute([':id' => $person['id']]);
                $actorExists = $stmt->fetch(PDO::FETCH_ASSOC);

                if($actorExists){
                    $credits = $this->fetch_actor_credits($person['id']);
                    if (isset($credits['cast']) && is_array($credits['cast'])) {
                        foreach ($credits['cast'] as $movie) {
                            $stmt = $this->pdo->prepare('
                                INSERT INTO movies (id, actor_id, title, release_date, vote_average, poster_path)
                                VALUES (:id, :actor_id, :title, :release_date, :vote_average, :poster_path)
                                ON DUPLICATE KEY UPDATE
                                    actor_id=VALUES(actor_id),
                                    title=VALUES(title),
                                    release_date=VALUES(release_date),
                                    vote_average=VALUES(vote_average),
                                    poster_path=VALUES(poster_path)
                            ');
                            $stmt->execute([
                                ':id' => $movie['id'],
                                ':actor_id' => $person['id'],
                                ':title' => $movie['title'],
                                ':release_date' => $movie['release_date'],
                                ':vote_average' => $movie['vote_average'] ,
                                ':poster_path' => $movie['poster_path']
                            ]);
                        }
                    }
                }


            /*    $stmt = $this->pdo->prepare('SELECT id FROM actors WHERE id = :id');
                $stmt->execute([':id' => $person['id']]);
                $actorExists = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$actorExists) {
                    $stmt = $this->pdo->prepare('
                        INSERT INTO actors (id, name, gender, popularity, profile_path, known_for_department)
                        VALUES (:id, :name, :gender, :popularity, :profile_path, :known_for_department)
                        ON DUPLICATE KEY UPDATE
                            name=VALUES(name),
                            gender=VALUES(gender),
                            popularity=VALUES(popularity),
                            profile_path=VALUES(profile_path),
                            known_for_department=VALUES(known_for_department)
                    ');
                    $stmt->execute([
                        ':id' => $person['id'],
                        ':name' => $person['name'],
                        ':gender' => $person['gender'],
                        ':popularity' => $person['popularity'],
                        ':profile_path' => $person['profile_path'],
                        ':known_for_department' => $person['known_for_department']
                    ]);

                    
                    $stmt1 = $this->pdo->prepare('SELECT biography, place_of_birth, birthday FROM actors WHERE id = :id');
                    $stmt1->execute([':id' => $person['id']]);
                    $actorDetails = $stmt1->fetch(PDO::FETCH_ASSOC);
                    if(empty($actorDetails['biography']) && empty($actorDetails['place_of_birth']) && empty($actorDetails['birthday'])){
                        $details = $this->fetch_actor_details($person['id']);
                        if ($details) {
                            $stmt1 = $this->pdo->prepare('
                                UPDATE actors
                                SET biography = :biography,
                                    place_of_birth = :place_of_birth,
                                    birthday = :birthday
                                WHERE id = :id
                            ');
                            $stmt1->execute([
                                ':biography' => $details['biography'],
                                ':place_of_birth' => $details['place_of_birth'],
                                ':birthday' => $details['birthday'],
                                ':id' => $person['id']
                            ]);
                        }
                    }
                }

                foreach ($person['known_for'] as $movie) {
                        if ($movie['media_type'] == 'movie') {
                            $stmt = $this->pdo->prepare('SELECT id FROM movies WHERE id = :id');
                            $stmt->execute([':id' => $movie['id']]);
                            $movieExists = $stmt->fetch(PDO::FETCH_ASSOC);

                            if (!$movieExists) {
                                $stmt = $this->pdo->prepare('
                                    INSERT INTO movies (id, actor_id, title, release_date, vote_average, poster_path)
                                    VALUES (:id, :actor_id, :title, :release_date, :vote_average, :poster_path)
                                    ON DUPLICATE KEY UPDATE
                                        actor_id=VALUES(actor_id),
                                        title=VALUES(title),
                                        release_date=VALUES(release_date),
                                        vote_average=VALUES(vote_average),
                                        poster_path=VALUES(poster_path)
                                ');
                                $stmt->execute([
                                    ':id' => $movie['id'],
                                    ':actor_id' => $person['id'],
                                    ':title' => $movie['title'],
                                    ':release_date' => $movie['release_date'],
                                    ':vote_average' => $movie['vote_average'],
                                    ':poster_path' => $movie['poster_path']
                                ]);
                            }
                        }
                    
                    }*/
                    
            }
        }

    }

        // Obținerea datelor de la TMDB
        for($i=1;$i<=500;$i++){
            $inserter = new TMDBInserter($i);
            $data=$inserter->fetch_tmdb_data();
            $inserter->insert_data($data);
            
        }


        echo "Data inserted successfully!";
?>