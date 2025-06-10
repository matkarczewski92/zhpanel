<?php

namespace App\Functions;

use App\Models\AnimalGenotypeTraits;
use App\Models\SystemConfig;

class SystemFunctions
{
    public static function systemConfig(string $key)
    {
        $systemConfig = SystemConfig::where('key', $key)->first();
    
        // dd($systemConfig);
        return $systemConfig->value;
    }
     
    
    public static function generate_combinations($arrays, $index = 0, $current_combination = [], &$combinations = [])
    {
        if ($index == count($arrays)) {
            $combinations[] = $current_combination;
            return;
        }
    
        foreach ($arrays[$index] as $element) {
            self::generate_combinations($arrays, $index + 1, array_merge($current_combination, [$element]), $combinations);
        }
    }
    
    public static function filter_and_separate($arrays)
    {
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
    
    public static function getAllelCombination($elements)
    {
        list($filtered_elements, $ignored_elements) = self::filter_and_separate($elements);

        $combinations = [];
        self::generate_combinations($filtered_elements, 0, [], $combinations);
        $ret[0] = $combinations;
        $ret[1] = $ignored_elements;
        return $ret;
    }
    
        public static function getAllelComginationInfo($data){
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
    
        public static function find_unmatched_elements($femaleGens, $maleGens) {
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
    
    
    public static function combine_arrays($array1, $array2)
    {
        $result = [];
        $unmatched = self::find_unmatched_elements($array1, $array2);
    
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
    
        public static function find_unmatched_elements_and_filter(&$array1, &$array2) {
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
    
        public static function translate_phenotype($combination, $dictionary) {
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
                    // dump($phenotype_name);
                } 
            }
            
        }
    
        return implode(", ", $phenotypes);
    }
    
        public static function translate_additional_genes($additional_genes, $dictionary) {
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
    
        public static function find_gene_code($gene_name, $dictionary) {
        foreach ($dictionary as $entry) {
            if (strtolower($entry[1]) === strtolower($gene_name)) {
                return $entry[0];
            }
        }
        return "Gen nie znaleziony";
    }
        public static function find_gene_name($gene_code, $dictionary) {
        foreach ($dictionary as $entry) {
            if (strtolower($entry[0]) === strtolower($gene_code)) {
                return $entry[1];
            }
        }
        return "Gen nie znaleziony";
    }
    
    // Funkcja do zliczania ilości wystąpień elementów w tablicy tablic
        public static function count_occurrences($nested_array) {
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
    
        public static function check_both_parents_dominant_genes($maleGens, $femaleGens) {
        $dominant_genes = [];
        foreach ($maleGens as $male) {
            foreach ($femaleGens as $female) {
                if (is_string($male[0]) && is_string($male[1]) && is_string($female[0]) && is_string($female[1]) && 
                    ctype_upper($male[0]) && ctype_upper($male[1]) && 
                    ctype_upper($female[0]) && ctype_upper($female[1])) {
                    $dominant_genes[] = $male;
                }
            }
        }
        
        return $dominant_genes;
    
    }
    
        public static function getGenotypeTraitsDictionary()
    {
        $traits = AnimalGenotypeTraits::orderBy('number_of_traits')->get();
        $array = [];
    
        foreach($traits as $trait){
            foreach($trait->getTraitsDictionary as $tr){
                $array[$trait->number_of_traits][$trait->name][] = $tr->genotypeCategory->name;
            }
        }
        krsort($array);
        return $array;
    }
    
    
        public static function matchTraitSet(array $main_genes_array, array $traitsDictionary, array $combined_additional_genes_str_array = null, $dominant = '') 
    {
        // Usuwamy spacje z genów głównych
        $main_genes_array = array_map('trim', $main_genes_array);
    
        $prefix = '';
        $hasUltramel = false;
    
        // Sprawdzamy obecność "het. amel" i "het. ultra"
        if ($combined_additional_genes_str_array !== null) {
            $normalized_additional_genes = array_map(function($gene) {
                return strtolower(trim($gene));
            }, $combined_additional_genes_str_array);
    
            if (in_array('het. amel', $normalized_additional_genes) && in_array('het. ultra', $normalized_additional_genes)) {
                $hasUltramel = true;
                $prefix = 'Ultramel';
            }
        }
    
        $usedGenes = [];  // geny użyte w traitach
        $baseName = null;
    
        // 1. Pełne dopasowanie
        foreach ($traitsDictionary as $traitGroup) {
            foreach ($traitGroup as $traitName => $requiredGenes) {
                $matched = array_intersect($main_genes_array, $requiredGenes);
                if (count($matched) === count($requiredGenes)) {
                    $usedGenes = array_merge($usedGenes, $matched);
                    $baseName = $traitName;
                    break 2;
                }
            }
        }
    
        // 2. Częściowe dopasowanie (dla 2-genowych)
        if (!$baseName) {
            foreach ($traitsDictionary as $traitGroup) {
                foreach ($traitGroup as $traitName => $requiredGenes) {
                    if (count($requiredGenes) === 2) {
                        $matched = array_intersect($main_genes_array, $requiredGenes);
                        if (count($matched) === 2) {
                            $usedGenes = array_merge($usedGenes, $matched);
                            $baseName = $traitName;
                            break 2;
                        }
                    }
                }
            }
        }
    
        // 3. Jeśli nie ma dopasowania ani Ultramela → null
        if (!$baseName && !$hasUltramel) {
            return null;
        }
    
        // 4. Zbieramy nieużyte geny
        $unusedGenes = array_diff($main_genes_array, $usedGenes);
    
        // 5. Budujemy wynik
        $resultParts = [];
    
        if ($prefix) $resultParts[] = $prefix;
        if ($baseName) $resultParts[] = $baseName;
        $resultParts = array_merge($resultParts, $unusedGenes);
    
        // 6. Dodajemy dominujący gen na końcu (jeśli podany)
        if (!empty($dominant)) {
            $resultParts[] = $dominant;
        }
    
        // 7. Sprawdzamy, czy Ultramel i Caramel występują razem i dodajemy "Gold Dust"
        $resultString = implode(' ', $resultParts);
        if (strpos($resultString, 'Ultramel') !== false && strpos($resultString, 'Caramel') !== false) {
            // Jeśli Ultramel i Caramel występują razem, zastępujemy je tylko raz na "Gold Dust"
            $resultString = preg_replace('/(Ultramel|Caramel)/', '', $resultString); // Usuwamy Ultramel i Caramel
            $resultString = trim($resultString); // Usuwamy zbędne spacje
            $resultString = "Gold Dust " . $resultString; // Dodajemy Gold Dust na początku
        }
    
        return $resultString;
    }
    
    
    
    public static function getGenotypeFinale($maleGens, $femaleGens, $dictionary, $genotypeTraitsDictionary = null)
    {
        $unmatched_parents = self::find_unmatched_elements_and_filter($femaleGens, $maleGens);
        $female = self::getAllelCombination($femaleGens);
        $male = self::getAllelCombination($maleGens);
        $combined_data = self::combine_arrays($female[0], $male[0]);
        $combined_result = $combined_data[0];
        $unmatched_result = $combined_data[1];
        $total_combinations = count($combined_result);
        $traitsDictionary = self::getGenotypeTraitsDictionary();
        
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
            $phenotype = self::translate_phenotype(explode(", ", $combination), $dictionary);
            
            // Oddziel geny główne od dodatkowych (het.)
            $main_genes = [];
            $additional_genes = [];
            $genes = explode(", ", $phenotype);
    
            foreach ($genes as $gene) {
                if (strpos($gene, 'het.') === false) {
                    $main_genes[] = $gene;
                } else {
                    $gene_name_input = str_replace("het. ", "", $gene); // Nazwa genu, którą chcesz wyszukać
                    $gene_code = self::find_gene_code($gene_name_input, $dictionary);
                    $female = self::count_occurrences($femaleGens);
                    $male = self::count_occurrences($maleGens);
                
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
                            $prefix = in_array(strtolower($gene_name), ['aamel', 'ultra']) ? "het." : "50% het.";
                            $additional_genes[] = "$prefix $gene_name";
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
    
    
    
    
        
    
    
        if (count(self::check_both_parents_dominant_genes($maleGens, $femaleGens)[0] ?? []) == 2) {
            $dominant = self::find_gene_name(self::check_both_parents_dominant_genes($maleGens, $femaleGens)[0][0], $dictionary);
        }
        foreach ($second_table as $main_genes => $data) {
            $combined_additional_genes = [];
            foreach ($data['additional_genes'] as $additional_genes => $add_data) {
                if ($additional_genes !== '') {
                    $combined_additional_genes = array_merge($combined_additional_genes, explode(", ", $additional_genes));
                }
            }
            $combined_additional_genes = array_unique($combined_additional_genes); // Usuwanie powtórzeń
            $combined_additional_genes_str = implode(", ", $combined_additional_genes);
    
    
            $dominant = isset($dominant) ? $dominant : '';
            $combined_additional_genes_str_array = explode(',', $combined_additional_genes_str);
            $main_genes_array = explode(',', $main_genes);
            $result = self::matchTraitSet($main_genes_array, $traitsDictionary, $combined_additional_genes_str_array, $dominant);
            $final_table[] = [
                'dominant' => $dominant ?? '',
                'main_genes' => $main_genes,
                'additional_genes' => $combined_additional_genes_str,
                'count' => $data['count'],
                'percentage' => $data['percentage'],
                'traits_name' => $result,
            ];
        }
        
        // dump($final_table);
        return $final_table;
    }
}

if (!function_exists('systemConfig')) {
    function systemConfig(string $key) {
        return \App\Functions\SystemFunctions::systemConfig($key);
    }
}

if (!function_exists('generate_combinations')) {
    function generate_combinations($arrays, $index = 0, $current_combination = [], &$combinations = []) {
        return \App\Functions\SystemFunctions::generate_combinations($arrays, $index, $current_combination, $combinations);
    }
}

if (!function_exists('filter_and_separate')) {
    function filter_and_separate($arrays) {
        return \App\Functions\SystemFunctions::filter_and_separate($arrays);
    }
}

if (!function_exists('getAllelCombination')) {
    function getAllelCombination($elements) {
        return \App\Functions\SystemFunctions::getAllelCombination($elements);
    }
}

if (!function_exists('getAllelComginationInfo')) {
    function getAllelComginationInfo($data) {
        return \App\Functions\SystemFunctions::getAllelComginationInfo($data);
    }
}

if (!function_exists('find_unmatched_elements')) {
    function find_unmatched_elements($femaleGens, $maleGens) {
        return \App\Functions\SystemFunctions::find_unmatched_elements($femaleGens, $maleGens);
    }
}

if (!function_exists('combine_arrays')) {
    function combine_arrays($array1, $array2) {
        return \App\Functions\SystemFunctions::combine_arrays($array1, $array2);
    }
}

if (!function_exists('find_unmatched_elements_and_filter')) {
    function find_unmatched_elements_and_filter(&$array1, &$array2) {
        return \App\Functions\SystemFunctions::find_unmatched_elements_and_filter($array1, $array2);
    }
}

if (!function_exists('translate_phenotype')) {
    function translate_phenotype($combination, $dictionary) {
        return \App\Functions\SystemFunctions::translate_phenotype($combination, $dictionary);
    }
}

if (!function_exists('translate_additional_genes')) {
    function translate_additional_genes($additional_genes, $dictionary) {
        return \App\Functions\SystemFunctions::translate_additional_genes($additional_genes, $dictionary);
    }
}

if (!function_exists('find_gene_code')) {
    function find_gene_code($gene_name, $dictionary) {
        return \App\Functions\SystemFunctions::find_gene_code($gene_name, $dictionary);
    }
}

if (!function_exists('find_gene_name')) {
    function find_gene_name($gene_code, $dictionary) {
        return \App\Functions\SystemFunctions::find_gene_name($gene_code, $dictionary);
    }
}

if (!function_exists('count_occurrences')) {
    function count_occurrences($nested_array) {
        return \App\Functions\SystemFunctions::count_occurrences($nested_array);
    }
}

if (!function_exists('check_both_parents_dominant_genes')) {
    function check_both_parents_dominant_genes($maleGens, $femaleGens) {
        return \App\Functions\SystemFunctions::check_both_parents_dominant_genes($maleGens, $femaleGens);
    }
}

if (!function_exists('getGenotypeTraitsDictionary')) {
    function getGenotypeTraitsDictionary() {
        return \App\Functions\SystemFunctions::getGenotypeTraitsDictionary();
    }
}

if (!function_exists('matchTraitSet')) {
    function matchTraitSet(array $main_genes_array, array $traitsDictionary, array $combined_additional_genes_str_array = null, $dominant = '') {
        return \App\Functions\SystemFunctions::matchTraitSet($main_genes_array, $traitsDictionary, $combined_additional_genes_str_array, $dominant);
    }
}

if (!function_exists('getGenotypeFinale')) {
    function getGenotypeFinale($maleGens, $femaleGens, $dictionary, $genotypeTraitsDictionary = null) {
        return \App\Functions\SystemFunctions::getGenotypeFinale($maleGens, $femaleGens, $dictionary, $genotypeTraitsDictionary);
    }
}
