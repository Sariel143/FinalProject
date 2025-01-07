<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColumnarController extends Controller
{
    // Function to create the grid
    private function createGrid($text, $keyLength)
    {
        $gridHeight = ceil(strlen($text) / $keyLength);
        $grid = array_fill(0, $gridHeight, array_fill(0, $keyLength, '_'));

        $index = 0;
        for ($r = 0; $r < $gridHeight; $r++) {
            for ($c = 0; $c < $keyLength; $c++) {
                if ($index < strlen($text)) {
                    $grid[$r][$c] = $text[$index++];
                }
            }
        }
        return $grid;
    }

    // Encrypt function
    private function encryptWithColumnar($text, $key, &$grid)
    {
        $keyLength = strlen($key);
        $grid = $this->createGrid($text, $keyLength);

        $keyOrder = [];
        foreach (str_split($key) as $idx => $char) {
            $keyOrder[] = ['char' => $char, 'idx' => $idx];
        }
        usort($keyOrder, function ($a, $b) {
            return strcmp($a['char'], $b['char']);
        });

        $result = '';
        foreach ($keyOrder as $keyCol) {
            $colIdx = $keyCol['idx'];
            foreach ($grid as $row) {
                $result .= $row[$colIdx];
            }
        }
        return $result;
    }

    // Decrypt function
    private function decryptWithColumnar($ciphertext, $key, &$grid)
    {
        $keyLength = strlen($key);
        $gridHeight = ceil(strlen($ciphertext) / $keyLength);

        $keyOrder = [];
        foreach (str_split($key) as $idx => $char) {
            $keyOrder[] = ['char' => $char, 'idx' => $idx];
        }
        usort($keyOrder, function ($a, $b) {
            return strcmp($a['char'], $b['char']);
        });

        $grid = array_fill(0, $gridHeight, array_fill(0, $keyLength, '_'));

        $columnLength = strlen($ciphertext) / $keyLength;
        $index = 0;
        foreach ($keyOrder as $keyCol) {
            $colIdx = $keyCol['idx'];
            for ($r = 0; $r < $gridHeight; $r++) {
                $grid[$r][$colIdx] = $ciphertext[$index++];
            }
        }

        $plaintext = '';
        foreach ($grid as $row) {
            $plaintext .= implode('', $row);
        }

        return rtrim($plaintext, '_');
    }

    public function process(Request $request)
    {
        // Get inputs
        $action = $request->input('action');
        $text = str_replace(' ', '_', $request->input('text'));
        $key1 = $request->input('key1');
        $key2 = $request->input('key2');

        // Validate inputs
        if (!$action || !$text || !$key1 || !$key2) {
            return response()->json(['error' => 'Invalid input.'], 400);
        }

        // Initialize grid and result
        $grid = [];
        $result = '';

        // Check action and proceed with appropriate method
        if ($action == 'encrypt') {
            $result = $this->encryptWithColumnar($text, $key1, $grid);
        } elseif ($action == 'decrypt') {
            $result = $this->decryptWithColumnar($text, $key2, $grid);
        } else {
            return response()->json(['error' => 'Invalid action. Please use "encrypt" or "decrypt".'], 400);
        }

        // Return the result
        return response()->json(['result' => $result]);
    }
}
