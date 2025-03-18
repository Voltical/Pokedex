<?php
set_time_limit(0); // Geen tijdslimiet zodat alles afgerond wordt

require_once 'Includes/database.inc.php'; // Jouw database class
use Includes\Database; // Zorgt ervoor dat je Database kunt gebruiken

for ($i = 1; $i <= 205; $i++) {
    echo "⏳ Bezig met Pokémon #$i...<br>";

    // ✅ Pokémon data ophalen
    $json = file_get_contents("https://pokeapi.co/api/v2/pokemon/$i");
    $data = json_decode($json, true);

    // ✅ Hoogte en gewicht omrekenen naar m & kg
    $height = ($data['height'] / 10) . ' m'; // decimeter -> meter
    $weight = ($data['weight'] / 10) . ' kg'; // hectogram -> kilogram

    // ✅ Abilities netjes als string
    $abilitiesArray = array_map(fn($a) => $a['ability']['name'], $data['abilities']);
    $abilities = implode(', ', $abilitiesArray);

    // ✅ Species info ophalen (voor gender en beschrijving)
    $speciesJson = file_get_contents("https://pokeapi.co/api/v2/pokemon-species/$i");
    $speciesData = json_decode($speciesJson, true);
    $genderRate = $speciesData['gender_rate'];

    // ✅ Geslacht bepalen
    $gender = 'Onbekend';
    if ($genderRate === -1) $gender = 'Onbekend';
    elseif ($genderRate === 0) $gender = 'Mannelijk';
    elseif ($genderRate === 8) $gender = 'Vrouwelijk';
    else $gender = 'Beide';

    // ✅ Beschrijving ophalen (NL als voorkeur, anders Engels als fallback)
    $description = 'Onbekend';
    $found_nl = false;

    // Eerst proberen alle NL-opties te doorzoeken
    foreach ($speciesData['flavor_text_entries'] as $entry) {
        if ($entry['language']['name'] === 'nl') {
            $description = preg_replace('/\s+/', ' ', $entry['flavor_text']);
            $description = trim($description);
            $found_nl = true;
            break; // Stop zodra een NL-beschrijving is gevonden
        }
    }

    // Als geen NL gevonden, dan pas Engels pakken
    if (!$found_nl) {
        foreach ($speciesData['flavor_text_entries'] as $entry) {
            if ($entry['language']['name'] === 'en') {
                $description = preg_replace('/\s+/', ' ', $entry['flavor_text']);
                $description = trim($description);
                break;
            }
        }
    }

    // ✅ Database query voorbereiden (UPDATE)
    $query = "
        UPDATE pokemons 
        SET gender = :gender, height = :height, weight = :weight, abilities = :abilities, description = :description
        WHERE number = :number
    ";

    $params = [
        ':gender' => $gender,
        ':height' => $height,
        ':weight' => $weight,
        ':abilities' => $abilities,
        ':description' => $description,
        ':number' => $i
    ];

    // ✅ Data uitvoeren in database
    Database::insertData($query, $params);

    // ✅ Feedback tonen
    echo "✅ Pokémon #$i bijgewerkt: Gender=$gender, Hoogte=$height, Gewicht=$weight, Abilities=$abilities, Beschrijving=$description <br><br>";
}

echo "<br>🎉 Alle 205 Pokémon succesvol bijgewerkt!";
?>
