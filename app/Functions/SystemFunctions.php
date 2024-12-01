<?php

use App\Models\SystemConfig;

function systemConfig(string $key)
{
    $systemConfig = SystemConfig::where('key', $key)->first();

    // dd($systemConfig);
    return $systemConfig->value;
}
 

function generate_combinations($arrays, $index = 0, $current_combination = [], &$combinations = []) {
    if ($index == count($arrays)) {
        $combinations[] = $current_combination;
        return;
    }

    foreach ($arrays[$index] as $element) {
        generate_combinations($arrays, $index + 1, array_merge($current_combination, [$element]), $combinations);
    }
}

function filter_and_separate($arrays) {
    $filtered = [];
    $ignored = [];

    foreach ($arrays as $array) {
        if (count($array) > 1) {
            usort($array, 'strcasecmp'); // Sortowanie ignorujące wielkość liter
            $filtered[] = $array;
        } else {
            $ignored[] = $array;
        }
    }

    return [$filtered, $ignored];
}

function getAllelCombination($elements){
    list($filtered_elements, $ignored_elements) = filter_and_separate($elements);

    $combinations = [];
    generate_combinations($filtered_elements, 0, [], $combinations);
    $ret[0] = $combinations;
    $ret[1] = $ignored_elements;
    return $ret;
}

function getAllelComginationInfo($data){
    echo "Możliwe kombinacje:\n";
    foreach ($data[0] as $combination) {
        usort($combination, 'strcasecmp'); // Sortowanie wyników ignorując wielkość liter
        echo "[" . implode(", ", $combination) . "]\n";
    }
    
    echo "\nLiczba możliwych kombinacji: " . count($data[0]) . "\n";
    
    echo "\nTablice zignorowane:\n";
    foreach ($data[1] as $ignored) {
        echo "[" . implode(", ", $ignored) . "]\n";
    }
}

function find_unmatched_elements($femaleGens, $maleGens) {
    $unmatched = [];
    
    foreach ($femaleGens as $female) {
        $found_match = false;
        foreach ($maleGens as $male) {
            if (isset($female[0], $female[1], $male[0], $male[1]) && strcasecmp($female[0], $male[0]) == 0 && strcasecmp($female[1], $male[1]) == 0) {
                $found_match = true;
                break;
            }
        }
        if (!$found_match) {
            $unmatched[] = $female;
        }
    }
    
    foreach ($maleGens as $male) {
        $found_match = false;
        foreach ($femaleGens as $female) {
            if (isset($male[0], $male[1], $female[0], $female[1]) && strcasecmp($male[0], $female[0]) == 0 && strcasecmp($male[1], $female[1]) == 0) {
                $found_match = true;
                break;
            }
        }
        if (!$found_match) {
            $unmatched[] = $male;
        }
    }
    
    return $unmatched;
}


function combine_arrays($array1, $array2) {
    $result = [];
    $unmatched = find_unmatched_elements($array1, $array2);

    for ($i = 0; $i < count($array1); $i++) {
        for ($j = 0; $j < count($array2); $j++) {
            $combined = [];
            for ($k = 0; $k < count($array1[$i]); $k++) {
                $combined[] = $array1[$i][$k];
                $combined[] = $array2[$j][$k];
            }
            // Sortowanie alfabetyczne kombinacji ignorując wielkość liter
            usort($combined, 'strcmp');
            $result[] = $combined;
        }
    }

    return [$result, $unmatched];
}

function find_unmatched_elements_and_filter(&$array1, &$array2) {
    $unmatched_parents = [];
    $filtered_array1 = [];
    $filtered_array2 = [];
    
    foreach ($array1 as $item1) {
        $matched = false;
        foreach ($array2 as $key2 => $item2) {
            if (strcasecmp($item1[0], $item2[0]) == 0 && strcasecmp($item1[1], $item2[1]) == 0) {
                $matched = true;
                $filtered_array1[] = $item1;
                $filtered_array2[] = $item2;
                unset($array2[$key2]); // Usunięcie dopasowanego elementu z array2
                break;
            }
        }
        if (!$matched) {
            $unmatched_parents[] = $item1;
        }
    }
    
    foreach ($array2 as $item2) {
        $unmatched_parents[] = $item2;
    }
    
    $array1 = $filtered_array1;
    $array2 = $filtered_array2;
    
    // Ekstrakcja tylko pierwszych elementów z każdej tablicy wewnętrznej
    $unmatched_first_elements = array_map(function($item) {
        return $item[0];
    }, $unmatched_parents);

    return $unmatched_first_elements;
}

function translate_phenotype($combination, $dictionary) {
    $phenotypes = [];

    foreach ($dictionary as $entry) {
        $gene = strtolower($entry[0]);
        $phenotype_name = $entry[1];

        $matches = 0;
        $uppercase_count = 0;

        foreach ($combination as $allele) {
            if (strtolower($allele) === $gene) {
                $matches++;
                if (ctype_upper(substr($allele, 0, 1))) {
                    $uppercase_count++;
                }
            }
        }

        if ($matches === 2) {
            if ($uppercase_count === 0) {
                $phenotypes[] = $phenotype_name;
            } elseif ($uppercase_count === 1) {
                $phenotypes[] = "het. " . $phenotype_name;
            }
        }
    }

    return implode(", ", $phenotypes);
}

function translate_additional_genes($additional_genes, $dictionary) {
    $phenotypes = [];

    foreach ($additional_genes as $gene) {
        foreach ($dictionary as $entry) {
            $gene_key = strtolower($entry[0]);
            $gene_name = $entry[1];

            if (strtolower($gene) === $gene_key) {
                if (ctype_upper(substr($gene, 0, 1)) && ctype_upper(substr($gene, 1, 1))) {
                    $phenotypes[] = "1/2  " . $gene_name;
                } elseif (ctype_upper(substr($gene, 0, 1)) && ctype_lower(substr($gene, 1, 1))) {
                    $phenotypes[] = "50% poss " . $gene_name;
                } elseif (ctype_lower(substr($gene, 0, 1)) && ctype_lower(substr($gene, 1, 1))) {
                    $phenotypes[] = "het " . $gene_name;
                }
            }
        }
    }

    return implode(", ", $phenotypes);
}

function find_gene_code($gene_name, $dictionary) {
    foreach ($dictionary as $entry) {
        if (strtolower($entry[1]) === strtolower($gene_name)) {
            return $entry[0];
        }
    }
    return "Gen nie znaleziony";
}

// Funkcja do zliczania ilości wystąpień elementów w tablicy tablic
function count_occurrences($nested_array) {
    $occurrences = [];

    foreach ($nested_array as $array) {
        foreach ($array as $element) {
            if (!isset($occurrences[$element])) {
                $occurrences[$element] = 0;
            }
            $occurrences[$element]++;
        }
    }

    return $occurrences;
}

function getGenotypeFinale($maleGens, $femaleGens, $dictionary) {
    $unmatched_parents = find_unmatched_elements_and_filter($femaleGens, $maleGens);
    $female = getAllelCombination($femaleGens);
    $male = getAllelCombination($maleGens);
    $combined_data = combine_arrays($female[0], $male[0]);
    $combined_result = $combined_data[0];
    $unmatched_result = $combined_data[1];
    $total_combinations = count($combined_result);
    
    // Liczenie ilości wystąpień każdej kombinacji
    $counts = array();
    foreach ($combined_result as $combination) {
        $key = implode(", ", $combination);
        if (!isset($counts[$key])) {
            $counts[$key] = 0;
        }
        $counts[$key]++;
    }
    
    // Nowa tabela, która grupuje wyniki pod kątem pełnych genów i sumuje wartości
    $second_table = [];
    foreach ($counts as $combination => $count) {
        $phenotype = translate_phenotype(explode(", ", $combination), $dictionary);
    
        // Oddziel geny główne od dodatkowych (het.)
        $main_genes = [];
        $additional_genes = [];
        $genes = explode(", ", $phenotype);
        foreach ($genes as $gene) {
            if (strpos($gene, 'het.') === false) {
                $main_genes[] = $gene;
            } else {
                $gene_name_input = str_replace("het. ", "", $gene); // Nazwa genu, którą chcesz wyszukać
                $gene_code = find_gene_code($gene_name_input, $dictionary);
                $female = count_occurrences($femaleGens);
                $male = count_occurrences($maleGens);
            
                if ($male[$gene_code] == 2 || $female[$gene_code] == 2) {
                    $additional_genes[] = str_replace("het.", "het.", $gene);
                } else {
                    $additional_genes[] = str_replace("het.", "66% het.", $gene);
                }
            }
        }
    
        // Dodanie genów z "Unmatched Parents"
        foreach ($unmatched_parents as $unmatched_gene) {
            $gene_code = strtolower($unmatched_gene);
            foreach ($dictionary as $entry) {
                if (strtolower($entry[0]) === $gene_code) {
                    $gene_name = $entry[1];
    
                    if (ctype_upper($unmatched_gene[0]) && ctype_upper($unmatched_gene[1])) {
                        $additional_genes[] = "1/2 " . $gene_name;
                    } elseif (ctype_upper($unmatched_gene[0]) && ctype_lower($unmatched_gene[1])) {
                        $additional_genes[] = "50% het. " . $gene_name;
                    } elseif (ctype_lower($unmatched_gene[0]) && ctype_lower($unmatched_gene[1])) {
                        $additional_genes[] = "het. " . $gene_name;
                    }
                }
            }
        }
    
        $main_genes_str = implode(", ", $main_genes);
        $additional_genes_str = implode(", ", array_unique($additional_genes));
    
        if (!isset($second_table[$main_genes_str])) {
            $second_table[$main_genes_str] = [
                'additional_genes' => [],
                'count' => 0,
                'percentage' => 0.0,
            ];
        }
    
        if (!isset($second_table[$main_genes_str]['additional_genes'][$additional_genes_str])) {
            $second_table[$main_genes_str]['additional_genes'][$additional_genes_str] = [
                'count' => 0,
                'percentage' => 0.0,
            ];
        }
    
        $second_table[$main_genes_str]['additional_genes'][$additional_genes_str]['count'] += $count;
        $second_table[$main_genes_str]['additional_genes'][$additional_genes_str]['percentage'] += ($count / $total_combinations) * 100;
    
        $second_table[$main_genes_str]['count'] += $count;
        $second_table[$main_genes_str]['percentage'] += ($count / $total_combinations) * 100;
    }
    
    // Sumowanie i łączenie wartości dla zgrupowanych wierszy
    $final_table = [];
    foreach ($second_table as $main_genes => $data) {
        $combined_additional_genes = [];
        foreach ($data['additional_genes'] as $additional_genes => $add_data) {
            if ($additional_genes !== '') {
                $combined_additional_genes = array_merge($combined_additional_genes, explode(", ", $additional_genes));
            }
        }
        $combined_additional_genes = array_unique($combined_additional_genes); // Usuwanie powtórzeń
        $combined_additional_genes_str = implode(", ", $combined_additional_genes);
        $final_table[] = [
            'main_genes' => $main_genes,
            'additional_genes' => $combined_additional_genes_str,
            'count' => $data['count'],
            'percentage' => $data['percentage'],
        ];
    }
    
    // Wyświetlanie finalnej tabeli
    // echo "<hr><table border='1'>";
    // echo "<tr><th>Geny główne</th><th>Geny dodatkowe</th><th>Ilość wystąpień</th><th>% Wystąpień</th></tr>";
    // foreach ($final_table as $row) {
    //     echo "<tr><td>{$row['main_genes']}</td><td>{$row['additional_genes']}</td><td>{$row['count']}</td><td>" . number_format($row['percentage'], 2) . "%</td></tr>";
    // }
    // echo "</table>";
    
    return $final_table;
}
