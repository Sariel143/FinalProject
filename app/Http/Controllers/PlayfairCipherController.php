<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayfairCipherController extends Controller
{
    public function cipher(Request $request)
    {
        // Get the text, key, and action (encrypt or decrypt) from the request
        $text = strtoupper(trim($request->input('text')));
        $key = strtoupper(trim($request->input('key')));
        $action = $request->input('action'); // 'encrypt' or 'decrypt'

        // Validate input
        if (empty($text) || empty($key)) {
            return response()->json(['error' => 'Please enter both text and a key.'], 400);
        }

        // Log cleaned input
        \Log::info('Text after cleaning:', ['text' => $text]);
        \Log::info('Key after cleaning:', ['key' => $key]);

        // Perform the encryption or decryption
        $result = $this->playfairCipher($text, $key, $action);

        // Return the result as JSON
        return response()->json(['result' => $result]);
    }

    private function playfairCipher($text, $key, $action)
    {
        // Remove duplicate letters from the key and treat 'J' as 'I'
        $key = $this->removeDuplicateLetters($key);

        // Log the key after duplicate removal
        \Log::info('Key after duplicate removal:', ['key' => $key]);

        // Create the Playfair cipher matrix
        $matrix = $this->generateMatrix($key);

        // Log the matrix for debugging
        \Log::info('Generated Matrix:', ['matrix' => $matrix]);

        // Clean the text (remove non-alphabet characters and make sure it's in uppercase)
        $text = preg_replace("/[^A-Z]/", "", strtoupper($text));

        // If the text has an odd length, append 'X'
        if (strlen($text) % 2 != 0) {
            $text .= 'X';
        }

        // Split the text into digraphs (pairs of two characters)
        $digraphs = $this->splitIntoDigraphs($text);

        // Log the digraphs for debugging
        \Log::info('Digraphs:', ['digraphs' => $digraphs]);

        // Process the digraphs (encryption or decryption)
        $result = '';
        foreach ($digraphs as $digraph) {
            $result .= $this->processDigraph($digraph, $matrix, $action);
        }

        return $result;
    }

    private function removeDuplicateLetters($key)
    {
        $key = str_replace('J', 'I', $key);  // 'J' is treated as 'I' in Playfair cipher
        $key = strtoupper(preg_replace("/[^A-Z]/", "", $key)); // Ensure only alphabet characters

        $keyArray = str_split($key);
        $keyArray = array_unique($keyArray);  // Remove duplicate letters

        return implode('', $keyArray);
    }

    private function generateMatrix($key)
    {
        $alphabet = 'ABCDEFGHIKLMNOPQRSTUVWXYZ';  // 'J' is excluded

        // Create matrix starting with the key
        $matrix = $key . $alphabet;

        // Remove duplicates
        $matrix = str_split($matrix);
        $matrix = array_unique($matrix);

        // Create a 5x5 matrix
        $matrix = array_chunk(array_values($matrix), 5);

        return $matrix;
    }

    private function splitIntoDigraphs($text)
    {
        $digraphs = [];
        $textLength = strlen($text);

        for ($i = 0; $i < $textLength; $i += 2) {
            if ($i + 1 < $textLength) {
                // Check if both letters are the same, add 'X' in between
                if ($text[$i] == $text[$i + 1]) {
                    $digraphs[] = $text[$i] . 'X';
                    $i--;
                } else {
                    $digraphs[] = $text[$i] . $text[$i + 1];
                }
            } else {
                $digraphs[] = $text[$i] . 'X';  // Add 'X' if odd length
            }
        }

        return $digraphs;
    }

    private function processDigraph($digraph, $matrix, $action)
    {
        // Find the positions of the two characters in the matrix
        $positions = [];
        foreach (str_split($digraph) as $char) {
            foreach ($matrix as $rowIdx => $row) {
                foreach ($row as $colIdx => $matrixChar) {
                    if ($matrixChar === $char) {
                        $positions[] = [$rowIdx, $colIdx];
                    }
                }
            }
        }

        // Log the positions for debugging
        \Log::info('Positions of Digraph:', ['positions' => $positions]);

        // Encrypt or decrypt the digraph based on the action
        if ($positions[0][0] === $positions[1][0]) {
            // Same row - shift columns
            $shift = ($action === 'encrypt') ? 1 : -1;
            return $matrix[$positions[0][0]][($positions[0][1] + $shift + 5) % 5] . 
                   $matrix[$positions[1][0]][($positions[1][1] + $shift + 5) % 5];
        } elseif ($positions[0][1] === $positions[1][1]) {
            // Same column - shift rows
            $shift = ($action === 'encrypt') ? 1 : -1;
            return $matrix[($positions[0][0] + $shift + 5) % 5][$positions[0][1]] . 
                   $matrix[($positions[1][0] + $shift + 5) % 5][$positions[1][1]];
        } else {
            // Rectangle - swap columns
            return $matrix[$positions[0][0]][$positions[1][1]] . 
                   $matrix[$positions[1][0]][$positions[0][1]];
        }
    }
}
