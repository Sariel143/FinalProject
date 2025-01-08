<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColumnarController extends Controller
{
    // Encryption process with two keys
    private function encryptWithColumnar($text, $key)
    {
        $columns = strlen($key);
        $rows = ceil(strlen($text) / $columns);
        $grid = array_fill(0, $rows, array_fill(0, $columns, '_'));

        // Fill the grid row by row
        $index = 0;
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $grid[$i][$j] = $index < strlen($text) ? $text[$index++] : '_';
            }
        }

        // Create an array of key positions sorted by key order
        $sortedKey = str_split($key);
        $keyPositions = array_keys($sortedKey);
        asort($sortedKey);
        $sortedPositions = array_keys($sortedKey);

        // Read columns by sorted key order
        $result = '';
        foreach ($sortedPositions as $col) {
            for ($i = 0; $i < $rows; $i++) {
                $result .= $grid[$i][$col];
            }
        }

        return $result;
    }

    // Decryption process with two keys
    private function decryptWithColumnar($text, $key)
    {
        $columns = strlen($key);
        $rows = ceil(strlen($text) / $columns);
        $grid = array_fill(0, $rows, array_fill(0, $columns, '_'));

        // Create an array of key positions sorted by key order
        $sortedKey = str_split($key);
        $keyPositions = array_keys($sortedKey);
        asort($sortedKey);
        $sortedPositions = array_keys($sortedKey);

        // Fill grid by columns in sorted order
        $index = 0;
        foreach ($sortedPositions as $col) {
            for ($i = 0; $i < $rows; $i++) {
                $grid[$i][$col] = $index < strlen($text) ? $text[$index++] : '_';
            }
        }

        // Read rows to decrypt
        $result = '';
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $result .= $grid[$i][$j];
            }
        }

        return rtrim($result, '_');  // Strip trailing padding
    }

    public function process(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'action' => 'required|in:encrypt,decrypt',
            'text' => 'required|string',
            'key1' => 'required|string',
            'key2' => 'required|string',
        ]);

        $action = $validated['action'];
        $text = str_replace(' ', '_', strtoupper($validated['text'])); // Replace spaces and capitalize
        $key1 = strtoupper($validated['key1']);
        $key2 = strtoupper($validated['key2']);

        // Initialize results
        $result1 = '';
        $result2 = '';

        // Encryption or decryption process
        if ($action === 'encrypt') {
            // Encrypt with key1
            $result1 = $this->encryptWithColumnar($text, $key1);
            // Encrypt the result1 with key2
            $result2 = $this->encryptWithColumnar($result1, $key2);
        } elseif ($action === 'decrypt') {
            // Decrypt with key2 (reverse the second encryption)
            $result1 = $this->decryptWithColumnar($text, $key2);
            // Decrypt the result1 with key1 (reverse the first encryption)
            $result2 = $this->decryptWithColumnar($result1, $key1);
        }

        // Return the results
        return response()->json([
            'result1' => $result1,
            'result2' => $result2,
            'action' => $action,
            'key1' => $key1,
            'key2' => $key2,
        ]);
    }
}
